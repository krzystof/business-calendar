<?php

namespace spec\BusinessCalendar;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BusinessTimeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('BusinessCalendar\BusinessTime');
    }

    public function it_converts_a_day_from_string_to_integer()
    {
        static::dayFromString('tuesday')->shouldReturn(2);
    }

    public function it_is_case_insensitive_when_converting_a_day()
    {
        static::dayFromString('Friday')->shouldReturn(5);
        static::dayFromString('Monday')->shouldReturn(1);
        static::dayFromString('Sunday')->shouldReturn(0);
    }

    public function it_converts_a_day_from_integer_to_string()
    {
        static::dayToString(0)->shouldReturn('Sunday');
        static::dayToString(3)->shouldReturn('Wednesday');
        static::dayToString(6)->shouldReturn('Saturday');
    }

    public function it_converts_hours_to_integer()
    {
        static::hoursToSeconds(1.5)->shouldBeInteger();
    }

    public function it_convert_from_hours_to_seconds()
    {
        static::hoursToSeconds(2)->shouldReturn(7200);
    }

    public function it_converts_seconds_to_double()
    {
        static::secondsToHours(1648)->shouldBeDouble();
    }

    public function it_convert_from_seconds_to_hours()
    {
        static::secondsToHours(3600)->shouldBeLike(1);
    }

    public function it_rounds_with_zero_decimals_by_default()
    {
        static::secondsToHours(1900)->shouldBeLike(1);
    }

    public function it_can_round_hours_with_custom_precision()
    {
        static::secondsToHours(1800, 1)->shouldReturn(0.5);
    }
}
