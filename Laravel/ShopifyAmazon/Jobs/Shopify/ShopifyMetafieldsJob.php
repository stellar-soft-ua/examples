<?php

namespace App\Jobs\Shopify;

use App\Models\JobEvent;
use App\Services\JobEventService;
use App\Services\Shopify\ShopifyProductService;
use App\Services\ShopifyGraphql\ShopifyGraphqlProductService;
use App\Traits\JobEventDataTrait;
use App\Traits\ProductMetafieldTrait;
use App\Traits\ProductTrait;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class ShopifyMetafieldsJob implements ShouldQueue
{
    use Dispatchable,
        Batchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        ProductMetafieldTrait,
        JobEventDataTrait;

    public $storeId;
    public $metafieldType;

    public $metafieldLimit = 20;
    protected $cursor = null;
    private $jobEventService;

    public function __construct($storeId, string $metafieldType, $cursor = null)
    {
        $this->storeId = $storeId;
        $this->cursor = $cursor;
        $this->metafieldType = $metafieldType;
        $this->jobEventService = app(JobEventService::class);
        set_store_configuration($storeId);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            $jobEvent = $this->jobEventService->createJobEventRecord(JobEvent::SHOPIFY_PRODUCT_JOB, $this->job->payload());
            $this->createJobEventData($jobEvent, class_basename($this), $this->storeId);
            $configuration = configuration($this->storeId);
            $shopifyGraphqlProductService = new ShopifyGraphqlProductService($this->storeId);
            $result = $shopifyGraphqlProductService->getProductsMetafields($this->metafieldType, $this->metafieldLimit, $this->cursor);
            if (!$result){
                $this->release(30);
                return;
            }
            $responseEdges = Arr::get($result->getDecodedBody(), 'data.metafieldDefinitions.edges');
            $responsePageInfo = Arr::get($result->getDecodedBody(), 'data.metafieldDefinitions.pageInfo');
            $collectEdges = collect($responseEdges);
            $metafields = collect($collectEdges->pluck("node"));
            $lastMetafield = collect($collectEdges->last());

            if( count($metafields) )
            {
                foreach ( $metafields as $item )
                {
                    $this->updateOrCreateProductMetafield($configuration, $item);
                }
            }
            if($lastMetafield->has("cursor")) {
                $this->cursor = $lastMetafield->get("cursor");
            }

            Log::channel('shopify_products')->debug("Processed ShopifyMetafieldsJob : ". $this->batch()->processedJobs());
            // add another iteration to batch
            if( $responsePageInfo && isset($responsePageInfo['hasNextPage']) && $responsePageInfo['hasNextPage'] )
            {
                // add next page to batch
                $this->batch()->add(
                    new ShopifyMetafieldsJob($this->storeId, $this->metafieldType, $this->cursor)
                );
            } else {
                // Looks processed last page - make nex processes
                Log::channel('shopify_products')->debug("Processed add metafields all jobs.");
            }
            $this->jobEventService->successJobEvent($jobEvent->id);
        }catch (Exception $e) {
            Log::channel('shopify_products')->error($e->getMessage()." FILE ".$e->getFile()." LINE ".$e->getLine());
        }
    }

}
