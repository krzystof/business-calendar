<?php

namespace BusinessCalendar;

interface DateRange
{
    public function overlaps(Opening $opening);

    public function merges(Opening $opening);
}
