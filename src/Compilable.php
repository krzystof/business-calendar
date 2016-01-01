<?php

namespace BusinessCalendar;

interface Compilable
{
    /**
     * Check wether the Opening overlaps the other opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    public function overlaps(Mergeable $opening);

    /**
     * Merge two Opening together.
     *
     * @param  BusinessCalendar\Opening  $opening
     */
    public function merges(Mergeable $opening);
}
