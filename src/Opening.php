<?php

namespace BusinessCalendar;

use Carbon\Carbon;

class Opening
{
    /**
     * The day of the week the Opening starts.
     *
     * @var integer
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
     * @var integer
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

    protected $updated = false;
    protected $merged = false;

    /**
     * Names of days of the week.
     *
     * @var array
     */
    protected static $days = array(
        Carbon::SUNDAY => 'Sunday',
        Carbon::MONDAY => 'Monday',
        Carbon::TUESDAY => 'Tuesday',
        Carbon::WEDNESDAY => 'Wednesday',
        Carbon::THURSDAY => 'Thursday',
        Carbon::FRIDAY => 'Friday',
        Carbon::SATURDAY => 'Saturday',
    );

    /**
     * Create a new Opening.
     *
     * @param integer $day
     * @param string  $start
     * @param integer $length
     */
    public function __construct($day, $time, $length, $timezone = 'Europe/Paris')
    {
        // if length is greater than a week, throw an Exception
        $this->day = $day;
        $this->time = $time;
        $this->length = $length;
        $this->timezone = $timezone;

        $this->setOpensAndClosesAt(Carbon::createFromFormat(
            'l H:i', static::$days[$this->day] . ' ' . $this->time, $this->timezone
        ));
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
     * get the closing of the Opening.
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
     *
     * @return boolean
     */
    public function overlaps(Opening $opening)
    {
        // TODO refactor to:
        // if ($this->touch($opening) || $this->touch($opening->previousWeek())) {
        //     return true;
        // }
        if (
            $this->isOpenAt($opening->opensAt())
         || $this->isOpenAt($opening->closesAt())
         || $this->isContainedIn($opening)
        ) {
            return true;
        }

        if (
            $this->isOpenAt($opening->opensAt()->subWeek())
         || $this->isOpenAt($opening->closesAt()->subWeek())
         || $this->isContainedIn($opening->lastWeek())
        ) {
            return true;
        }

        return false;
    }

    /**
     * Merge two Opening together.
     *
     * @param  BusinessCalendar\Opening  $opening
     *
     * @return void
     */
    public function merges(Opening $opening)
    {
        if (! $this->overlaps($opening)) {
            return;
        }

        // echo 'this: '.$this->opensAt().', '.$this->closesAt(). ' / opening: '.$opening->opensAt().', '.$opening->closesAt()."\n";

        if ($this->closesAt() < $opening->closesAt()) {
            $this->closesAt = $opening->closesAt();
        }

        if ($this->opensAt() > $opening->opensAt()) {
            $this->opensAt = $opening->opensAt();
        }

        $this->setUpdated(true);
        $opening->setMerged(true);
    }

    /**
     * Clone the opening set to the previous week dates.
     *
     * @return BusinessCalendar\Opening
     */
    public function lastWeek()
    {
        $lastWeek =  new Opening($this->day, $this->time, $this->length, $this->timezone);
        $lastWeek->setOpensAndClosesAt($lastWeek->opensAt()->subWeek());

        return $lastWeek;
    }

    /**
     * The Opening has been updated.
     *
     * @return boolean
     */
    public function hasBeenUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the updated flag.
     *
     * @param bool $boolean
     */
    public function setUpdated($boolean)
    {
        return $this->updated = $boolean;
    }

    /**
     * The Opening has been merged with another Opening.
     *
     * @return boolean
     */
    public function hasBeenMerged()
    {
        return $this->merged;
    }

    /**
     * Set the Merged flag.
     *
     * @param bool $boolean
     */
    public function setMerged($boolean)
    {
        return $this->merged = $boolean;
    }

    /**
     * Set the opensAt and closesAt attributes as Carbon instances.
     */
    protected function setOpensAndClosesAt(Carbon $date)
    {
        $this->opensAt = $date;
        $this->closesAt = $this->opensAt->copy()->addSeconds($this->length);
    }

    /**
     * Check if the opening is Open at a given timestamp.
     *
     * @param  Carbon\Carbon  $time
     *
     * @return boolean
     */
    public function isOpenAt(Carbon $time)
    {
        return $time->between($this->opensAt, $this->closesAt);
    }

    /**
     * Checks if the opening is contained in another opening.
     *
     * @param  BusinessCalendar\Opening $opening
     *
     * @return boolean
     */
    protected function isContainedIn(Opening $opening)
    {
        return $opening->isOpenAt($this->opensAt()) && $opening->isOpenAt($this->closesAt());
    }
}
