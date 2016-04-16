<?php

namespace BusinessCalendar;

use Carbon\Carbon;

interface Openingable extends Mergeable, Compilable
{
    public function isOpenAt($time);
}

