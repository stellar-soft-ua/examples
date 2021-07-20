<?php

namespace ApiBundle\Component\Report;

use ApiBundle\Validator\Constraints\ContainsReportTimeGroupMode;
use DateInterval;
use DatePeriod;
use DateTime;

class PeriodicalReport implements Report
{
    private $items = [];
    private $result = [];

    public function __construct(array $items)
    {
        $this->setData($items);
    }

    public function setData(array $items): Report
    {
        $this->items = $items;

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function mapByPeriod(DateTime $begin, DateTime $end, string $time_group_mode): Report
    {
        $interval = new DateInterval(ContainsReportTimeGroupMode::$modes[$time_group_mode]['interval']);
        $daterange = new DatePeriod($begin, $interval, $end);

        $ranges = [];

        foreach ($daterange as $date) {
            $startDate = (clone $date);
            $date->modify('+1 ' . $time_group_mode);
            $endDate = (clone $date);

            array_push($ranges, [
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

            $this->result[$startDate->format('Y-m-d')] = [];
        }

        $last_item_date = null;
        $last_key = null;
        $findRangeKey = function ($date) use ($ranges, &$last_item_date, &$last_key) {
            if ($last_item_date) {
                if ($last_item_date == $date) {
                    return $last_key;
                }
            }

            foreach ($ranges as $key => $range) {
                if ($date >= $range['startDate'] && $date <= $range['endDate']) {
                    $last_item_date = $date;
                    return $last_key = $key;
                }
            }
        };

        foreach ($this->items as $item) {

            $key = $findRangeKey($item->getDate());
            array_push($this->result[$ranges[$key]['startDate']->format('Y-m-d')], $item);

        }

        return $this;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function getFinalData(Callable $mapPeriodFunc)
    {
        $result_array = [];
        foreach ($this->result as $period => $items) {
            array_push($result_array, $mapPeriodFunc($period, $items));
        }

        return $result_array;
    }
}