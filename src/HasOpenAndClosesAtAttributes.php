<?php

namespace BusinessCalendar;

use Carbon\Carbon;

trait HasOpenAndClosesAtAttributes
{
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
     * Get the beginning of the Opening.
     *
     * @return Carbon\Carbon
     */
    public function opensAt()
    {
        if (! isset($this->opensAt)) {
            $this->setOpensAt();
        }

        return $this->opensAt;
    }

    /**
     * Set the opensAt attribute.
     *
     * @param Carbon $timestamp
     */
    public function setOpensAt(Carbon $timestamp = null)
    {
        if (! is_null($timestamp)) {
            $this->day = $timestamp->dayOfWeek;
            $this->time = $timestamp->format('H:i:s');
            $this->length = $timestamp->diffInSeconds($this->closesAt);
        }

        $this->opensAt = $this->getDefaultOpenAt();
        $this->calculateClosesAt();
    }

    /**
     * Get the closing of the Opening.
     *
     * @return Carbon\Carbon
     */
    public function closesAt()
    {
        if (! isset($this->opensAt)) {
            $this->setOpensAt();
        }

        return $this->closesAt;
    }

    /**
     * Set the closesAt attribute.
     *
     * @param Carbon $timestamp
     */
    public function setClosesAt(Carbon $timestamp)
    {
        $this->length = $timestamp->diffInSeconds($this->opensAt());

        $this->calculateClosesAt();
    }

    /**
     * Set the open date.
     *
     * @return  Carbon\Carbon
     */
    protected function getDefaultOpenAt()
    {
        $open = Carbon::parse('monday', $this->timezone);

        if ($this->day !== Carbon::MONDAY) {
            $open->next($this->day);
        }

        $time = Carbon::parse($this->time);

        $open->setTime($time->hour, $time->minute, $time->second);

        return $open;
    }

    protected function calculateClosesAt()
    {
        $this->closesAt = $this->opensAt->copy()->addSeconds($this->length);
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
}
