<?php

namespace BusinessCalendar;

interface Openingable extends Mergeable, Compilable
{
    public function isOpenAtOrWillBeOpenAt($time);
}
