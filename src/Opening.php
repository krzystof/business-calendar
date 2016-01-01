<?php

namespace BusinessCalendar;

use Carbon\Carbon;
use InvalidArgumentException;

class Opening implements Openingable
{
    use CanBeCompiled, CompareWithOpening, HasOpenAndClosesAtAttributes;

    /**
     * Common values in seconds.
     */
    const SECONDS_PER_HOUR = Carbon::SECONDS_PER_MINUTE * Carbon::MINUTES_PER_HOUR;
    const SECONDS_PER_DAY  = Carbon::HOURS_PER_DAY * self::SECONDS_PER_HOUR;
    const SECONDS_PER_WEEK = Carbon::DAYS_PER_WEEK * self::SECONDS_PER_DAY;

    /**
     * The day of the week the Opening starts.
     *
     * @var int
     */
    protected $day;

    /**
     * The time the opening starts.
     *
     * @var string
     */
    protected $time;

    /**
     * The length of the opening.
     *
     * @var int
     */
    protected $length;

    /**
     * The Opening has been updated.
     *
     * @var bool
     */
    protected $updated = false;

    /**
     * Common lengths in seconds.
     *
     * @var array
     */
    protected static $lengths = [
        'WEEK' => 604800,
        'DAY'  => 86400,
        'HOUR' => 3600,
    ];

    /**
     * Create a new Opening.
     *
     * @param array $arguments
     */
    public function __construct($arguments)
    {
        if ($arguments['length'] > self::SECONDS_PER_WEEK) {
            throw new InvalidArgumentException('The length of the Opening cannot exceed a week');
        }

        $this->day = $arguments['day'];
        $this->time = $arguments['time'];
        $this->length = $arguments['length'];
        $this->timezone = isset($arguments['timezone']) ? $arguments['timezone'] : 'Europe/Paris';
    }

    /**
     * Get the integer value of the day of the week.
     *
     * @param  string $dayOfWeek
     * @return int
     */
    public static function dayOfWeek($dayOfWeek)
    {
        return Carbon::parse($dayOfWeek)->dayOfWeek;
    }

    /**
     * Get the day of the week as a string.
     *
     * @param  [type] $day [description]
     *
     * @return [type]      [description]
     */
    public static function getWeekDay($day)
    {
        $weekDays = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];

        return $weekDays[$day];
    }

    /**
     * Convert an Opening to a String.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->opensAt().' '.$this->closesAt();
    }
}
