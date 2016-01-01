<?php

namespace BusinessCalendar;

use Carbon\Carbon;
use InvalidArgumentException;

class Opening implements Openingable
{
    use CanBeCompiled, CompareWithOpening, HasOpenAndClosesAtAttributes;

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
        if ($arguments['length'] > static::$lengths['WEEK']) {
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
     * @return integer
     */
    public static function dayOfWeek($dayOfWeek)
    {
        return Carbon::parse($dayOfWeek)->dayOfWeek;
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

    /**
     * Move an opening to a given timestamp.
     *
     * @param  Carbon $timestamp
     * @return void
     */
    protected function moveOpening(Carbon $timestamp)
    {
        $this->opensAt = $timestamp;
        $this->closesAt = $this->opensAt->copy()->addSeconds($this->length);
    }
}
