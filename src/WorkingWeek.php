<?php

namespace BusinessCalendar;

use Carbon\Carbon;

class WorkingWeek
{
    /**
     * An Collection of Openings for the working week.
     *
     * @var array
     */
    protected $openings;

    protected $timezone;

    /**
     * Instantiate a new WorkingWeek.
     *
     * @param array $openings
     */
    public function __construct(OpeningCollection $openings, $timezone = 'Europe/Paris')
    {
        $this->openings = $openings;
        $this->timezone = $timezone;
    }

    /**
     * Add an opening to the working week.
     *
     * @param Opening $opening
     */
    public function addOpening(Opening $opening)
    {
        foreach ($this->openings as $storedOpening) {
            if ($opening->overlaps($storedOpening)) {
                $storedOpening->merges($opening);
            }
        }

        // echo $opening->closesAt();
        // echo ' and ' . $this->hasUpdatedOpenings();

        if (! $opening->hasBeenMerged()) {
            $this->openings->add($opening);
        }
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
     * Delete an opening from the working week.
     *
     * @param  integer $key
     */
    public function deleteOpening($key)
    {
        $this->openings->delete($key);
    }

    public function isOpenAt(Carbon $timestamp)
    {
        foreach ($this->openings as $opening) {
            if ($opening->isOpenAt($timestamp)) {
                return true;
            }
        }

        return false;
    }

    protected function hasUpdatedOpenings()
    {
        foreach ($this->openings as $opening) {
            if ($opening->hasBeenUpdated()) {
                return true;
            }
        }

        return false;
    }

    public function flushOpenings()
    {
        foreach ($this->openings as $key => $opening) {
            $this->deleteOpening($key);
        }
    }
}
