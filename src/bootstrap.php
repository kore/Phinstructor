<?php

namespace Phinstructor;

spl_autoload_register(
    function ( $class )
    {
        if ( 0 === strpos( $class, __NAMESPACE__ ) )
        {
            include __DIR__ . '/' . strtr( $class, '\\', '/' ) . '.php';
        }
    }
);

