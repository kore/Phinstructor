<?php

namespace Phinstructor\Visitor;
use Phinstructor,
    Phinstructor\Visitor;

class ESpeach extends Visitor
{
    protected $voice;

    public function __construct( $voice = 'en' )
    {
        $this->voice = $voice;
    }

    public function visit( $training )
    {
        switch ( true )
        {
            case $training instanceof Phinstructor\Training:
                $this->visitTraining( $training );
                return;

            case $training instanceof Phinstructor\Iteration:
                $this->visitIteration( $training );
                return;

            case $training instanceof Phinstructor\Practice:
                return $this->visitPractice( $training );

            case $training instanceof Phinstructor\Unit:
                return $this->visitUnit( $training );

            default:
                throw new \RuntimeException(
                    "Unhandled element in visitor: " . get_class( $training )
                );
        }
    }

    public function visitTraining( Phinstructor\Training $training )
    {
        $this->say( "Training will start in 10 seconds. Prepare." );
        sleep( 10 );

        $this->visit( $training->aggregation );

        $this->say( "Finished for today." );
    }

    public function visitIteration( Phinstructor\Iteration $iteration )
    {
        for ( $i = 0; $i < $iteration->count; ++$i )
        {
            $aggregation = clone $iteration->aggregation;
            $aggregation->iteration = $i;
            $this->visit( $aggregation );
        }
    }

    public function visitPractice( Phinstructor\Practice $practice )
    {
        $this->say( "Starting practice " . ( $practice->iteration + 1 ) );
        $this->visit( $practice->aggregation );
    }

    public function visitUnit( Phinstructor\Unit $unit )
    {
        $this->say( "Start unit " . ( $unit->iteration + 1 ) );
        for ( $countdown = $unit->time; $countdown > 0; --$countdown )
        {
            switch ( $countdown )
            {
                case 600:
                    $this->say( '10 minutes left.' );
                    break;

                case 300:
                    $this->say( '5 minutes left.' );
                    break;

                case 120:
                    $this->say( '2 minutes left.' );
                    break;

                case 60:
                    $this->say( '1 minute left.' );
                    break;

                case 30:
                    $this->say( '30 seconds left.' );
                    break;

                case 10:
                    $this->say( '10 seconds left.' );
                    break;
            }

            sleep( 1 );
        }

        if ( $unit->pause > 0 )
        {
            $this->say( "Pause for " . $unit->pause . " seconds." );
            sleep( $unit->pause );
        }
    }

    protected function say( $message )
    {
        echo $message, PHP_EOL;
        exec(
            "espeak -v " . escapeshellarg( $this->voice ) . " " .
            escapeshellarg( $message ) . " 2>&1 >/dev/null &"
        );
    }
}

