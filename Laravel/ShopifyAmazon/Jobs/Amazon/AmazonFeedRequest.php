<?php

namespace App\Jobs\Amazon;

use App\Models\Amazon\AmazonFeed;
use App\Services\Amazon\AmazonFeedService;
use Aws\ServiceQuotas\Exception\ServiceQuotasException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\Middleware\RateLimited;
use App\Models\JobEvent;
use App\Services\JobEventService;
use App\Traits\JobEventDataTrait;

class AmazonFeedRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobEventDataTrait;

    private $configuration;
    private $data;
    private $feedType;
    private $contentType;
    private $additionalData;
    private $jobEventService;
    public $tries = 5;

    public $store_id;

    /**
     * @param $configuration
     * @param mixed $data
     * @param mixed $feedType
     * @param string $contentType
     * @param array $additionalData
     */
    public function __construct($configuration,mixed $data,mixed $feedType, string $contentType, array $additionalData = [])
    {
        $this->configuration = $configuration;
        $this->data = $data;
        $this->feedType = $feedType;
        $this->contentType = $contentType;
        $this->additionalData = $additionalData;
        $this->jobEventService = app(JobEventService::class);
        set_store_configuration($this->configuration->getStoreId());
//        $this->store_id =  $configuration->getStoreId();
        Log::debug('$this->additionalData ', [$this->additionalData]);
    }

//    /**
//     * Get the middleware the job should pass through.
//     *
//     * @return array
//     */
//    public function middleware()
//    {
//        return [new RateLimited('amazon_feed')];
//    }


    public function handle()
    {
        $jobEvent = $this->jobEventService->createJobEventRecord(JobEvent::AMAZON_FEED_REQUEST, $this->job->payload());
        $this->createJobEventData($jobEvent, class_basename($this), $this->configuration->getStoreId());
        $amazonFeedService = new AmazonFeedService($this->configuration);
        $feedId = $amazonFeedService->createUpdateFeed($this->data, $this->contentType, $this->feedType['name']);

        if (!$feedId) {
            $this->release(60 * 5);
            return;
        }
        $localFeed = $this->createDatabaseFeed($feedId);
        Log::debug('$this->configuration->getStoreId(); ', [$this->configuration->getStoreId()]);
        Log::debug('$localFeed ', [$localFeed]);
        Log::debug('$this->feedType ', [$this->feedType]);
        dispatch(new AmazonFeedStatusJob($this->configuration->getStoreId(), $localFeed->id, $this->feedType ))->delay(20);
        $this->jobEventService->successJobEvent($jobEvent->id);
    }

    /**
     * @param string $feedId
     * @return void
     */
    private function createDatabaseFeed(string $feedId) : AmazonFeed
    {
        $updateData = [];
        $updateData["store_id"] = $this->configuration->getStoreId();
        $updateData["feed_id"] = $feedId;
        $updateData["type"] = AmazonFeedService::getStatusType($this->feedType);
        $updateData["status"] = AmazonFeed::STATUSES["IN_PROGRESS"];
        if (!empty($this->additionalData)) {
            $updateData["additional_data"] = json_encode($this->additionalData);
        }
        return AmazonFeed::updateOrCreate(
            [
                "store_id" => $this->configuration->getStoreId(),
                "feed_id" => $feedId,
            ],
            $updateData
        );
    }

    public function failed(\Throwable $exception)
    {
      $this->jobEventService->failedJobEvent(JobEvent::AMAZON_FEED_REQUEST, $exception->getTrace());
      Log::channel('amazon_products')->debug(sprintf('File - %s Line - %s | Error AMAZON_FEED_REQUEST: %s', __FILE__, __LINE__, $exception->getMessage()));
    }
}
