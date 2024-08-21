<?php
declare(strict_types=1);

namespace AL\ProductPassword\Service\ShowPasswordNowValidator;

use AL\ProductPassword\Api\ValidatorInterface;
use AL\ProductPassword\Service\Config;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class IsCategoryProtected
 */
class IsCategoryProtected implements ValidatorInterface
{
    private Config $config;

    private ProductRepositoryInterface $productRepository;

    private RequestInterface $request;

    /**
     * IsCategoryProtected constructor.
     *
     * @param Config $config
     * @param ProductRepositoryInterface $productRepository
     * @param RequestInterface $request
     */
    public function __construct(
        Config $config,
        ProductRepositoryInterface $productRepository,
        RequestInterface $request
    ) {
        $this->config = $config;
        $this->productRepository = $productRepository;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $productId = $this->request->getParam('id');
        $protectedCategories = $this->config->getAssignCategories();

        if (!count($protectedCategories)) {
            return false;
        }

        try {
            $product = $this->productRepository->getById($productId);
            $productCategoryIds = $product->getCategoryIds();

            return !empty(array_intersect($protectedCategories, $productCategoryIds));
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

}
