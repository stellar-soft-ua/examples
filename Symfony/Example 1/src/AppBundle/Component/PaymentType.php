<?php

namespace AppBundle\Component;

class PaymentType
{
    private $title;
    private $paymentItems;

    public function __construct(string $title, array $paymentItems)
    {
        $this->title = $title;
        $this->paymentItems = $paymentItems;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPaymentItems(): array
    {
        return $this->paymentItems;
    }

    public function setPaymentItems(array $paymentItems)
    {
        $this->paymentItems = $paymentItems;
    }
}