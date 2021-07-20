<?php

namespace App\Console\Commands;

use App\Services\Customer\PropertyService;
use Illuminate\Console\Command;

class RemoveExpiredPropertiesFromPortals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:remove-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleting properties after their expiration date';

    /**
     * @var PropertyService
     */
    private $propertyService;

    /**
     * Create a new command instance.
     *
     * @param PropertyService $propertyService
     */
    public function __construct(PropertyService $propertyService)
    {
        parent::__construct();

        $this->propertyService = $propertyService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $expiredProperties = $this->propertyService->findExpiredProperties();

        if($expiredProperties->count()) {
            foreach($expiredProperties as $property) {
                $this->propertyService->removeExpiredPropertyFromListing($property);
            }
        }
    }
}
