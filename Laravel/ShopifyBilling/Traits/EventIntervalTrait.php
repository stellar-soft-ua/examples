<?php

namespace App\Traits;

use App\Exceptions\ErrorException;
use App\Models\Client;
use App\Models\Event;
use App\Models\UpsellEvent;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait EventIntervalTrait
{

    public function getEventByInterval(int $eventType, string $interval, $start_datetime = null, $end_datetime = null, Client $client = null)
    {

        $query = Event::query()
            ->selectRaw(" DATE_FORMAT(created_at, '".$this->getIntervalFormatSQL($interval)."') as datetime, ROUND(SUM(value),2) as value, COUNT(id) as quantity")
            ->where('client_id', $client->id)
            ->where('type', $eventType);

        if ($start_datetime){
            $query->where('created_at', '>=', $start_datetime);
        }
        if ($end_datetime){
            $query->where('created_at', '<=', $end_datetime);
        }

        $query->orderBy('created_at', 'desc');

        $query->groupBy("datetime");


        $result = $query->get();

        if (get_class($result) != 'Illuminate\Database\Eloquent\Collection'){
            return throw new ErrorException(__("MySQL error"), 403);
        }

        return $result;
    }

    public function getUpsellEventByInterval(int $upsell_id, int $eventType, string $interval, $start_datetime = null, $end_datetime = null, Client $client = null)
    {
        $query = UpsellEvent::query()
            ->selectRaw(" DATE_FORMAT(created_at, '".$this->getIntervalFormatSQL($interval)."') as datetime, ROUND(SUM(value),2) as value, COUNT(id) as quantity")
            ->where('client_id', $client->id)
            ->where('upsell_id', $upsell_id)
            ->where('type', $eventType);

        if ($start_datetime){
            $query->where('created_at', '>=', $start_datetime);
        }
        if ($end_datetime){
            $query->where('created_at', '<=', $end_datetime);
        }

        $query->orderBy('created_at', 'desc');

        $query->groupBy("datetime");


        $result = $query->get();

        if (get_class($result) != 'Illuminate\Database\Eloquent\Collection'){
            return throw new ErrorException(__("MySQL error"), 403);
        }

        return $result;
    }


    public function getIntervalFormatSQL(string $interval)
    {
        switch ($interval){
            case Event::EVENT_INTERVAL_MIN:
                return '%Y-%m-%d %H:%i:00';
                break;
            case Event::EVENT_INTERVAL_HOUR:
                return '%Y-%m-%d %H:00:00';
                break;
            case Event::EVENT_INTERVAL_DAY:
                return '%Y-%m-%d 00:00:00';
                break;
            case Event::EVENT_INTERVAL_WEEK:
                return '%Y-%m %v';
                break;
            case Event::EVENT_INTERVAL_MONTH:
                return '%Y-%m';
                break;
            case Event::EVENT_INTERVAL_YEAR:
                return '%Y';
                break;
        }

        return '%Y-%m-%d %H:%i:00';
    }

    public function getIntervalFormat(string $interval)
    {
        switch ($interval){
            case Event::EVENT_INTERVAL_MIN:
                return 'Y-m-d H:i:00';
                break;
            case Event::EVENT_INTERVAL_HOUR:
                return 'Y-m-d H:00:00';
                break;
            case Event::EVENT_INTERVAL_DAY:
                return 'Y-m-d 00:00:00';
                break;
            case Event::EVENT_INTERVAL_WEEK:
                return 'Y-m W';
                break;
            case Event::EVENT_INTERVAL_MONTH:
                return 'Y-m';
                break;
            case Event::EVENT_INTERVAL_YEAR:
                return 'Y';
                break;
        }

        return 'Y-m-d H:i:00';
    }

    public function getIntervalIncrement(string $interval)
    {
        switch ($interval){
            case Event::EVENT_INTERVAL_MIN:
                return 'PT1M';
//                return '+1 minute';
                break;
            case Event::EVENT_INTERVAL_HOUR:
                return 'PT1H';
//                return '+1 hour';
                break;
            case Event::EVENT_INTERVAL_DAY:
                return 'P1D';
//                return '+1 day';
                break;
            case Event::EVENT_INTERVAL_WEEK:
                return 'P1W';
//                return '+1 week';
                break;
            case Event::EVENT_INTERVAL_MONTH:
                return 'P1M';
//                return '+1 month';
                break;
            case Event::EVENT_INTERVAL_YEAR:
                return 'P1Y';
//                return '+1 year';
                break;
        }

        return '+1 minute';
    }

}
