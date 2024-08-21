<?php
declare(strict_types=1);

namespace AL\ProductPassword\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
use AL\ProductPassword\Api\Data\PasswordAttemptsInterface;

/**
 * @Api
 */
interface PasswordShippingResultInterface extends SearchResultsInterface
{
    /**
     * @return \AL\ProductPassword\Api\Data\PasswordAttemptsInterface[]
     */
    public function getItems();

    /**
     * @param \AL\ProductPassword\Api\Data\PasswordAttemptsInterface[] $items
     * @return SearchResultsInterface
     */
    public function setItems(array $items);
}
