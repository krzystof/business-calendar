<?php

namespace BusinessCalendar;

interface MergesOpening
{
    public function overlaps(Opening $opening);

    public function merges(Opening $opening);
}
