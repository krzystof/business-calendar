<?php

namespace BusinessCalendar;

use Carbon\Carbon;

trait CanBeCompiled
{
    /**
     * Check wether the Opening overlaps the other opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    public function overlaps($opening)
    {
        return $this->covers($opening) || $this->covers($opening->lastWeek());
    }

    /**
     * Merge two Opening together.
     *
     * @param  BusinessCalendar\Opening  $opening
     */
    public function merges($opening)
    {
        if (! $this->overlaps($opening)) {
            return;
        }

        if ($this->closesAt() < $opening->closesAt()) {
            $this->setClosesAt($opening->closesAt());
        }

        if ($this->opensAt() > $opening->opensAt()) {
            $this->setOpensAt($opening->opensAt());
        }
    }

    /**
     * Clone the opening set to the previous week dates.
     *
     * @return BusinessCalendar\Opening
     */
    public function lastWeek()
    {
        $lastWeek = new static([
            'day'      => $this->day,
            'time'     => $this->time,
            'length'   => $this->length,
            'timezone' => $this->timezone,
        ]);

        $lastWeek->moveOpening($lastWeek->opensAt()->subWeek());

        return $lastWeek;
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
        $this->calculateClosesAt();
    }
}
