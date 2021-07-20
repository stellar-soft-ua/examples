<?php

    namespace app\components;

    use DateTime;
    use DateTimeZone;
    use Exception;
    use Yii;
    use yii\helpers\ArrayHelper;

    class DateFactory
    {
        /**
         * DateTime Constants
         */
        const MACHINE_DATE_FORMAT                = 'Y-m-d';
        const MACHINE_DATETIME_FORMAT            = 'Y-m-d H:i:s';
        const MACHINE_DATETIME_NO_SECONDS_FORMAT = 'Y-m-d H:i';
        const MACHINE_TIME_NO_SECONDS_FORMAT     = 'H:i';
        const TIME_FORMAT                        = 'a';
        const MONTH_NAME_DAY_YEAR                = 'F jS, Y'; //January 12th, 2019
        const MONTH_NAME_DATE_HOUR_AM_PM         = 'F jS g.i A'; //January 12th at 9.07 AM
        const MONTH_DAY_YEAR                     = 'm/d/Y';
        const MONTH_DAY_YEAR_DASH                = 'm-d-Y';
        const MONTH_DAY                          = 'M j'; //Jan 2

        /**
         * Weekdays
         */
        const WEEKDAY_SUNDAY    = 'sunday';
        const WEEKDAY_MONDAY    = 'monday';
        const WEEKDAY_TUESDAY   = 'tuesday';
        const WEEKDAY_WEDNESDAY = 'wednesday';
        const WEEKDAY_THURSDAY  = 'thursday';
        const WEEKDAY_FRIDAY    = 'friday';
        const WEEKDAY_SATURDAY  = 'saturday';

        /**
         * Seconds
         */
        const DAY_IN_SECONDS = 86400;

        /**
         * Create an instance of the component
         *
         * @return self
         */
        public static function component() {

            $className = __CLASS__;
            /** @var self $instance */
            $component = new $className();

            return $component;
        }

        /**
         * Return days of an entire week with starting from a certain day
         *
         * @param $day
         *
         * @return array
         */
        public static function getWeekDaysOffset($day) {
            $weekDays        = self::getWeekDays();
            $currentDayIndex = array_search($day, array_keys($weekDays));

            return ArrayHelper::merge(
                array_splice($weekDays, $currentDayIndex, count($weekDays)),
                array_slice($weekDays, 0, $currentDayIndex)
            );
        }

        /**
         * Returns days of the week
         *
         * @return array
         */
        public static function getWeekDays($startingFromMonday = false) {
            $weekDays = [
                self::WEEKDAY_SUNDAY    => Yii::t('system', 'Sunday'),
                self::WEEKDAY_MONDAY    => Yii::t('system', 'Monday'),
                self::WEEKDAY_TUESDAY   => Yii::t('system', 'Tuesday'),
                self::WEEKDAY_WEDNESDAY => Yii::t('system', 'Wednesday'),
                self::WEEKDAY_THURSDAY  => Yii::t('system', 'Thursday'),
                self::WEEKDAY_FRIDAY    => Yii::t('system', 'Friday'),
                self::WEEKDAY_SATURDAY  => Yii::t('system', 'Saturday'),
            ];
            if ($startingFromMonday) {
                unset($weekDays[self::WEEKDAY_SUNDAY]);
                $weekDays[self::WEEKDAY_SUNDAY] = Yii::t('system', 'Sunday');
            }

            return $weekDays;
        }

        /**
         * Return label for a day
         *
         * @param $day
         *
         * @return mixed|string
         */
        public static function getWeekDayLabel($day) {
            $weekDays = self::getWeekDays();
            if (in_array($day, array_keys($weekDays))) {
                return $weekDays[$day];
            }

            return '';
        }

        /**
         * Returns app date format based on selected language
         *
         * @param bool $returnDateTime
         * @param bool $returnDateTimeWithSec
         * @param bool $returnJavascriptFormat
         * @param bool $monthOnlySelection
         *
         * @return null|string
         */
        public function receiveAppDateTimeFormat($returnDateTime = false, $returnDateTimeWithSec = false, $returnJavascriptFormat = false, $monthOnlySelection = false) {

            //Default Values
            $dateFormat                = 'm/d/Y';
            $dateTimeFormat            = 'm/d/Y g:i A';
            $dateTimeFormatSec         = 'm/d/Y g:i:s A';
            $javascriptFormat          = 'mm/dd/yyyy';
            $monthOnlyFormat           = "m/Y";
            $monthOnlyJavascriptFormat = "mm/yyyy";

            $returnFormat = $dateFormat;
            if ($returnDateTime) {
                $returnFormat = $dateTimeFormat;
            }
            if ($returnDateTimeWithSec) {
                $returnFormat = $dateTimeFormatSec;
            }
            if ($returnJavascriptFormat) {
                $returnFormat = $javascriptFormat;
            }
            if ($monthOnlySelection) {
                if ($returnJavascriptFormat) {
                    $returnFormat = $monthOnlyJavascriptFormat;
                } else {
                    $returnFormat = $monthOnlyFormat;
                }
            }

            return $returnFormat;
        }

        /**
         * Returns NOW date-time format
         *
         * @param bool $isUnixTime
         *
         * @return false|int|string
         */
        public function getNOW($isUnixTime = false, $format = self::MACHINE_DATETIME_FORMAT) {
            return $isUnixTime === true ? time() : date($format);
        }

        /**
         * @param $timeZone
         *
         * @return string
         * @throws Exception
         */
        public function getLocalTime($timeZone) {
            $date = new DateTime("now", new DateTimeZone($timeZone));

            return $date->format('h:i ' . self::TIME_FORMAT);
        }

        /**
         * @param        $date
         * @param        $daysToAdd
         * @param string $format
         *
         * @return string
         * @throws Exception
         */
        public function addDaysToDate($date, $daysToAdd, $format = self::MACHINE_DATE_FORMAT) {
            $dateTime = new DateTime($date);
            $dateTime->modify('+' . $daysToAdd . ' day');

            return $dateTime->format($format);
        }

        /**
         * Returns Months
         *
         * @return array
         */
        public function getMonths() {
            $months = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = $i;
            }

            return $months;
        }

        /**
         * Returns Years
         *
         * @return array
         */
        public function getYears() {

            $years = [];
            $max   = date('Y', strtotime('+10 year'));
            for ($i = date('Y'); $i <= $max; $i++) {
                $years[$i] = $i;
            }

            return $years;
        }

        /**
         * @param        $first
         * @param        $last
         * @param string $step
         * @param string $output_format
         * @param bool   $returnCount
         *
         * @return array|int
         */
        public function dateRange($first, $last, $step = '+1 day', $output_format = self::MACHINE_DATE_FORMAT, $returnCount = false) {

            $dates   = array();
            $current = strtotime($first);
            $last    = strtotime($last);
            $count   = 0;

            while ($current <= $last) {

                $count++;
                $dates[] = date($output_format, $current);
                $current = strtotime($step, $current);
            }

            return $returnCount ? $count : $dates;
        }

        /**
         * @param        $start
         * @param        $end
         * @param string $format
         *
         * @return float
         */
        function dateDiffInWeeks($start, $end, $format = self::MACHINE_DATE_FORMAT) {

            $first  = DateTime::createFromFormat($format, $start);
            $second = DateTime::createFromFormat($format, $end);
            if ($start > $end) return dateDiffInWeeks($start, $end);

            return floor($first->diff($second)->days / 7);

        }

        /**
         * @param $start
         * @param $end
         *
         * @return float|int
         */
        public function dateDiffInDays($start, $end) {

            $diff = strtotime($start) - strtotime($end);

            return abs(round($diff / 86400));
        }

        /**
         * @param string $date
         * @param        $format
         *
         * @return null|string
         */
        public function getDateWithAppliedTimezone($date = 'now', $format = self::MACHINE_DATE_FORMAT) {
            $returnedDate = null;
            $dateObj      = new DateTime($date, new DateTimeZone(DateFactory::getTimeZone()));
            if ($date) $returnedDate = $dateObj->format($format);

            return $returnedDate;

        }

        /**
         * Returns timezone based on user's country
         *
         * @return string
         */
        public static function getTimeZone() {
            $timezone = 'Europe/Berlin';
            if (!Yii::$app->user->getIsGuest() && Yii::$app->user->identity->timezone) {
                $timezone = Yii::$app->user->identity->timezone;
            }

            return $timezone;
        }

        /**
         * @param $date
         * @param $format
         *
         * @return array
         */
        public function getMondayToSundayDays($date, $format) {
            $dates  = [];
            $ts     = strtotime($date);
            $dow    = date('w', $ts);
            $offset = $dow - 1;
            if ($offset < 0) {
                $offset = 6;
            }
            $ts = $ts - $offset * 86400;
            for ($i = 0; $i < 7; $i++, $ts += 86400) {
                $dates[] = date($format, $ts);
            }

            return $dates;
        }

        /**
         * Returns Current Day
         *
         * @param string $returnedFormat
         *
         * @return string|null
         * @throws Exception
         */
        public function getToday($returnedFormat = self::MACHINE_DATE_FORMAT) {
            $date = new DateTime(date('Y-m-d'), new DateTimeZone(self::getTimeZone()));

            return $date ? $date->format($returnedFormat) : null;
        }

        /**
         * Returns Proper Day Format
         *
         * @param $date
         *
         * @return string
         */
        public function getProperDay($date) {
            $ts = strtotime($date);
            $ct = time();
            if ($ct > ($ts + static::DAY_IN_SECONDS * 2)) {
                return $this->convertDateTime($date, static::MACHINE_DATETIME_FORMAT, static::MONTH_DAY);
            } elseif ($ct > $ts + static::DAY_IN_SECONDS) {
                return "Yesterday";
            }

            return $this->convertDateTime($date, static::MACHINE_DATETIME_FORMAT, static::MACHINE_TIME_NO_SECONDS_FORMAT . static::TIME_FORMAT);
        }

        /**
         * Convert datetime format from a specific date format to another one
         *
         * @param      $date
         * @param      $fromFormat
         * @param      $toFormat
         * @param      $timeZone
         * @param bool $toUTC
         * @param bool $useTimeZone
         *
         * @return string
         */
        public function convertDateTime($date, $fromFormat, $toFormat, $timeZone = '', $toUTC = false, $useTimeZone = true) {

            if (!$date) {
                return $date;
            }

            $dateTimeZoneUTC  = new DateTimeZone('UTC');
            $dateTimeZoneUser = new DateTimeZone($timeZone ?: self::getTimeZone());

            // if $toUTC=true, than the datetime will be converted from user timezone to UTC
            // if $toUTC=false, than the datetime will be converted from UTC timezone to user timezone
            $convertedDate = DateTime::createFromFormat($fromFormat, $date, $useTimeZone ? ($toUTC ? $dateTimeZoneUTC : $dateTimeZoneUser) : null);

            return $convertedDate == false ? $date : $convertedDate->format($toFormat);
        }
    }
