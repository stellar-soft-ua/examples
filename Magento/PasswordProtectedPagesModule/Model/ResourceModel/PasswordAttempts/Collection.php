<?php
declare(strict_types=1);

namespace AL\ProductPassword\Model\ResourceModel\PasswordAttempts;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AL\ProductPassword\Model\ResourceModel\PasswordAttempts as PasswordAttemptsResourceModel;
use AL\ProductPassword\Model\PasswordAttempts;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use AL\ProductPassword\Api\Data\PasswordShippingResultInterface;
use \Exception;

class Collection extends AbstractCollection implements PasswordShippingResultInterface
{
    private SearchCriteriaInterface $searchCriteria;

    /**
     * Initialize collection model
     */
    protected function _construct()
    {
        $this->_init(PasswordAttempts::class, PasswordAttemptsResourceModel::class);
    }

    /**
     * @param array $items
     * @return $this|SearchResultsInterface
     * @throws Exception
     */
    public function setItems(array $items)
    {
        if (!$items) {
            return $this;
        }
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }
}
