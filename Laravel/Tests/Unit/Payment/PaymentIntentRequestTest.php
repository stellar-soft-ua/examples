<?php

namespace Tests\Unit\Payment;

use App\Interfaces\Objects\Payment\IPaymentIntentRequest;
use Tests\BaseTestCase;

class PaymentIntentRequestTest extends BaseTestCase
{
    /**
     * @var IPaymentIntentRequest
     */
    protected $paymentIntentRequest;

    /**
     * set up the test..
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->paymentIntentRequest = app(IPaymentIntentRequest::class);
    }

    /** @test */
    public function assertPaymentIntentRequestSupportsSofort(): void
    {
        $this->assertFalse($this->paymentIntentRequest->payingWithSofort());

        $this->paymentIntentRequest->payWithSofort();

        $this->assertTrue($this->paymentIntentRequest->payingWithSofort());
    }
}
