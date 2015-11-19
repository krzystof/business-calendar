<?php

namespace spec\BusinessCalendar;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnglishOpeningGrammarSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BusinessCalendar\EnglishOpeningGrammar');
    }
}
