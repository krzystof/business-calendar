<?php

namespace BusinessCalendar;

interface Mergeable
{
    public function opensAt();
    public function closesAt();
    public function lastWeek();
}
