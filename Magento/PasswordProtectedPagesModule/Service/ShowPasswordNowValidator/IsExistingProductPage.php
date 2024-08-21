<?php
declare(strict_types=1);

namespace AL\ProductPassword\Service\ShowPasswordNowValidator;

use AL\ProductPassword\Api\ValidatorInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class IsExistingProductPage
 */
class IsExistingProductPage implements ValidatorInterface
{
    /** @const string */
    const PRODUCT_PAGE_FULL_ACTION_NAME = 'catalog_product_view';

    private ProductRepositoryInterface $productRepository;

    private RequestHttp $requestHttp;

    /**
     * IsExistingProductPage constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param RequestHttp $requestHttp
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        RequestHttp $requestHttp
    ) {
        $this->productRepository = $productRepository;
        $this->requestHttp = $requestHttp;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if ($this->requestHttp->getFullActionName() !== self::PRODUCT_PAGE_FULL_ACTION_NAME){
            return false;
        }

        $productId = $this->requestHttp->getParam('id');

        try {
            $product = $this->productRepository->getById($productId);

            return (bool)$product->getSku();
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

}
