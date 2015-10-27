<?php

namespace BusinessCalendar;

class WorkingHours
{
    /**
     * An array of the Openings for this WorkingHours.
     *
     * @var array
     */
    protected $openings;

    /**
     * Instantiate a new WorkingHours.
     *
     * @param array $openings
     */
    public function __construct($openings = [])
    {
        $this->openings = $openings;
    }

    /**
     * Add an opening to the working hours.
     *
     * @param Opening $opening
     */
    public function addOpening(Opening $opening)
    {
        $this->openings[] = $opening;
    }

    /**
     * Count how many openings this working hours contains.
     *
     * @return integer
     */
    public function countOpenings()
    {
        return count($this->openings);
    }
}
