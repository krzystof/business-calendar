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

    public function delete($opening)
    {
        $keyToDelete = array_search($opening, $this->openings);

        array_splice($this->openings, $keyToDelete, 1);
    }

    public function isEmpty()
    {
        return $this->count() === 0;
    }

    public function save()
    {
        return true;
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

    public function last()
    {
        return end($this->openings);
    }

    public function toJson()
    {
        return json_encode($this->openings);
    }

    public function map(callable $callback)
    {
        return array_map($callback, $this->openings);
    }

    public function reduce($callback)
    {
        return array_reduce($this->openings, $callback);
    }
}
