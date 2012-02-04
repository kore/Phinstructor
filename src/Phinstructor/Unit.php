<?php

namespace Phinstructor;

class Unit
{
    public $time;

    public $pause;

    public function __construct( $time, $pause = 0 )
    {
        $this->time  = $time;
        $this->pause = $pause;
    }
}

