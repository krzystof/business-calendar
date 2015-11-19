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

        $opening = new Opening([
            'day' => Carbon::MONDAY, 'time' => '8:00', 'length' => 8*3600
        ]);
        $this->addOpening($opening);
        $this->countOpenings()->shouldReturn(1);

        $opening = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '8:00', 'length' => 8*3600
        ]);
        $this->addOpening($opening);
        $this->countOpenings()->shouldReturn(2);
    }

    function it_removes_openings()
    {
        $opening = new Opening([
            'day' => Carbon::MONDAY, 'time' => '8:00', 'length' => 8*3600
        ]);
        $this->addOpening($opening);
        $this->deleteOpening(0);
        $this->countOpenings()->shouldReturn(0);
    }

    function it_flushes_openings()
    {
        $opening = new Opening([
            'day' => Carbon::MONDAY, 'time' => '8:00', 'length' => 8*3600
        ]);
        $this->addOpening($opening);
        $this->flushOpenings();
        $this->countOpenings()->shouldReturn(0);
    }

    function it_checks_if_it_is_open_at_a_given_time()
    {
        $opening1 = new Opening([
            'day' => Carbon::MONDAY, 'time' => '8:00', 'length' => 8*3600
        ]);
        $this->addOpening($opening1);

        $this->isOpenAt(Carbon::parse('monday 07:00', 'Europe/Paris'))->shouldReturn(false);
        $this->isOpenAt(Carbon::parse('monday 10:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('tuesday 10:00', 'Europe/Paris'))->shouldReturn(false);
    }

    function it_checks_if_it_is_open_and_merges_openings_when_they_overlap()
    {
        $opening1 = new Opening([
            'day' => Carbon::MONDAY, 'time' => '8:00', 'length' => 8*3600
        ]);
        $this->addOpening($opening1);
        $this->countOpenings()->shouldReturn(1);
        $this->isOpenAt(Carbon::parse('monday 7:00', 'Europe/Paris'))->shouldReturn(false);
        $this->isOpenAt(Carbon::parse('monday 9:00', 'Europe/Paris'))->shouldReturn(true);

        $opening2 = new Opening([
            'day' => Carbon::MONDAY, 'time' => '12:00', 'length' => 8*3600
        ]);
        $this->addOpening($opening2);
        $this->countOpenings()->shouldReturn(1);
        $this->isOpenAt(Carbon::parse('monday 7:00', 'Europe/Paris'))->shouldReturn(false);
        $this->isOpenAt(Carbon::parse('monday 9:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('monday 13:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('monday 19:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('tuesday 08:10', 'Europe/Paris'))->shouldReturn(false);

        $opening3 = new Opening([
            'day' => Carbon::MONDAY, 'time' => '07:00', 'length' => 2*3600
        ]);
        $this->addOpening($opening3);
        $this->countOpenings()->shouldReturn(1);
        $this->isOpenAt(Carbon::parse('monday 07:05', 'Europe/Paris'))->shouldReturn(true);

        $opening4 = new Opening([
            'day' => Carbon::MONDAY, 'time' => '06:00', 'length' => 24*3600
        ]);
        $this->addOpening($opening4);
        $this->countOpenings()->shouldReturn(1);
        $this->isOpenAt(Carbon::parse('tuesday 03:35', 'Europe/Paris'))->shouldReturn(true);

        $opening5 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '08:00', 'length' => 24*3600
        ]);
        $this->addOpening($opening5);
        $this->countOpenings()->shouldReturn(2);

        $opening6 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '05:00', 'length' => 4*3600
        ]);
        $this->addOpening($opening6);
        $this->countOpenings()->shouldReturn(1);
    }

    // function it_checks_for_an_opening_regardless_of_the_date()
    // {
    //     # code...
    // }
}
