<?php

namespace spec\BusinessCalendar;

use Carbon\Carbon;
use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use BusinessCalendar\Opening;

class WorkingHoursSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BusinessCalendar\WorkingHours');
    }

    function it_stores_and_count_openings()
    {
        $this->countOpenings()->shouldReturn(0);

        $opening = new Opening(Carbon::MONDAY, '8:00', 8*3600);

        $this->addOpening($opening);

        $this->countOpenings()->shouldReturn(1);
    }
}
