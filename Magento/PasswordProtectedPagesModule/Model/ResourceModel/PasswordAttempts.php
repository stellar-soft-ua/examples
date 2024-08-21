<?php

declare(strict_types=1);

namespace AL\ProductPassword\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PasswordAttempts extends AbstractDb
{
    const PASSWORD_ATTEMPTS_TABLE = 'al_customer_attempts_password';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(self::PASSWORD_ATTEMPTS_TABLE, 'entity_id');
    }
}
