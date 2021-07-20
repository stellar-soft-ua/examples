<?php

namespace Tests\Integration\Service;

use App\Interfaces\Objects\Accounting\IOrderBalanceRequest;
use App\Interfaces\Services\Order\IOrderFeeService;
use Tests\BaseTestCase;

class OrderFeeService extends BaseTestCase
{
    /** @var IOrderFeeService */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = app(IOrderFeeService::class);
    }

    /**
     * @test
     */
    public function addDunningFee()
    {
        $order = $this->order(true);
        $this->service->addDunningFee($order, 1);
        $this->assertEquals(app(IOrderBalanceRequest::class)->whereOrderId($order->getId())->count(), 1);
    }
}
