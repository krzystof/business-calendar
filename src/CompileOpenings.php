<?php

namespace BusinessCalendar;

trait CompileOpenings
{
    /**
     * Count how many openings the working week contains.
     *
     * @return int
     */
    public function countOpenings()
    {
        return $this->openings->count();
    }

    /**
     * Loop through the openings Collection and merge
     * overlaping openings.
     *
     * @return void
     */
    protected function compileOpenings()
    {
        if ($this->countOpenings() === 1) {
            return;
        }

        $previous = $this->openings->last();
        foreach ($this->openings as $key => $opening) {
            if ($opening->overlaps($previous)) {
                $previous->merges($opening);
                $this->deleteOpening($key);

                return $this->compileOpenings();
            }

            $previous = $opening;
        }
    }
}
