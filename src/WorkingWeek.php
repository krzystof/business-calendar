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
        $this->openings->add($opening);
        $this->compileOpenings();
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

    /**
     * Delete all openings from the Collection.
     *
     * @return void
     */
    public function flushOpenings()
    {
        foreach ($this->openings as $key => $opening) {
            $this->deleteOpening($key);
        }
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

                $this->compileOpenings();
            }

            $previous = $opening;
        }

        $this->resetOpeningsFlags();
    }

    /**
     * Check wether it contains element in the Collection that
     * have been updated.
     *
     * @return boolean
     */
    protected function hasUpdatedOpenings()
    {
        foreach ($this->openings as $opening) {
            if ($opening->hasBeenUpdated()) {
                return true;
            }
        }

        return false;
    }

    protected function resetOpeningsFlags()
    {
        foreach ($this->openings as $opening) {
            $opening->setUpdated(false);
        }
    }
}
