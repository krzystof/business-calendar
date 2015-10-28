<?php

namespace spec\BusinessCalendar;

use Carbon\Carbon;
use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use BusinessCalendar\Opening;

class WorkingWeekSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BusinessCalendar\WorkingWeek');
    }

    function it_stores_and_count_openings()
    {
        $this->countOpenings()->shouldReturn(0);

        $opening = new Opening(Carbon::MONDAY, '8:00', 8*3600);

        $this->addOpening($opening);

        $this->countOpenings()->shouldReturn(1);

        $opening = new Opening(Carbon::TUESDAY, '8:00', 8*3600);

        $this->addOpening($opening);

        $this->countOpenings()->shouldReturn(2);
    }

    function it_removes_openings()
    {
        $opening = new Opening(Carbon::MONDAY, '8:00', 8*3600);

        $this->addOpening($opening);

        $this->deleteOpening(0);

        $this->countOpenings()->shouldReturn(0);
    }
}
