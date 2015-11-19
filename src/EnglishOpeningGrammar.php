<?php

namespace BusinessCalendar;

class EnglishOpeningGrammar implements OpeningGrammar
{
    protected $word;

    protected $days = [
        'sunday' => 0,
        'monday' => 1,
        'tuesday' => 2,
        'wednesday' => 3,
        'thursday' => 4,
        'friday' => 5,
        'saturday' => 6,
    ];

    public function __construct($word = '')
    {
        $this->setWord($word);
    }

    public function translate($word)
    {
        return new static($word);
    }

    public function __toString()
    {
        return $this->word;
    }

    public function isDay()
    {
        return array_key_exists($this->word, $this->days);
    }

    public function isTime()
    {
        return preg_match('/[0-9]+([a,p]m)?/', $this->word);
    }

    public function value()
    {
        if ($this->isDay()) {
            return $this->days[$this->word];
        }
    }

    public function word()
    {
        return $this->word;
    }

    protected function setWord($word)
    {
        $this->word = trim(strtolower($word));
    }
}
