<?php

namespace spec\BusinessCalendar;

use Carbon\Carbon;
use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use BusinessCalendar\Opening;
use BusinessCalendar\OpeningArray;

class WorkingWeekSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new OpeningArray);
    }

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

    function it_merges_openings_when_they_overlap()
    {
        $opening1 = new Opening(Carbon::MONDAY, '8:00', 8*3600);
        $opening2 = new Opening(Carbon::MONDAY, '12:00', 8*3600);
        $this->addOpening($opening1);
        $this->addOpening($opening2);
        $this->countOpenings()->shouldReturn(1);

        // $opening3 = new Opening(Carbon::MONDAY, '07:00', 2*3600);
        // $this->addOpening($opening2);
        // $this->countOpenings()->shouldReturn(1);

        // $opening4 = new Opening(Carbon::MONDAY, '06:00', 24*3600);
        // $this->addOpening($opening4);
        // $this->countOpenings()->shouldReturn(1);

        // $opening5 = new Opening(Carbon::TUESDAY, '08:00', 24*3600);
        // $this->addOpening($opening5);
        // $this->countOpenings()->shouldReturn(2);

        // $opening6 = new Opening(Carbon::TUESDAY, '05:00', 4*3600);
        // $this->addOpening($opening6);
        // $this->countOpenings()->shouldReturn(1);
    }

    function it_checks_if_it_is_open_at_a_given_time()
    {
       $opening1 = new Opening(Carbon::MONDAY, '8:00', 8*3600);
       $this->addOpening($opening1);

       $this->isOpenAt(Carbon::parse('monday at 10:00', 'Europe/Paris'))->shouldReturn(true);
       $this->isOpenAt(Carbon::parse('monday at 07:00', 'Europe/Paris'))->shouldReturn(false);
    }
}
