<?php

namespace BusinessCalendar;

class WorkingWeek
{
    use CompileOpenings;

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
     * Check wether the working week is open at a given timestamp.
     *
     * @param  Datetime  $timestamp
     * @return bool
     */
    public function isOpenAt($timestamp)
    {
        foreach ($this->openings as $opening) {
            if ($opening->isOpenAt($timestamp)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add an opening to the working week.
     *
     * @param BusinessCalendar\Opening $opening
     */
    public function addOpening(Openingable $opening)
    {
        $this->openings->add($opening);

        $this->compileOpenings();
    }

    /**
     * Delete an opening from the working week.
     *
     * @param  int $key
     */
    public function deleteOpening(Openingable $opening)
    {
        $this->openings->delete($opening);
    }

    /**
     * Delete all openings from the Collection.
     *
     * @return void
     */
    public function flushOpenings()
    {
        foreach ($this->openings as $opening) {
            $this->deleteOpening($opening);
        }
    }

    public function openTimeOn($weekDay)
    {
        foreach ($this->openings as $opening) {
            if ($opening->day() === $weekDay) {
                return $opening->time();
            }
        }
    }
}
