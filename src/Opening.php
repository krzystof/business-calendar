<?php

namespace BusinessCalendar;

class Opening
{
    /**
     * The day of the week the Opening starts.
     *
     * @var integer
     */
    protected $day;

    /**
     * The time the opening starts.
     *
     * @var string
     */
    protected $start;

    /**
     * The length of the opening.
     *
     * @var integer
     */
    protected $length;

    /**
     * Create a new Opening.
     *
     * @param integer $day
     * @param string  $start
     * @param integer $length
     */
    public function __construct($day, $start, $length)
    {
        $this->day = $day;
        $this->start = $start;
        $this->length = $length;
    }


}
