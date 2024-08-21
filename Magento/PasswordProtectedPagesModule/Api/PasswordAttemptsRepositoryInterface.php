<?php

declare(strict_types=1);

namespace AL\ProductPassword\Api;

use AL\ProductPassword\Api\Data\PasswordAttemptsInterface;
use AL\ProductPassword\Api\Data\PasswordShippingResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @Api
 */
interface PasswordAttemptsRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PasswordShippingResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): PasswordShippingResultInterface;

    /**
     * @param int $customerId
     * @return PasswordAttemptsInterface|null
     */
    public function getAttemptsByCustomerId(int $customerId): ?PasswordAttemptsInterface;

    /**
     * @param PasswordAttemptsInterface $passwordAttempts
     * @return bool
     */
    public function save(PasswordAttemptsInterface $passwordAttempts): bool;

    /**
     * @param PasswordAttemptsInterface $passwordAttempts
     * @return bool
     */
    public function delete(PasswordAttemptsInterface $passwordAttempts): bool;
}
