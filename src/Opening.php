<?php

namespace BusinessCalendar;

use Carbon\Carbon;
use InvalidArgumentException;

class Opening implements DateRange
{
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
     * The beginning of the opening.
     *
     * @var Carbon\Carbon
     */
    protected $opensAt;

    /**
     * The end of the opening.
     *
     * @var Carbon\Carbon
     */
    protected $closesAt;

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

        $this->setCarbonInstances();
    }

    /**
     * Get the beginning of the Opening.
     *
     * @return Carbon\Carbon
     */
    public function opensAt()
    {
        return $this->opensAt;
    }

    /**
     * Get the closing of the Opening.
     *
     * @return Carbon\Carbon
     */
    public function closesAt()
    {
        return $this->closesAt;
    }

    /**
     * Check wether the Opening overlaps the other opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    public function overlaps(Opening $opening)
    {
        return $this->touch($opening) || $this->touch($opening->lastWeek());
    }

    /**
     * Merge two Opening together.
     *
     * @param  BusinessCalendar\Opening  $opening
     */
    public function merges(Opening $opening)
    {
        if (! $this->overlaps($opening)) {
            return;
        }

        if ($this->closesAt() < $opening->closesAt()) {
            $this->closesAt = $opening->closesAt();
        }

        if ($this->opensAt() > $opening->opensAt()) {
            $this->opensAt = $opening->opensAt();
        }
    }

    /**
     * Clone the opening set to the previous week dates.
     *
     * @return BusinessCalendar\Opening
     */
    public function lastWeek()
    {
        $lastWeek = new self([
            'day' => $this->day,
            'time' => $this->time,
            'length' => $this->length,
            'timezone' => $this->timezone,
        ]);

        $lastWeek->moveOpening($lastWeek->opensAt()->subWeek());

        return $lastWeek;
    }

    /**
     * Check if the opening is open at a given timestamp.
     *
     * @param  Carbon\Carbon  $time
     * @return bool
     */
    public function isOpenAt(Carbon $time)
    {
        return $time->between($this->opensAt, $this->closesAt)
            || $time->copy()->addWeek()->between($this->opensAt, $this->closesAt);
    }

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
     * Set the opensAt and closesAt attributes as Carbon instances.
     */
    protected function setCarbonInstances()
    {
        $this->opensAt = $this->setOpenDate();
        $this->closesAt = $this->opensAt->copy()->addSeconds($this->length);
    }

    /**
     * Set the open date.
     *
     * @return  Carbon\Carbon
     */
    protected function setOpenDate()
    {
        $open = Carbon::parse('monday', $this->timezone);

        if ($this->day !== Carbon::MONDAY) {
            $open->next($this->day);
        }

        $open->setTime($this->openHour(), $this->openMinute());

        return $open;
    }

    /**
     * Get the hour at which the Opening start.
     *
     * @return int
     */
    protected function openHour()
    {
        return substr($this->time, 0, strpos($this->time, ':'));
    }

    /**
     * Get the minute at which the Opening start.
     *
     * @return int
     */
    protected function openMinute()
    {
        return substr($this->time, strpos($this->time, ':') + 1);
    }

    /**
     * Checks if the opening is contained in another opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    protected function isContainedIn(Opening $opening)
    {
        return $opening->isOpenAt($this->opensAt()) && $opening->isOpenAt($this->closesAt());
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

    /**
     * Checks if an opening touches another opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    protected function touch(Opening $opening)
    {
        return $this->isOpenAt($opening->opensAt())
            || $this->isOpenAt($opening->closesAt())
            || $this->isContainedIn($opening);
    }
}
