<?php

namespace BusinessCalendar;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class OpeningParser
{
    protected $fragments = [];

    protected $timezone;

    protected $grammar;

    public function __construct(OpeningGrammar $grammar, $timezone = 'Europe/London')
    {
        $this->grammar = $grammar;
        $this->timezone = $timezone;
    }

    public function parse($stringInput)
    {
        $this->setFragments($stringInput);

        return $this->transformToOpenings();
    }

    protected function setFragments($input)
    {
        $words = explode(' ', $input);

        foreach($words as $word) {
            $this->fragments[] = $this->grammar->translate($word);
        }
    }

    protected function transformToOpenings()
    {
        return new OpeningArray(new Opening($this->getParameters()));
    }

    protected function getParameters()
    {
        return [
            'day' => $this->getDay(),
            'time' => $this->getOpenTime()->format('h:i'),
            'length' => $this->getLength(),
            'timezone' => $this->timezone
        ];
    }

    protected function getDay()
    {
        foreach ($this->fragments as $fragment) {
            if ($fragment->isDay()) {
                return $fragment->value();
            }
        }
    }

    protected function getOpenTime()
    {
        foreach ($this->fragments as $fragment) {
            if ($fragment->isTime()) {

                return Carbon::parse($fragment);
            }
        }
    }

    protected function getLength()
    {
        foreach(array_reverse($this->fragments) as $fragment) {
            if ($fragment->isTime()) {
                return Carbon::parse($fragment)->diffInSeconds($this->getOpenTime());
            }
        }
    }
}
