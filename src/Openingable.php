<?php

namespace BusinessCalendar;

interface Openingable extends Mergeable, Compilable
{
    public function isOpenAt($time);
}
