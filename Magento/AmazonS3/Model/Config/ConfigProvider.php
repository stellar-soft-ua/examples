<?php

declare(strict_types=1);

namespace ArtemLytv\AmazonS3\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ConfigProvider
 */
class ConfigProvider
{
    /** @const string AWS_S3_CONFIG_PREFIX */
    private const AWS_S3_CONFIG_PREFIX = 'ArtemLytv_customer/aws_s3_credentials/';

    /** @const string AWS_S3_CONFIG_PREFIX */
    private const AWS_S3_ACCESS_KEY = self::AWS_S3_CONFIG_PREFIX . 'aws_access_key';

    /** @const string AWS_S3_SECRET_KEY */
    private const AWS_S3_SECRET_KEY = self::AWS_S3_CONFIG_PREFIX . 'aws_secret_key';

    /** @const string AWS_S3_REGION */
    private const AWS_S3_REGION = self::AWS_S3_CONFIG_PREFIX . 'aws_region';

    /** @const string AWS_S3_LAMBDA_FUNCTION */
    private const AWS_S3_LAMBDA_FUNCTION = self::AWS_S3_CONFIG_PREFIX . 'aws_lambda_function';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * ConfigProvider constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string|null
     *
     * @throws NoSuchEntityException
     */
    public function getS3LambdaFunctionName(): ?string
    {
        return $this->scopeConfig->getValue(
            self::AWS_S3_LAMBDA_FUNCTION,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * @return string|null
     *
     * @throws NoSuchEntityException
     */
    public function getAmazonS3AccessKey(): ?string
    {
        return $this->scopeConfig->getValue(
            self::AWS_S3_ACCESS_KEY,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * @return string|null
     *
     * @throws NoSuchEntityException
     */
    public function getAmazonS3SecretKey(): ?string
    {
        return $this->scopeConfig->getValue(
            self::AWS_S3_SECRET_KEY,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * @return string|null
     *
     * @throws NoSuchEntityException
     */
    public function getAmazonS3Region(): ?string
    {
        return $this->scopeConfig->getValue(
            self::AWS_S3_REGION,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * @return int|null
     *
     * @throws NoSuchEntityException
     */
    private function getCurrentStoreId(): ?int
    {
        return (int)$this->storeManager->getStore()->getId() ?? 0;
    }
}
