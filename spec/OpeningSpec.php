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

    function it_returns_the_open_at_and_close_at_times()
    {
        $this->opensAt()->shouldBeAnInstanceOf(Carbon::class);
        $this->opensAt()->format('l H:i')->shouldBe('Tuesday 10:00');
        $this->closesAt()->format('l H:i')->shouldBe('Tuesday 14:00');
    }

    function it_checks_if_it_overlaps_with_another_opening()
    {
        $opening1 = new Opening(Carbon::TUESDAY, '08:00', 4*3600);
        $opening2 = new Opening(Carbon::TUESDAY, '13:00', 2*3600);
        $opening3 = new Opening(Carbon::WEDNESDAY, '08:00', 4*3600);
        $opening4 = new Opening(Carbon::TUESDAY, '11:00', 3600);
        $opening5 = new Opening(Carbon::MONDAY, '11:00', 24*3600);
        $opening6 = new Opening(Carbon::TUESDAY, '09:00', 10*3600);
        $opening7 = new Opening(Carbon::SUNDAY, '23:00', 36*3600);
        $opening8 = new Opening(Carbon::SUNDAY, '23:00', 48*3600);

        $this->overlaps($opening1)->shouldReturn(true);
        $this->overlaps($opening2)->shouldReturn(true);
        $this->overlaps($opening3)->shouldReturn(false);
        $this->overlaps($opening4)->shouldReturn(true);
        $this->overlaps($opening5)->shouldReturn(true);
        $this->overlaps($opening6)->shouldReturn(true);
        $this->overlaps($opening7)->shouldReturn(true);
        $this->overlaps($opening8)->shouldReturn(true);
    }
}
