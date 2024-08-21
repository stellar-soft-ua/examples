<?php
declare(strict_types=1);

namespace AL\ProductPassword\Model\Adminhtml\Config\Category;

use Magento\Catalog\Api\CategoryListInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;

class Category implements OptionSourceInterface
{
    private CategoryListInterface $categoryList;

    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Category constructor.
     * @param CategoryListInterface $categoryList
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->categoryList = $categoryList;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $optionsArray = [];
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $categories = $this->categoryList->getList($searchCriteria)->getItems();
        foreach ($categories as $category) {
            $optionsArray[] = [
                'value' => $category->getId(),
                'label' => $category->getName(),
            ];
        }

        return $optionsArray;
    }
}
