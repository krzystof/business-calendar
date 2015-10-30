<?php

namespace BusinessCalendar;

class WorkingWeek
{
    /**
     * An Collection of Openings for the working week.
     *
     * @var array
     */
    protected $openings;

    /**
     * Instantiate a new WorkingWeek.
     *
     * @param array $openings
     */
    public function __construct(OpeningCollection $openings)
    {
        $this->openings = $openings;
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

        if (! $this->hasUpdatedOpenings()) {
            $this->openings->add($opening);
        }

        $this->openings->save();
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

    protected function hasUpdatedOpenings()
    {
        foreach ($this->openings as $opening) {
            if ($opening->hasBeenUpdated()) {
                return true;
            }
        }

        return false;
    }
}
