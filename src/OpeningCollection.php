<?php

namespace BusinessCalendar;

interface OpeningCollection extends \Iterator
{
    public function add(Openingable $opening);

    public function count();

    public function delete($key);

    public function map(callable $callback);

    public function isEmpty();

    public function save();

    public function last();
}
