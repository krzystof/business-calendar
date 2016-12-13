<?php

namespace BusinessCalendar;

use InvalidArgumentException;

class Opening implements Openingable
{
    use CanBeCompiled, CompareWithOpening, HasOpenAndClosesAtAttributes;

    /**
     * The day of the week the Opening starts.
     *
     * @var int
     */
    protected $day;

    /**
     * The time the opening starts.
     *
     * @var string
     */
    protected $time;

    /**
     * The length of the opening.
     *
     * @var int
     */
    protected $length;

    /**
     * Create a new Opening.
     *
     * @param array $arguments
     */
    public function __construct($arguments)
    {
        if ($arguments['length'] > BusinessTime::SECONDS_PER_WEEK) {
            throw new InvalidArgumentException('The length of the Opening cannot exceed a week');
        }

        $this->day = (int) $arguments['day'];
        $this->time = $arguments['time'];
        $this->length = (int) $arguments['length'];
        $this->timezone = isset($arguments['timezone']) ? $arguments['timezone'] : 'Europe/Paris';
    }

    public function day()
    {
        return BusinessTime::dayToString($this->day);
    }

    public function time()
    {
        return $this->time;
    }

    public function length()
    {
        return $this->length;
    }

    /**
     * Convert an Opening to a String.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->opensAt().' '.$this->closesAt();
    }
}
