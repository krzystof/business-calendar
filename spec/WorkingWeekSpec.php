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

        $this->addOpening(new Opening([
            'day' => Carbon::MONDAY, 'time' => '8:00', 'length' => 8*3600
        ]));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BusinessCalendar\WorkingWeek');
    }

    function it_stores_and_count_openings()
    {
        $this->countOpenings()->shouldReturn(1);

        $this->addOpening(new Opening([
            'day' => Carbon::TUESDAY, 'time' => '8:00', 'length' => 8*3600
        ]));

        $this->countOpenings()->shouldReturn(2);
    }

    function it_removes_openings()
    {
        $this->deleteOpening(0);

        $this->countOpenings()->shouldReturn(0);
    }

    function it_flushes_openings()
    {
        $this->flushOpenings();

        $this->countOpenings()->shouldReturn(0);
    }

    function it_checks_if_it_is_open_at_a_given_time()
    {
        $this->isOpenAt(Carbon::parse('monday 07:00', 'Europe/Paris'))->shouldReturn(false);
        $this->isOpenAt(Carbon::parse('monday 10:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('tuesday 10:00', 'Europe/Paris'))->shouldReturn(false);
    }

    function it_merges_openings_if_the_new_one_starts_during_the_stored_one()
    {
        $this->addOpening(new Opening([
            'day' => Carbon::MONDAY, 'time' => '12:00', 'length' => 8*3600
        ]));

        $this->countOpenings()->shouldReturn(1);
        $this->isOpenAt(Carbon::parse('monday 7:00', 'Europe/Paris'))->shouldReturn(false);
        $this->isOpenAt(Carbon::parse('monday 9:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('monday 13:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('monday 19:00', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('tuesday 08:10', 'Europe/Paris'))->shouldReturn(false);
    }

    function it_merges_openings_if_the_new_one_starts_before_the_stored_one()
    {
        $this->addOpening(new Opening([
            'day' => Carbon::MONDAY, 'time' => '07:00', 'length' => 2*3600
        ]));

        $this->countOpenings()->shouldReturn(1);
        $this->isOpenAt(Carbon::parse('monday 07:05', 'Europe/Paris'))->shouldReturn(true);
    }

    function it_merges_openings_if_the_new_one_completely_covers_the_stored_one()
    {
        $this->addOpening(new Opening([
            'day' => Carbon::MONDAY, 'time' => '06:00', 'length' => 12 * 3600
        ]));

        $this->countOpenings()->shouldReturn(1);
        $this->isOpenAt(Carbon::parse('monday 06:01', 'Europe/Paris'))->shouldReturn(true);
        $this->isOpenAt(Carbon::parse('monday 17:50', 'Europe/Paris'))->shouldReturn(true);
    }

    function it_doesnt_merge_opening_if_they_dont_overlap()
    {
        $this->addOpening(new Opening([
            'day' => Carbon::TUESDAY, 'time' => '08:00', 'length' => 24 * 3600
        ]));

        $this->countOpenings()->shouldReturn(2);
    }

    function it_merges_three_openings_into_one_if_the_added_one_overlaps_two_stored_ones()
    {
        $this->addOpening(new Opening([
            'day' => Carbon::MONDAY, 'time' => '20:00', 'length' => 4 * 3600
        ]));
        $this->addOpening(new Opening([
            'day' => Carbon::MONDAY, 'time' => '15:00', 'length' => 6 * 3600
        ]));

        $this->countOpenings()->shouldReturn(1);
    }

    function it_doesnt_care_if_the_opening_starts_before_now_and_we_check_dates_after_now()
    {
        $this->addOpening(new Opening([
            'day' => Carbon::now()->dayOfWeek,
            'time' => Carbon::now()->subHour()->format('h:i'),
            'length' => 4 * 3600
        ]));

        $this->isOpenAt(Carbon::now('Europe/Paris')->addHour())
            ->shouldReturn(true);
    }
}
