<?php

declare(strict_types=1);

namespace ArtemLytv\AmazonS3\Service;

use Aws\Lambda\LambdaClient;
use Aws\Result;
use Aws\Sdk;
use Exception;
use ArtemLytv\AmazonS3\Model\Config\ConfigProvider;
use Psr\Log\LoggerInterface;

/**
 * Class AwsS3Service
 */
class AwsS3Service
{
    /**
     * @var Sdk
     */
    private $awsSdk;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var LambdaClient|null
     */
    private $lambdaClient;

    /**
     * AwsS3Service constructor.
     *
     * @param Sdk $awsSdk
     * @param LoggerInterface $logger
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        Sdk $awsSdk,
        LoggerInterface $logger,
        ConfigProvider $configProvider
    ) {
        $this->awsSdk = $awsSdk;
        $this->logger = $logger;
        $this->configProvider = $configProvider;
    }

    /**
     * @return LambdaClient|null
     */
    public function getLambdaClient(): ?LambdaClient
    {
        if (!$this->lambdaClient) {
            $this->initializeLambdaClient();
        }

        return $this->lambdaClient;
    }

    /**
     * @param string $payload
     *
     * @return Result|string
     */
    public function invokeLambdaClient(string $payload)
    {
        $this->getLambdaClient();

        try {
            return $this->lambdaClient->invoke([
                'FunctionName' => $this->configProvider->getS3LambdaFunctionName(),
                'Payload' => $payload,
            ]);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return '';
    }

    /**
     * @return void
     */
    private function initializeLambdaClient(): void
    {
        try {
            $this->lambdaClient = $this->awsSdk->createLambda([
                'version' => 'latest',
                'region' => $this->configProvider->getAmazonS3Region(),
                'credentials' => [
                    'key' => $this->configProvider->getAmazonS3AccessKey(),
                    'secret' => $this->configProvider->getAmazonS3SecretKey(),
                ],
            ]);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
