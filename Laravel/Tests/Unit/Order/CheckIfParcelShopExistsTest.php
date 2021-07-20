<?php

namespace Tests\Unit\Order;

use App\Interfaces\Services\Shipping\IShippingMethodService;
use Tests\BaseTestCase;

class CheckIfParcelShopExistsTest extends BaseTestCase
{
    /** @test */
    public function assertBoolReturned(): void
    {
        $this->assertIsBool(
            app(IShippingMethodService::class)
                ->checkIfParcelShopExists($this->order())
        );
    }
}
