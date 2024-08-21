<?php

declare(strict_types=1);

namespace AL\ProductPassword\Observer;

use AL\ProductPassword\Service\PasswordAttemptsRepository;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CustomerLoginAfter implements ObserverInterface
{
    /**
     * @var PasswordAttemptsRepository
     */
    private PasswordAttemptsRepository $passwordAttemptsRepository;

    /**
     * @param PasswordAttemptsRepository $passwordAttemptsRepository
     */
    public function __construct(
        PasswordAttemptsRepository $passwordAttemptsRepository
    ) {
        $this->passwordAttemptsRepository = $passwordAttemptsRepository;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $customerAttempts = $this->passwordAttemptsRepository->getAttemptsByCustomerId($customer->getId());
        $this->passwordAttemptsRepository->delete($customerAttempts);
    }
}
