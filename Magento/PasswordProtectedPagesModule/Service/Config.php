<?php
declare(strict_types=1);

namespace AL\ProductPassword\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 */
class Config
{
    /** @const string */
    public const IS_ENABLED_PATH = 'catalog/al_product_password/enabled';

    /** @const string */
    public const PASSWORD_PATH = 'catalog/al_product_password/password_product_page';

    /** @const string */
    public const CATEGORIES_PROTECTED_PATH = 'catalog/al_product_password/category_multiselect';

    /** @const string */
    public const CUSTOMER_GROUPS_PROTECTED_PATH = 'catalog/al_product_password/customer_group_list';

    private ScopeConfigInterface $scopeConfig;

    /**
     * ConfigData constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return (bool) $this->scopeConfig->getValue(self::IS_ENABLED_PATH);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->scopeConfig->getValue(self::PASSWORD_PATH);
    }

    /**
     * @return array
     */
    public function getAssignCategories(): array
    {
        $assignCategories = $this->scopeConfig->getValue(self::CATEGORIES_PROTECTED_PATH) ;

        return ($assignCategories) ? \explode(',', $assignCategories) : [];
    }

    /**
     * @return array
     */
    public function getCustomerGroups(): array
    {
        $assignCustomerGroups = $this->scopeConfig->getValue(self::CUSTOMER_GROUPS_PROTECTED_PATH);

        return ($assignCustomerGroups) ? \explode(',', $assignCustomerGroups) : [];
    }
}
