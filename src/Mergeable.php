<?php

namespace BusinessCalendar;

use Carbon\Carbon;

interface Mergeable
{
    public function touch(Opening $opening);
    public function opensAt();
    public function setOpensAt(Carbon $timestamp);
    public function closesAt();
    public function setClosesAt(Carbon $timestamp);
    public function isOpenAt(Carbon $timestamp);
    public function isContainedIn(Opening $opening);
}
