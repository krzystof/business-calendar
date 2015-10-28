<?php

namespace spec\BusinessCalendar;

use Carbon\Carbon;
use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use BusinessCalendar\Opening;

class OpeningSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Carbon::TUESDAY, '10:00', 4*3600);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BusinessCalendar\Opening');
    }

    function it_knows_when_it_opens_and_when_it_closes()
    {
        $this->opensAt()->shouldBeAnInstanceOf(Carbon::class);
        $this->opensAt()->format('l H:i')->shouldBe('Tuesday 10:00');
        $this->closesAt()->format('l H:i')->shouldBe('Tuesday 14:00');
    }

    // function it_checks_if_it_overlaps_another_opening()
    // {
    //     $opening1 = new Opening(Carbon::TUESDAY, '08:00', 4*3600);
    //     $opening2 = new Opening(Carbon::WEDNESDAY, '08:00', 4*3600);
    //     $opening3 = new Opening(Carbon::TUESDAY, '11:00', 3600);
    //     $opening4 = new Opening(Carbon::MONDAY, '11:00', 24*3600);

    //     $this->overlap($opening1)->shouldReturn(true);
    //     $this->overlap($opening2)->shouldReturn(false);
    //     $this->overlap($opening3)->shouldReturn(true);
    //     $this->overlap($opening4)->shouldReturn(true);
    // }
}
