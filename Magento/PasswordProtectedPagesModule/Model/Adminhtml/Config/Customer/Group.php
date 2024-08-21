<?php
declare(strict_types=1);

namespace AL\ProductPassword\Model\Adminhtml\Config\Customer;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

class Group implements OptionSourceInterface
{
    private GroupRepositoryInterface $customerGroupRepository;

    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Group constructor.
     * @param GroupRepositoryInterface $customerGroupRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        GroupRepositoryInterface $customerGroupRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->customerGroupRepository = $customerGroupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        $optionsArray = [];
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $groups = $this->customerGroupRepository->getList($searchCriteria)->getItems();
        foreach ($groups as $group) {
            $optionsArray[] = [
                'value' => $group->getId(),
                'label' => $group->getCode(),
            ];
        }

        return $optionsArray;
    }
}
