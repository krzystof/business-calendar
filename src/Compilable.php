<?php

namespace BusinessCalendar;

interface Compilable
{
    public function overlaps(Opening $opening);

    public function merges(Opening $opening);
}
