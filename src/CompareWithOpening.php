<?php

namespace BusinessCalendar;

use Carbon\Carbon;

trait CompareWithOpening
{
    /**
     * The opening is open at a given timestamp
     *
     * @param  Carbon  $timestamp
     * @return boolean
     */
    public function isOpenAt($timestamp)
    {
        return $this->isOpenAtOrWillBeOpenAt($timestamp);
    }

    /**
     * Check if the opening is open at a given timestamp.
     *
     * @param  Carbon\Carbon  $time
     * @return bool
     */
    public function isOpenAtOrWillBeOpenAt($time)
    {
        return $time->between($this->opensAt(), $this->closesAt())
            || $time->copy()->addWeek()->between($this->opensAt(), $this->closesAt());
    }

    /**
     * Checks if an opening touches another opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    protected function covers($opening)
    {
        return $this->isOpenAtOrWillBeOpenAt($opening->opensAt())
            || $this->isOpenAtOrWillBeOpenAt($opening->closesAt())
            || $this->isContainedIn($opening);
    }

    protected function isContainedIn($opening)
    {
        return $opening->isOpenAt($this->opensAt()) && $opening->isOpenAt($this->closesAt());
    }
}
