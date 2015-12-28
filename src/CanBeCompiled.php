<?php

namespace BusinessCalendar;

trait CanBeCompiled
{
    /**
     * Check wether the Opening overlaps the other opening.
     *
     * @param  BusinessCalendar\Opening $opening
     * @return bool
     */
    public function overlaps(Mergeable $opening)
    {
        return $this->covers($opening) || $this->covers($opening->lastWeek());
    }

    /**
     * Merge two Opening together.
     *
     * @param  BusinessCalendar\Opening  $opening
     */
    public function merges(Mergeable $opening)
    {
        if (! $this->overlaps($opening)) {
            return;
        }

        if ($this->closesAt() < $opening->closesAt) {
            $this->setClosesAt($opening->closesAt());
        }

        if ($this->opensAt() > $opening->opensAt()) {
            $this->setOpensAt($opening->opensAt());
        }
    }
}
