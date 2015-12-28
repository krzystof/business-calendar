<?php

namespace BusinessCalendar;

trait MergesOpening
{
    /**
     * Check wether the Opening overlaps the other opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    public function overlaps(Opening $opening)
    {
        return $this->touch($opening) || $this->touch($opening->lastWeek());
    }

    /**
     * Merge two Opening together.
     *
     * @param  BusinessCalendar\Opening  $opening
     */
    public function merges(Opening $opening)
    {
        if (! $this->overlaps($opening)) {
            return;
        }

        if ($this->closesAt() < $opening->closesAt()) {
            $this->setClosesAt($opening->closesAt());
        }

        if ($this->opensAt() > $opening->opensAt()) {
            $this->setOpensAt($opening->opensAt());
        }
    }
}
