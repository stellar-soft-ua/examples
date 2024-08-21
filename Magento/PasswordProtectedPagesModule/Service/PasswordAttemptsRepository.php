<?php

declare(strict_types=1);

namespace AL\ProductPassword\Service;

use AL\ProductPassword\Api\Data\PasswordAttemptsInterface;
use AL\ProductPassword\Api\Data\PasswordShippingResultInterface;
use AL\ProductPassword\Api\Data\PasswordShippingResultInterfaceFactory;
use AL\ProductPassword\Api\PasswordAttemptsRepositoryInterface;
use AL\ProductPassword\Model\PasswordAttempts as PasswordAttemptsDomainModel;
use AL\ProductPassword\Model\ResourceModel\PasswordAttempts as PasswordAttemptsResourceModel;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * Class PasswordAttemptsRepository
 */
class PasswordAttemptsRepository implements PasswordAttemptsRepositoryInterface
{
    private PasswordShippingResultInterfaceFactory $passwordShippingResultFactory;

    private CollectionProcessorInterface $collectionProcessor;

    private SearchCriteriaBuilder $searchCriteriaBuilder;

    private PasswordAttemptsResourceModel $resourceModel;

    /**
     * PasswordAttemptsRepository constructor.
     *
     * @param PasswordShippingResultInterfaceFactory $passwordShippingResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PasswordAttemptsResourceModel $resourceModel
     */
    public function __construct(
        PasswordShippingResultInterfaceFactory $passwordShippingResultFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PasswordAttemptsResourceModel $resourceModel
    ) {
        $this->passwordShippingResultFactory = $passwordShippingResultFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resourceModel = $resourceModel;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PasswordShippingResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): PasswordShippingResultInterface
    {
        $searchResult = $this->passwordShippingResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $this->collectionProcessor->process($searchCriteria, $searchResult);

        return $searchResult;
    }

    /**
     * @param int $customerId
     * @return PasswordAttemptsInterface|null
     */
    public function getAttemptsByCustomerId(int $customerId): ?PasswordAttemptsInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(PasswordAttemptsDomainModel::CUSTOMER_ID, $customerId)
            ->create();
        $passwordAttempt = $this->getList($searchCriteria)->getItems();

        return \array_shift($passwordAttempt);
    }

    /**
     * @param PasswordAttemptsInterface $passwordAttempts
     * @return bool
     * @throws AlreadyExistsException
     */
    public function save(PasswordAttemptsInterface $passwordAttempts): bool
    {
        $this->resourceModel->save($passwordAttempts);

        return true;
    }

    /**
     * @param PasswordAttemptsInterface $passwordAttempts
     * @return bool
     * @throws Exception
     */
    public function delete(PasswordAttemptsInterface $passwordAttempts): bool
    {
        $this->resourceModel->delete($passwordAttempts);

        return true;
    }
}
