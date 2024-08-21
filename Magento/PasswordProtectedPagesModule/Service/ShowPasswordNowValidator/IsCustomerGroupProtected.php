<?php
declare(strict_types=1);

namespace AL\ProductPassword\Service\ShowPasswordNowValidator;

use AL\ProductPassword\Api\ValidatorInterface;
use AL\ProductPassword\Service\Config;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Class IsCustomerGroupProtected
 */
class IsCustomerGroupProtected implements ValidatorInterface
{
    private Config $config;

    private CustomerSession $customerSession;

    /**
     * IsCustomerGroupProtected constructor.
     *
     * @param Config $config
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Config $config,
        CustomerSession $customerSession
    ) {
        $this->config = $config;
        $this->customerSession = $customerSession;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $configCustomerGroups = $this->config->getCustomerGroups();

        if (!count($configCustomerGroups)) {
            return false;
        }

        $customerGroup = $this->customerSession->getCustomerGroupId();

        return in_array($customerGroup, $configCustomerGroups);
    }

}
