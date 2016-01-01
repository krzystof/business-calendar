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

    function it_overlaps_when_an_opening_closes_during_its_timeframe()
    {
        $opening1 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '08:00', 'length' => 4*3600,
        ]);

        $this->overlaps($opening1)->shouldReturn(true);
    }

    function it_overlaps_when_an_opening_opens_during_its_timeframe()
    {
        $opening2 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '13:00', 'length' => 2*3600,
        ]);

        $this->overlaps($opening2)->shouldReturn(true);
    }

    function it_doesnt_overlaps_when_an_opening_starts_after_its_timeframe()
    {
        $opening3 = new Opening([
            'day' => Carbon::WEDNESDAY, 'time' => '08:00', 'length' => 4*3600,
        ]);

        $this->overlaps($opening3)->shouldReturn(false);
    }

    function it_overlaps_when_an_opening_is_contained_in_its_timeframe()
    {
        $opening4 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '11:00', 'length' => 3600,
        ]);

        $this->overlaps($opening4)->shouldReturn(true);
    }

    function it_overlaps_when_an_opening_starts_the_day_before_and_closes_in_its_timeframe()
    {
        $opening5 = new Opening([
            'day' => Carbon::MONDAY, 'time' => '11:00', 'length' => 24*3600,
        ]);

        $this->overlaps($opening5)->shouldReturn(true);
    }

    function it_overlaps_when_an_opening_covers_its_timeframe()
    {
        $opening6 = new Opening([
            'day' => Carbon::TUESDAY, 'time' => '09:00', 'length' => 10*3600,
        ]);

        $this->overlaps($opening6)->shouldReturn(true);
    }

    function it_overlaps_when_an_opening_start_during_the_previous_week_and_closes_during_its_timeframe()
    {
        $opening7 = new Opening([
            'day' => Carbon::SUNDAY, 'time' => '23:00', 'length' => 36*3600,
        ]);

        $this->overlaps($opening7)->shouldReturn(true);
    }

    function it_overlaps_when_an_opening_start_during_the_previous_week_and_closes_after_its_timeframe()
    {
        $opening8 = new Opening([
            'day' => Carbon::SUNDAY, 'time' => '23:00', 'length' => 48*3600,
        ]);

        $this->overlaps($opening8)->shouldReturn(true);
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

    function it_gets_the_constant_value_for_the_day_of_the_week()
    {
        static::dayOfWeek('monday')->shouldReturn(1);
        static::dayOfWeek('sunday')->shouldReturn(0);
        static::dayOfWeek('Tuesday')->shouldReturn(2);
    }
}
