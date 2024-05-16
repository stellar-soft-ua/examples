<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnalyticRequest;
use App\Jobs\CumulativeMRRAnalyticalMigration;
use App\Jobs\DeleteRecentBroadcastChannels;
use App\Models\Analytic;
use App\Models\AnalyticalItem;
use App\Models\AppMeta;
use App\Models\BroadcastChannel;
use App\Models\CheckoutSession;
use App\Models\Client;
use App\Models\Event;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\SubscriptionOrder;
use App\Traits\EventIntervalTrait;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class AnalyticController extends Controller
{

    use EventIntervalTrait;

    public function index(AnalyticRequest $request): JsonResponse
    {
        $client = Auth::user()->client;

        $data = [];
        $broadcatChannels = [];

        if ($request->get('type') == 'upsell'){

            foreach ($request->get('resource_id') as $upsell_id){
                foreach ($request->get('data') as $eventType){
                    $intervals = $this->getEventsByType($request, $eventType, $upsell_id);
                    $data[$upsell_id][$eventType] = $intervals['intervals'];

                    if (!$request->get('end_datetime')){
                        $broadcatChannels[$upsell_id][$eventType] = $intervals['channels'];
                    }
                }
            }

        } else {

            foreach ($request->get('data') as $eventType){
                $intervals = $this->getEventsByType($request, $eventType);
                $data[$eventType] = $intervals['intervals'];
                if (!$request->get('end_datetime')){
                    $broadcatChannels[$eventType] = $intervals['channels'];
                }
            }

        }



        return $this->apiResponse('Analytic data', 200, $data, ['broadcast_channel' => $broadcatChannels]);
    }

    private function getEventsByType($request, $eventType, $upsell_id = null)
    {
        $client = Auth::user()->client;

        $startDatetime = Carbon::parse($request->get('start_datetime'))->format('Y-m-d H:i:s');
        $endsDatetime = Carbon::parse($request->get('end_datetime'))->format('Y-m-d H:i:s');

        $events = ($request->get('type') == 'upsell')
            ? collect($this->getUpsellEventByInterval($upsell_id, $eventType, $request->get('interval'), $startDatetime, $endsDatetime, $client))
            : collect($this->getEventByInterval($eventType, $request->get('interval'), $startDatetime, $endsDatetime, $client));

        $allIntervals = $this->dateRange($startDatetime, $endsDatetime, $this->getIntervalIncrement($request->get('interval')), $this->getIntervalFormat($request->get('interval')) );

        foreach ($allIntervals as $k=>$v){
            $event = $events->where('datetime', $v['datetime'])->first();
            if ($event){
                $allIntervals[$k] = $event->toArray();
            }
        }

        if (!$request->get('end_datetime')){
            $broadcatChannels = $this->createBroadcatChannel($client, $eventType, $request->get('interval'), Analytic::getTypeByName($request->get('type')), $upsell_id );
        } else {
            $broadcatChannels = null;
        }

        return ['intervals' => $allIntervals, 'channels' => $broadcatChannels];
    }


    private function dateRange($first, $last, $step = 'P1D', $output_format = 'd/m/Y' ) {

        $dates = array();
        $current = Carbon::parse($first)->format("Y-m-d H:i:s");
        if (request()->get('interval') === 'min') {
            $last = Carbon::parse($last)->seconds(59)->format("Y-m-d H:i:s");
        } else {
            $last = Carbon::parse($last)->endOf(request()->get('interval'))->format("Y-m-d H:i:s");
        }

        $period = new \DatePeriod(new \DateTime($current), new \DateInterval($step), new \DateTime($last));
        foreach ($period as $date) {
            $dates[] = [
                "datetime" => $date->format($output_format),
                "value" => 0,
                "quantity" => 0,
            ];
        }

        return $dates;
    }


    public function createBroadcatChannel(Client $client, $eventType, $interval, $type, $resource_id=null)
    {
        // create private chanel for broadcating new events
        $broadcastChannel =  BroadcastChannel::create([
            'client_id' => $client->id,
            'event_type' => $eventType,
            'interval' => array_search($interval, Event::getAllIntervals()),
            'channel_id' => Str::uuid(),
            'type' => $type,
            'resource_id' => $resource_id
        ]);

        return $broadcastChannel->channel_id;
    }

    public function destroy($channel_id)
    {
        $broadcastChannel = BroadcastChannel::where('client_id', \auth()->user()->client->id)->where('channel_id', $channel_id)->firstOrfail();
        $broadcastChannel->delete();

        return $this->apiResponse(__("Broadcast channel deleted!"));
    }


    public function deleteRecentBroadcastChannels($key)
    {
        $appMeta = AppMeta::where('migration_key', $key)->firstOrFail();

        DeleteRecentBroadcastChannels::dispatch();

        return "DeleteRecentBroadcastChannels job's created";
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function liveChartsData(Request $request): JsonResponse
    {
        $user = auth()->user();

        $clientId = $user->isAdmin() ? $request->get('client_id') : $user->client_id;

        $usc = $this->getUsersOnCheckoutCount($clientId);
        $uso = $this->getUsersSuccessfullyOrderedCount($clientId);
        $nss = $this->getNewSubscriptionsStartedCount($clientId);

        $currency = auth()->user()->client?->midCurrency;
        return response()->json([
            'message' => 'Analytic live charts data',
            'data' => [
                'uso' => $uso,
                'usc' => $usc,
                'nss' => $nss,
            ],
            'currency' => ($currency) ? [
                'code' => $currency->currency_code, 'symbol' => $currency->symbol
            ] : []
        ]);
    }



    /**
     * @param int $clientId
     * @return int
     */
    private function getUsersOnCheckoutCount(int $clientId): int
    {
        return CheckoutSession::whereHas('checkout', function ($query) use ($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->whereBetween('created_at', [Carbon::now()->subMinutes(5), Carbon::now()])->count();
    }

    /**
     * @param int $clientId
     * @return int
     */
    private function getUsersSuccessfullyOrderedCount(int $clientId): int
    {
        return Order::where('client_id', $clientId)
            ->where('payment_status', '<>', Order::PAYMENT_STATUS_DECLINED)
            ->whereBetween('created_at', [Carbon::now()->subMinutes(5), Carbon::now()])->count();
    }

    /**
     * @param int $clientId
     * @return int
     */
    private function getNewSubscriptionsStartedCount(int $clientId): int
    {
        return Subscription::whereHas('subscription_product', function($q) use ($clientId) {
            $q->where('client_id', $clientId);
        })->whereBetween('created_at', [Carbon::now()->subMinutes(5), Carbon::now()])->count();
    }

}
