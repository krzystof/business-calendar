<?php

namespace BusinessCalendar;

class WorkingWeek
{
    use ContainsOpenings;

    /**
     * An Collection of Openings for the working week.
     *
     * @var array
     */
    protected $openings;

    /**
     * The Timezone to use for time comparison.
     *
     * @var string
     */
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
     * Delete an opening from the working week.
     *
     * @param  integer $key
     */
    public function deleteOpening($key)
    {
        $this->openings->delete($key);
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
}
