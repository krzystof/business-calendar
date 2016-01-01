<?php

namespace BusinessCalendar;

interface Mergeable
{
    public function opensAt();

    public function closesAt();

    /**
     * Clone the opening set to the previous week dates.
     *
     * @return BusinessCalendar\Opening
     */
    public function lastWeek();
}
