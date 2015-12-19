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
        $this->beConstructedWith([
            'day'    => Carbon::TUESDAY,
            'time'   => '10:00',
            'length' => 4 * 3600,
        ]);
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
        $opening1 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '08:00', 'length' => 4*3600,
        ]);
        $this->overlaps($opening1)->shouldReturn(true);

        $opening2 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '13:00', 'length' => 2*3600,
        ]);
        $this->overlaps($opening2)->shouldReturn(true);

        $opening3 = new Opening([
            'day' => Carbon::WEDNESDAY, 'time' => '08:00', 'length' => 4*3600,
        ]);
        $this->overlaps($opening3)->shouldReturn(false);

        $opening4 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '11:00', 'length' => 3600,
        ]);
        $this->overlaps($opening4)->shouldReturn(true);

        $opening5 = new Opening([
            'day' => Carbon::MONDAY, 'time' => '11:00', 'length' => 24*3600,
        ]);
        $this->overlaps($opening5)->shouldReturn(true);

        $opening6 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '09:00', 'length' => 10*3600,
        ]);
        $this->overlaps($opening6)->shouldReturn(true);

        $opening7 = new Opening([
            'day' => Carbon::SUNDAY, 'time' => '23:00', 'length' => 36*3600,
        ]);
        $this->overlaps($opening7)->shouldReturn(true);

        $opening8 = new Opening([
            'day' => Carbon::SUNDAY, 'time' => '23:00', 'length' => 48*3600,
        ]);
        $this->overlaps($opening8)->shouldReturn(true);

        $opening9 = new Opening([
            'day' => Carbon::SUNDAY, 'time' => '23:00', 'length' => 24*3600,
        ]);
        $this->overlaps($opening9)->shouldReturn(false);
    }

    function it_is_invalid_when_the_length_exceeds_a_week()
    {
        $this->beConstructedWith([
            'day' => Carbon::MONDAY,
            'time' => '08:00',
            'length' => 10 * 24 * 3600
        ]);

        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }
}
