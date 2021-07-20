<?php
namespace Tests\Feature\Preshipping;

use App\Http\Controllers\OrderController;
use App\Interfaces\Objects\DataType\IDateTime;
use App\Interfaces\Objects\Customer\IScheduledCall;
use App\Interfaces\Objects\Preshipping\IPreshippingFlow;
use App\Interfaces\QueryServices\IPreshippingFeedbackReasonQueryService;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tests\BaseTestCase;

class PreshippingFlowTest extends BaseTestCase
{
    /**
     * @var OrderController
     */
    private $orderController;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->orderController = app(OrderController::class);
    }

    /** 
     * Test the helper method which must determine if there's
     * a call in the future or within the last 48 hours
     * 
     * @test
     * @return void
     */
    public function hasUpcomingOrRecentCall(): void
    {
        $customer = $this->customer(true);
        $order = $this->order(true);

        $this->assertFalse($this->preshippingService->hasUpcomingOrRecentCall($order));

        $call = app(IScheduledCall::class)
            ->setUserId($customer->getId())
            ->setCallAt(dateTime('-72 Hours')->format())
            ->save();

        // Ensure calls too far in the past don't count
        $this->assertFalse($this->preshippingService->hasUpcomingOrRecentCall($order));

        // Test for customer upcoming call
        $call->setCallAt(dateTime('+1 Hours')->format())->save();

        $this->assertTrue($this->preshippingService->hasUpcomingOrRecentCall($order));

        // Test for future calls
        $call->setCallAt(dateTime('+47 Hours')->format())->save();

        $this->assertTrue($this->preshippingService->hasUpcomingOrRecentCall($order));
    }

    /**
     * @test
     */
    public function sendPreshippingNotification()
    {
        $this->customer();
        $order = $this->order(true);

        $this->orderController->preshippingTextNotification(new Request(), $order->getId());

        $sentEmailOrder = Order::where('woocommerce_order_id', $order->getId())->first();

        $this->assertNotEmpty($sentEmailOrder->preshipping_email_at);

        $flow = app(IPreshippingFlow::class)->find($order->getId());
        $this->assertTrue($flow->isFirstSmsSent());
    }

    /**
     * @test
     */
    public function sendPreshippingNotificationAfterResetFlow(): void
    {
        $this->customer();
        $order = $this->order(true);

        $this->preshippingService->logFirstSmsSent($order);

        $this->preshippingService->resetPreshippingFlow($order);

        $this->preshippingService->logFirstSmsSent($order);

        $flow = app(IPreshippingFlow::class)->find($order->getId());

        $this->assertTrue($flow->isFirstSmsSent());
    }

    /**
     * T+1
     * @test
     */
    public function sendReminderSms()
    {
        $order = $this->order(true);

        $this->preshippingService->logFirstSmsSent($order);

        $flow = app(IPreshippingFlow::class)->find($order->getId());
        $flow->first_sms_sent_at = app(IDateTime::class)
            ->set(Carbon::now()->getTimestamp())
            ->addDays(-1)->format();
        $flow->save();

        $this->preshippingService->sendReminderMessage();

        $flow = $flow->refresh();
        $this->assertTrue($flow->isReminderSmsSent());
    }

    /**
     * T+2
     *
     * @test
     */
    public function sendReminderEmail()
    {
        $order = $this->order(true);

        $this->preshippingService->logFirstSmsSent($order);

        $flow = app(IPreshippingFlow::class)->find($order->getId());
        $flow->reminder_sms_sent_at = app(IDateTime::class)->set(Carbon::now()->getTimestamp())
            ->addDays(-1)->format();
        $flow->save();

        $this->preshippingService->sendReminderEmail();

        $flow = $flow->refresh();
        $this->assertTrue($flow->isReminderEmailSent());
    }

    /**
     * T+2+2
     *
     * @test
     */
    public function sendCancellationReminder()
    {
        $order = $this->order(true);

        $this->preshippingService->logFirstSmsSent($order);

        $flow = app(IPreshippingFlow::class)->find($order->getId());
        $flow->reminder_email_sent_at = app(IDateTime::class)->set(Carbon::now()->getTimestamp())->addDays(-1)->format();
        $flow->first_sms_sent_at = app(IDateTime::class)->set(Carbon::now()->getTimestamp())->addDays(-3)->format();
        $flow->save();

        $this->preshippingService->sendCancellationReminder();

        $flow = $flow->refresh();

        $this->assertNotEmpty($flow->cancellation_reminder_sms_sent_at);
        $this->assertNotEmpty($flow->cancellation_reminder_email_sent_at);
    }

    /**
     * Do cancel a second PS after 5 days, if no response is provided.
     *
     * @test
     */
    public function cancelPreshipping(): void
    {
        $customer = $this->customer();
        $order = $this->order(true);

        $this->preshippingService->logFirstSmsSent($order);

        $call = app(IScheduledCall::class)
            ->setUserId($customer->getId())
            ->setCallAt(dateTime('-48 Hours')->format())
            ->setOrder($order)
            ->save();

        try {
            $this->preshippingService->processCancelRequests($order->getId());
        } catch (\Exception $exception) { }

        $flow = app(IPreshippingFlow::class)->find($order->getId());

        $this->assertTrue($flow->isCancelled());
    }

    /**
     * Do not cancel PS after 5 days when a phone call/new PS is ordered.
     *
     * @test
     */
    public function notCancelPreshipping(): void
    {
        $customer = $this->customer();
        $order = $this->order(true);

        $this->preshippingService->logFirstSmsSent($order);

        $call = app(IScheduledCall::class)
            ->setUserId($customer->getId())
            ->setCallAt(dateTime('+48 Hours')->format())
            ->setOrder($order)
            ->save();

        try {
            $this->preshippingService->processCancelRequests($order->getId());
        } catch (\Exception $exception) { }

        $flow = app(IPreshippingFlow::class)->find($order->getId());

        $this->assertFalse($flow->isCancelled());
    }

    /**
     * Check if we are showing the products of both PS when the stylist opens the model for styling.
     *
     * @test
     */
    public function showProductsFromPreshippingRequests(): void
    {
        $feedbackReasonQueryService = app(IPreshippingFeedbackReasonQueryService::class);

        $order = $this->order(true);

        $variant = $this->products->getVariant(42965);

        $this->preshippingService->logFirstSmsSent($order);

        $feedbackReasonQueryService->feedback($order, $variant->product(), 0, 1, 'Comment', $variant);

        $this->preshippingService->resetPreshippingFlow($order);

        $variant = $this->products->getVariant(42918);

        $this->preshippingService->logFirstSmsSent($order);

        $feedbackReasonQueryService->feedback($order, $variant->product(), 0, 1, 'Comment', $variant);

        $this->assertEquals($feedbackReasonQueryService->getOrdersFeedback($order)->count(), 2);
    }
}
