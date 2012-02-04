<?php

namespace Phinstructor;

class Runner
{
    public $training;

    public $visitor;

    public function __construct( $training, Visitor $visitor )
    {
        $this->training = $training;
        $this->visitor  = $visitor;
    }

    public function run()
    {
        $this->visitor->visit( $this->training );
    }
}

