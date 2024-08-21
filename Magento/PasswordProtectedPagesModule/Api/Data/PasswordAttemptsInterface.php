<?php
declare(strict_types=1);

namespace AL\ProductPassword\Api\Data;

/**
 * @Api
 */
interface PasswordAttemptsInterface
{
    /**
     * @return int
     */
    public function getPasswordAttempts(): int;

    /**
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * @param int $attempt
     * @return void
     */
    public function setPasswordAttempts(int $attempt);

    /**
     * @param int $customerId
     * @return void
     */
    public function setCustomerId(int $customerId);
}
