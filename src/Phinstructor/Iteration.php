<?php

namespace Phinstructor;

class Iteration
{
    public $aggregation;

    public $count;

    public function __construct( $aggregation, $count = 1 )
    {
        $this->aggregation = $aggregation;
        $this->count       = $count;
    }
}

