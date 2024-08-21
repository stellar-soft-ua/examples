<?php

declare(strict_types=1);

namespace ArtemLytv\AmazonS3\Service;

use Exception;
use Aws\Result;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Stdlib\ArrayManager;

/**
 * Class S3FileExtractor
 */
class S3FileExtractor
{
    /**
     * @var AwsS3Service
     */
    private $awsS3Service;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * S3FileExtractor constructor.
     *
     * @param AwsS3Service $awsS3Service
     * @param LoggerInterface $logger
     * @param SerializerInterface $serializer
     */
    public function __construct(
        AwsS3Service $awsS3Service,
        LoggerInterface $logger,
        SerializerInterface $serializer
    ) {
        $this->awsS3Service = $awsS3Service;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    /**
     * @param string $accountId
     * @param string $fileName
     *
     * @return string
     */
    public function getExternalFileLink(string $accountId, string $fileName): string
    {
        $payload = $this->buildPayload([
            'accountId' => $accountId,
            'filename' => $fileName
        ]);
        $result = $this->awsS3Service->invokeLambdaClient($payload);

        return empty($result) ? $result : $this->parseResult($result);
    }

    /**
     * @param Result $result
     *
     * @return string|null
     */
    private function parseResult(Result $result)
    {
        try {
            $bodyResult = $result->get('Payload')->__toString();
            $parsedResult = $this->serializer->unserialize($bodyResult);

            return $this->serializer->unserialize($parsedResult['body'])['url'];
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return '';
        }
    }

    /**
     * @param array $data
     *
     * @return string
     */
    private function buildPayload(array $data): string
    {
        return $this->serializer->serialize($data);
    }
}
