<?php

namespace App\Lib;

use App\Http\Controllers\Api\Shopify\ShopifyLocationsController;
use App\Http\Controllers\Api\Shopify\ShopifySubscriptionController;
use App\Http\Controllers\Api\Shopify\ShopifyWebhooksController;
use App\Jobs\Shopify\ShopifyLocationsJob;
use App\Jobs\Shopify\ShopifyRegisterWebhooksJob;
use App\Models\Configuration;
use App\Models\Country;
use App\Models\Store;
use App\Services\ShopifyService;
use App\Traits\updateOrCreateConfigurationTrait;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Shopify\Auth\AccessTokenOnlineUserInfo;
use Shopify\Auth\Session as ShopifySession;
use Throwable;

class StoreConfig implements \Shopify\Auth\SessionStorage
{

    use updateOrCreateConfigurationTrait;

    /**
     * Find and load session information from configuration
     *
     * @param  string  $sessionId
     * @return ShopifySession|null
     * @throws \Exception
     */
    public function loadSession(string $sessionId): ?ShopifySession
    {

        $configLine = Configuration::where('name','session_id')->where('value', $sessionId)->first();
        if ($configLine){
            $configuration = configuration($configLine->store_id, true);

            $session = new ShopifySession(
                $configuration->getShopifySessionId(),
                $configuration->getShopifyShop(),
                ($configuration->getShopifyIsOnline()) ? $configuration->getShopifyIsOnline() : 0,
                $configuration->getShopifyState()
            );

            if ($configuration->getShopifyExpiresAt()) {
                $session->setExpires($configuration->getShopifyExpiresAt());
            }
            if ($configuration->getShopifyAccessToken()) {
                $session->setAccessToken($configuration->getShopifyAccessToken());
            }
            if ($configuration->getShopifyScopes()) {
                $session->setScope($configuration->getShopifyScopes());
            }
            if ($configuration->getShopifyUserId()) {
                $onlineAccessInfo = new AccessTokenOnlineUserInfo(
                    (int)$configuration->getShopifyUserId(),
                    $configuration->getShopifyUserFirstName(), //$dbSession->user_first_name,
                    $configuration->getShopifyUserLastName(), //$dbSession->user_last_name,
                    $configuration->getShopifyUserEmail(), // $dbSession->user_email,
                    1, //$dbSession->user_email_verified == 1,
                    1, //$dbSession->account_owner == 1,
                    $configuration->getStoreLocale(), //$dbSession->locale,
                    1, //$dbSession->collaborator == 1
                );
                $session->setOnlineAccessInfo($onlineAccessInfo);
            }

            return $session ?? null;

        } else {
            return null;
        }

    }

    /**
     * Store session information in configuration
     *
     * @param  ShopifySession  $session
     * @return bool
     */
    public function storeSession(ShopifySession $session): bool
    {

        $store = Store::firstOrCreate(['store' => $session->getShop()]);

        $shopifyData = [
            ['name' => 'access_token', 'value' => $session->getAccessToken()],
            ['name' => 'scopes', 'value' => $session->getScope()],
            ['name' => 'shop', 'value' => $session->getShop()],
            ['name' => 'state', 'value' => $session->getState()],
            ['name' => 'is_online', 'value' => $session->isOnline()],
            ['name' => 'expires_at', 'value' => $session->getExpires()],
            ['name' => 'session_id', 'value' => $session->getId()],
        ];

        $this->updateOrCreateConfiguration($store, $shopifyData);

        if( $session->getAccessToken() )
        {

            $this->shopifyApi = new ShopifyService($store->id);
            $detail = $this->shopifyApi->getShop();
            $billingInfo = $this->shopifyApi->billingInfo();

            if( $detail )
            {

                $shopifyData = [
                    ['name' => 'user_id', 'value' => $detail['id']],
                    ['name' => 'user_first_name', 'value' => $detail['shop_owner']],
                    ['name' => 'user_last_name', 'value' => $detail['shop_owner']],
                    ['name' => 'user_email', 'value' => $detail['email']],
                    ['section' => 'global','name' => 'locale', 'value' => $detail['primary_locale']],
                ];

                if (!empty($billingInfo) && !empty($billingInfo['recurring_application_charges'])) {
                    $billingResource = $billingInfo['recurring_application_charges'][0];

                    $paymentData = [
                        ['name' => 'trial_ends_on', 'value' => $billingResource['trial_ends_on']],
                        ['name' => 'next_payment_date', 'value' => $billingResource['billing_on']],
                        ['name' => 'billing_status', 'value' => $billingResource['status']]
                    ];

                    $shopifyData = array_merge($shopifyData, $paymentData);
                }

                $this->updateOrCreateConfiguration($store, $shopifyData);

                //Update Store - email, country id
                $country = Country::iso($detail['country_code']);
                $store->update([
                    'email' => $detail['email'],
                    'country_id' => $country->id
                ]);

            }else{
                Log::error('Not Found Store Detail ');
            }

            /**
             * Jobs: Register App Webhooks Default and Locations
             */
            Bus::chain([
                new ShopifyLocationsJob($store->id),
                new ShopifyRegisterWebhooksJob($store->id),
            ])->catch(function (Throwable $e) {

                Log::error(sprintf('File - %s Line - %s | Error Jobs', __FILE__, __LINE__));

            })->dispatch();
        }

        return true;
    }




    public function deleteSession(string $sessionId): bool
    {
        return  true;
    }
}
