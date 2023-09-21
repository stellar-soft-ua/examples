<?php

namespace THEME\Theme\Commands;

use Carbon\Carbon;
use THEME\Framework\Commands\BaseCommand;
use THEME\Theme\Repositories\ZenodoDepositRepository;
use THEME\Theme\Zenodo\Services\DepositSynchronizationService;
use WPML\Collect\Support\Arr;

class ZenodoPull extends BaseCommand
{
    protected $signature = 'zenodo:pull';
    protected $description = 'Pull deposits from Zenodo and sync them with the local database.';

    public function handle(array $args = [], array $options = [])
    {
        /** @var DepositSynchronizationService $service */
        $service = DepositSynchronizationService::getInstance();

        $start = microtime(true);
        $this->line('Fetching deposits...');
        $deposits = $service->fetchDeposits();

        if (Arr::get($options, 'only-new')) {
            $latestDeposit = ZenodoDepositRepository::builder()
                                                    ->suppressFilters()
                                                    ->orderByModified()
                                                    ->first();

            if ($latestDeposit) {
                $latestDate = Carbon::parse(get_post_meta($latestDeposit->ID, 'zenodo_modified', true));

                $deposits = array_filter($deposits, function ($deposit) use ($latestDate) {
                    $modified = Carbon::parse($deposit['modified']);

                    return $modified > $latestDate;
                });
            }
        }

        $this->line(sprintf('Fetched %0d deposits from Zenodo (%1dms).', count($deposits), intval((microtime(true) - $start) * 1000)));

        foreach ($deposits as $deposit) {
            $post = $service->createOrUpdatePostFromDeposit($deposit);

            if ($post->is_locked) {
                $this->warning(sprintf('Ignored deposit with ID "%0d", because post with ID "%1d" is locked.',
                    array_get($deposit, 'id'),
                    $post->ID
                ));
            } else {
                $this->line(sprintf('Imported deposit with ID "%0d" to %1s post with ID "%2d"',
                    array_get($deposit, 'id'),
                    $post->exists ? 'existing' : 'new',
                    $post->ID
                ));
            }
        }

        $this->line(sprintf('Deposits stored in local database (%0dms).', intval((microtime(true) - $start) * 1000)));

        $this->line('Configuring languages for existing deposits...');
        $service->configurePostTranslations();
        $this->line('Languages for deposits configured.');

        $this->success('Deposit successfully synchronized from Zenodo!');
    }
}
