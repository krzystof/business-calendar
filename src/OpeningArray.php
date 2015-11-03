<?php

namespace BusinessCalendar;

class OpeningArray implements OpeningCollection
{
    protected $openings = [];

    protected $position = 0;

    public function __construct()
    {
        $this->openings = [];
    }

    public function add(Opening $opening)
    {
        array_push($this->openings, $opening);
        $this->save();
    }

    public function count()
    {
        return count($this->openings);
    }

    public function delete($key)
    {
        unset($this->openings[$key]);
    }

    public function isEmpty()
    {
        return $this->count() === 0;
    }

    public function save()
    {
        foreach($this->openings as $opening) {
            $opening->setUpdated(false);
        }
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->openings[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->openings[$this->position]);
    }
}