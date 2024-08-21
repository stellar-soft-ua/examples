<?php
declare(strict_types=1);

namespace AL\ProductPassword\Model;

use Magento\Framework\Model\AbstractModel;
use AL\ProductPassword\Model\ResourceModel\PasswordAttempts as PasswordAttemptsResourceModel;
use AL\ProductPassword\Api\Data\PasswordAttemptsInterface;

class PasswordAttempts extends AbstractModel implements PasswordAttemptsInterface
{
    const PASSWORD_ATTEMPTS = 'attempts';
    const CUSTOMER_ID = 'customer_id';
    const ATTEMPTS_COUNT = 3;

    /**
     * Initialize domain model
     */
    protected function _construct()
    {
        $this->_init(PasswordAttemptsResourceModel::class);
    }

    /**
     * @return int
     */
    public function getPasswordAttempts(): int
    {
        return $this->getData(self::PASSWORD_ATTEMPTS);
    }

    /**
     * @param int $attempt
     */
    public function setPasswordAttempts(int $attempt)
    {
        $this->setData(self::PASSWORD_ATTEMPTS, $attempt);
    }

    public function getCustomerId(): int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setCustomerId(int $customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
