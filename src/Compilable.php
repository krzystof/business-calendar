<?php

namespace BusinessCalendar;

interface Compilable
{
    public function overlaps(Mergeable $opening);

    public function merges(Mergeable $opening);
}
