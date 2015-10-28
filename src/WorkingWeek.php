<?php

namespace BusinessCalendar;

class WorkingWeek
{
    /**
     * An array of Openings for the working week.
     *
     * @var array
     */
    protected $openings;

    /**
     * Instantiate a new WorkingWeek.
     *
     * @param array $openings
     */
    public function __construct($openings = [])
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
        $this->openings[] = $opening;
    }

    /**
     * Count how many openings the working week contains.
     *
     * @return integer
     */
    public function countOpenings()
    {
        return count($this->openings);
    }

    /**
     * Delete an opening from the working week.
     *
     * @param  integer $key
     */
    public function deleteOpening($key)
    {
        unset($this->openings[$key]);
    }
}
