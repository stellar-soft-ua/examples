<?php

declare(strict_types=1);

namespace ArtemLytv\TrustPilot\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Client\Curl as CurlClient;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use ArtemLytv\TrustPilot\Model\ResourceModel\ReviewItem as ReviewItemResource;
use ArtemLytv\TrustPilot\Model\ReviewItemFactory;
use Laminas\Http\Request;

/**
 * Class ConnectorStore for working with TrustPilot API
 */
class ConnectorStore
{
    /** @const string XML_BUSINESS_UNITS_URL_KEY */
    private const XML_BUSINESS_UNITS_URL_KEY = 'artemlytv_trustpilot/credentials/business_units_url_key';

    /** @const string ERROR_UNKNOWN_METHOD */
    private const ERROR_UNKNOWN_METHOD = 'Unknown HTTP method';

    /** @const string KEY_CONFIG_PATH */
    private const KEY_CONFIG_PATH = 'artemlytv_trustpilot/credentials/key';

    /**
     * @param JsonSerializer $serializer
     * @param CurlFactory $curlFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param ReviewItemFactory $reviewItemFactory
     * @param ReviewItemResource $reviewItemResource
     */
    public function __construct(
        private JsonSerializer $serializer,
        private CurlFactory $curlFactory,
        private ScopeConfigInterface $scopeConfig,
        private ReviewItemFactory $reviewItemFactory,
        private ReviewItemResource $reviewItemResource
    ) {}

    /**
     * Fetches reviews from TrustPilot and stores them locally.
     *
     * @param string $method
     * @return void
     * @throws LocalizedException
     */
    public function getReviews(string $method): void
    {
        $headers = $this->prepareHeaders();

        if (!($businessUnitUrl = $this->scopeConfig->getValue(self::XML_BUSINESS_UNITS_URL_KEY))) {
            throw new LocalizedException(__('Trustpilot url is missing'));
        }

        $page = 1;

        do {
            $body = $this->prepareRequestBody($page);
            $loadedReviews = $this->sendRequest($businessUnitUrl, $method, $body, $headers);
            $reviewsUnitsArray = $loadedReviews['reviews'] ?? [];

            foreach ($reviewsUnitsArray as $reviewUnit) {
                if (!$this->isReviewExist($reviewUnit['id'])) {
                    $this->saveReviewItem($reviewUnit);
                }
            }

            $page++;
        } while (\count($reviewsUnitsArray) === 100);
    }

    /**
     * Prepares headers for the API request.
     *
     * @return array
     */
    private function prepareHeaders(): array
    {
        return [
            'apiKey' => $this->scopeConfig->getValue(self::KEY_CONFIG_PATH),
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * Prepares the body for the API request.
     *
     * @param int $page
     * @return array
     */
    private function prepareRequestBody(int $page): array
    {
        return [
            'state' => 'published',
            'page' => $page,
            'perPage' => 100,
            'orderBy' => 'createdat.asc'
        ];
    }

    /**
     * Checks if a review already exists in the database.
     *
     * @param string $reviewId
     * @return bool
     */
    private function isReviewExist(string $reviewId): bool
    {
        /* Here's used MySQL query to improve performance as there can be a lot of reviews */
        $connection = $this->reviewItemResource->getConnection();
        $select = $connection->select()
            ->from($this->reviewItemResource->getMainTable(), 'reviewd_id')
            ->where('reviewd_id = :reviewd_id');
        $bind = ['reviewd_id' => $reviewId];

        return (bool)$connection->fetchOne($select, $bind);
    }

    /**
     * Saves a review item to the database.
     *
     * @param array $reviewUnit
     */
    private function saveReviewItem(array $reviewUnit): void
    {
        $reviewItem = $this->reviewItemFactory->create([
            'data' => [
                'reviewd_id' => $reviewUnit['id'],
                'name' => $reviewUnit['consumer']['displayName'],
                'title' => $reviewUnit['title'],
                'text' => $reviewUnit['text'],
                'date' => $reviewUnit['createdAt'],
                'stars' => $reviewUnit['stars'],
                'language' => $reviewUnit['language'],
                'status' => $reviewUnit['status'],
            ]
        ]);
        $this->reviewItemResource->save($reviewItem);
    }

    /**
     * Sends an API request.
     *
     * @param string $url
     * @param string $method
     * @param array|null $body
     * @param array $headers
     * @return array
     * @throws LocalizedException
     */
    public function sendRequest(string $url, string $method, array $body = null, array $headers = []): array
    {
        /** @var CurlClient $curl */
        $curl = $this->curlFactory->create();
        $curl->setOption(CURLOPT_RETURNTRANSFER, true);

        foreach ($headers as $key => $value) {
            $curl->addHeader($key, $value);
        }

        if ($body) {
            $this->setRequestBody($curl, $method, $body, $url);
        }

        $this->executeCurl($curl, $url, $method, $body);
        $response = $curl->getBody();

        if (!\in_array($curl->getStatus(), [200, 201, 202])) {
            $this->processResponseError($response);
        }

        return $this->serializer->unserialize($response, true);
    }

    /**
     * Sets the request body for the CURL client.
     *
     * @param CurlClient $curl
     * @param string $method
     * @param array|null $body
     * @param string $url
     */
    private function setRequestBody(CurlClient $curl, string $method, array $body = null, string &$url): void
    {
        if (\in_array($method, [Request::METHOD_PUT, Request::METHOD_POST])) {
            $curl->setOption(CURLOPT_POSTFIELDS, \http_build_query($body));
        } elseif ($method === Request::METHOD_GET) {
            $url .= '?' . \http_build_query($body);
        }
    }

    /**
     * Executes the CURL request.
     *
     * @param CurlClient $curl
     * @param string $url
     * @param string $method
     * @param array|null $body
     * @throws LocalizedException
     */
    private function executeCurl(CurlClient $curl, string $url, string $method, array $body = null): void
    {
        switch ($method) {
            case Request::METHOD_POST:
                $curl->post($url, $body);

                break;
            case Request::METHOD_GET:
                $curl->get($url);

                break;
            case Request::METHOD_DELETE:
                $curl->delete($url);

                break;
            default:
                throw new LocalizedException(__(self::ERROR_UNKNOWN_METHOD));
        }
    }

    /**
     * Processes response error.
     *
     * @param string $response
     * @throws LocalizedException
     */
    private function processResponseError(string $response): void
    {
        try {
            $responseData = $this->serializer->unserialize($response);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Response body is corrupted.'));
        }

        $responseCode = $responseData['code'] ?? false;
        $responseMessages = $responseData['messages'] ?? [];
        $errorDetails = empty($responseMessages)
            ? __('No details about error provided.')
            : __(\implode(', ', $responseMessages));

        if (!$responseCode) {
            throw new LocalizedException(__('No response code provided. %1', $errorDetails));
        }

        throw new LocalizedException(__($errorDetails));
    }
}
