<?php

namespace BusinessCalendar;

use Carbon\Carbon;

trait ContainsOpenings
{
    /**
     * Check wether the working week is open at a given timestamp.
     *
     * @param  Datetime  $timestamp
     * @return boolean
     */
    public function isOpenAt(Carbon $timestamp)
    {
        foreach ($this->openings as $opening) {
            if ($opening->isOpenAt($timestamp)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Count how many openings the working week contains.
     *
     * @return integer
     */
    public function countOpenings()
    {
        return $this->openings->count();
    }

    /**
     * Loop through the openings Collection and merge
     * overlaping openings.
     *
     * @return void
     */
    protected function compileOpenings()
    {
        if ($this->countOpenings() === 1) {
            return;
        }

        $previous = $this->openings->last();

        foreach ($this->openings as $key => $opening) {
            if ($opening->overlaps($previous)) {
                $previous->merges($opening);
                $this->deleteOpening($key);

                return $this->compileOpenings();
            }

            $previous = $opening;
        }
    }
}

