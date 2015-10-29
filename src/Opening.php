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
    public function __construct($day, $time, $length)
    {
        $this->day = $day;
        $this->time = $time;
        $this->length = $length;

        $this->setOpensAndClosesAt();
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
        if (
            $this->isOpenAt($opening->opensAt())
         || $this->isOpenAt($opening->closesAt())
        ) {
            return true;
        }

        return false;
    }

    /**
     * Set the opensAt and closesAt attributes as Carbon instances.
     */
    protected function setOpensAndClosesAt()
    {
        $this->opensAt = Carbon::createFromFormat(
            'l H:i', static::$days[$this->day] . ' ' . $this->time
        );

        $this->closesAt = $this->opensAt->copy()->addSeconds($this->length);
    }

    /**
     * Check if the opening is Open at a given timestamp.
     *
     * @param  Carbon\Carbon  $time
     *
     * @return boolean
     */
    protected function isOpenAt(Carbon $time)
    {
        return $time->between($this->opensAt, $this->closesAt);
    }
}
