<?php

namespace BusinessCalendar;

use Carbon\Carbon;

class BusinessTime
{
    /**
     * Common values in seconds.
     */
    const SECONDS_PER_HOUR = Carbon::SECONDS_PER_MINUTE * Carbon::MINUTES_PER_HOUR;
    const SECONDS_PER_DAY = Carbon::HOURS_PER_DAY * self::SECONDS_PER_HOUR;
    const SECONDS_PER_WEEK = Carbon::DAYS_PER_WEEK * self::SECONDS_PER_DAY;

    /**
     * The day constants.
     */
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    /**
     * The days of the week.
     *
     * @var array
     */
    protected static $weekDays = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];

    /**
     * Get the day of the week value from a string.
     *
     * @param  string $day
     * @return int
     */
    public static function dayFromString($dayName)
    {
        return array_search(ucfirst($dayName), static::$weekDays);
    }

    /**
     * Get the name of the day from a value.
     *
     * @param  int $day
     * @return string
     */
    public static function dayToString($day)
    {
        return static::$weekDays[$day];
    }

    /**
     * Converts hours to seconds.
     *
     * @param  int $hours
     * @return int
     */
    public static function hoursToSeconds($hours)
    {
        return (int) ($hours * self::SECONDS_PER_HOUR);
    }

    /**
     * Converts seconds to hours.
     *
     * @param  int  $seconds
     * @param  int $precision
     * @return float
     */
    public static function secondsToHours($seconds, $precision = 0)
    {
        return round($seconds / self::SECONDS_PER_HOUR, $precision);
    }
}
