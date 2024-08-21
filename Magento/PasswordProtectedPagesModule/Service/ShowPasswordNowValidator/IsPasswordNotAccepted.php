<?php
declare(strict_types=1);

namespace AL\ProductPassword\Service\ShowPasswordNowValidator;

use AL\ProductPassword\Api\ValidatorInterface;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Class IsPasswordNotAccepted
 */
class IsPasswordNotAccepted implements ValidatorInterface
{
    private CustomerSession $customerSession;

    /**
     * IsPasswordNotAccepted constructor.
     *
     * @param CustomerSession $customerSession
     */
    public function __construct(CustomerSession $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $isPasswordAccepted = (bool)$this->customerSession->getIsPasswordAccepted();

        return !$isPasswordAccepted;
    }
}
