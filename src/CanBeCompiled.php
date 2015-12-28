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
    public function overlaps(Opening $opening)
    {
        return $this->covers($opening) || $this->covers($opening->lastWeek());
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

        // @todo refactor to ! $this->isOpenAt($opening->closesAt())
        if ($this->closesAt() < $opening->closesAt()) {
            $this->setClosesAt($opening->closesAt());
        }

        // @todo refactor to $this->openAfter($opening)
        if ($this->opensAt() > $opening->opensAt()) {
            $this->setOpensAt($opening->opensAt());
        }
    }
}
