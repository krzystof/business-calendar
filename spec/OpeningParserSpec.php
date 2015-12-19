<?php

namespace spec\BusinessCalendar;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use BusinessCalendar\OpeningCollection;
use BusinessCalendar\EnglishOpeningGrammar;

class OpeningParserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new EnglishOpeningGrammar);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BusinessCalendar\OpeningParser');
    }

    function it_parses_english_input_into_collection_of_openings()
    {
        $this->parse('Monday 8am 6pm')
            ->shouldBeAnInstanceOf(OpeningCollection::class);

        // $this->parse('thursday 8:00 for 8 hours')
        //     ->shouldBeAnInstanceOf(OpeningCollection::class)
        //     ->shouldHaveCount(1);

        // $this->parse('Tuesday from 12:00 to 18:00')
        //     ->shouldBeAnInstanceOf(OpeningCollection::class)
        //     ->shouldHaveCount(1);

        // $this->parse('Mon and Thu 10-12')
        //     ->shouldHaveCount(2);

        // $this->parse('Mo, Th-Fr, 0900-1600')
        //     ->shouldHaveCount(4);

        // $this->parse('from Monday to Friday, 9 to 5')
        //     ->shouldHaveCount(5);
    }
}
