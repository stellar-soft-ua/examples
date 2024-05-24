<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SellingPartnerApi\Api\FeedsV20210630Api;
use SellingPartnerApi\ApiException;
use SellingPartnerApi\Model\FeedsV20210630\CreateFeedDocumentSpecification;
use SellingPartnerApi\Model\FeedsV20210630\CreateFeedSpecification;
use SellingPartnerApi\Model\FeedsV20210630\FeedDocument;

class AmazonFeedService extends AmazonService
{
    /**
     * @param string $feedId
     * @return void
     */
    public function cancelFeed(string $feedId)
    {
        $api = new FeedsV20210630Api($this->config);

        try {
            $api->cancelFeed($feedId);
        } catch (ApiException $exception) {
            Log::error(__CLASS__ . ' Cancel feed exception: ' . $exception->getMessage());
        }
    }

    /**
     * @param mixed $data
     * @param string $contentType
     * @param string $amazonFeedType
     * @return string
     */
    public function createUpdateProductFeed($data, string $contentType, string $amazonFeedType): string
    {
        $api = new FeedsV20210630Api($this->config);

        [$documentUrl, $documentId] = $this->createFeedDocument($api, $contentType);

        $this->uploadFeedDocument($documentUrl, $data, $contentType);

        return $this->createFeed($api, $documentId, $amazonFeedType);
    }

    /**
     * @param string $feedDocumentId
     * @return string
     */
    public function getFeedIdFromReportDocument(string $feedDocumentId): string
    {
        $feedsApi = new FeedsV20210630Api($this->config);

        try {
            $result = $feedsApi->getFeedDocument($feedDocumentId);
            $documentUrl = $result->getUrl();
            $compressionAlgo = $result->getCompressionAlgorithm();

        } catch (ApiException $exception) {
            Log::error(__CLASS__ . ' Get Feed Document Report Exception: ' . $exception->getMessage());
            return '';
        }

        if ($compressionAlgo === FeedDocument::COMPRESSION_ALGORITHM_GZIP) {
            $documentResponse = Http::withOptions(['decode-content' => 'gzip'])->get($documentUrl)->body();
            $documentResponse = @gzdecode($documentResponse);
            $documentResponse = json_decode(str_replace('\\', '', $documentResponse), true);

            return $documentResponse['header']['feedId'];
        }

        $documentResponse = Http::get($documentUrl)->json();

        return $documentResponse['header']['feedId'];
    }

    /**
     * @param FeedsV20210630Api $api
     * @param string $contentType
     * @return array
     */
    private function createFeedDocument(FeedsV20210630Api $api, string $contentType): array
    {
        try {
            $documentResponse = $api->createFeedDocument(
                new CreateFeedDocumentSpecification(['content_type' => $contentType])
            );
            $documentId = $documentResponse->getFeedDocumentId();
            $uploadUrl = $documentResponse->getUrl();

            return [$uploadUrl, $documentId];
        } catch (ApiException $exception) {
            Log::error(__CLASS__ . ' Error when creating document', ['exception' => $exception->getMessage()]);
            return [];
        }
    }

    /**
     * @param string $url
     * @param mixed $data
     * @param string $contentType
     * @return void
     */
    private function uploadFeedDocument(string $url, $data, string $contentType)
    {
        if ($contentType === 'application/json') {
            $response = Http::withHeaders([
                'Content-Type' => $contentType
            ])->put($url, $data);
        } else {
            $response = Http::withHeaders([
                'Content-Type' => $contentType
            ])->withBody($data, $contentType)->put($url);
        }

        if (!$response->successful()) {
            Log::error(
                'Problem with uploading feed data',
                ['data' => $data, 'url' => $url, 'response' => $response->body()]
            );
        }
    }

    /**
     * @param FeedsV20210630Api $api
     * @param string $documentId
     * @param string $feedType
     * @return string
     */
    private function createFeed(FeedsV20210630Api $api, string $documentId, string $feedType): string
    {
        $createFeedSpecification = new CreateFeedSpecification([
            'feed_type' => $feedType,
            'marketplace_ids' => [$this->configuration->getMarketplaceId()],
            'input_feed_document_id' => $documentId,
        ]);

        try {
            return $api->createFeed($createFeedSpecification)->getFeedId();
        } catch (ApiException $exception) {
            Log::error(__CLASS__ . ' Error when creating feed', ['exception' => $exception->getMessage()]);
        }

        return '';
    }
}
