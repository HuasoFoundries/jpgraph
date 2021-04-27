<?php

/**
 * JPGraph v4.1.0-beta.01
 */

use Kint\Kint;

if (!\function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    function tap($value, ?callable $callback = null)
    {
        if (null !== $callback) {
            $callback($value);
        }

        return $value;
    }
}

/*
 * Unless there's a dump function declared already, declare
 * one so we can use it safely elsewhere. Mostly used while developing
 */
if (!\function_exists('dump')) {
    // I'm sure this can be improved... just not today
    if (class_exists(Kint::class)) {
        function dump(...$vars)
        {
            Kint::$enabled_mode = Kint::MODE_CLI;
            $return             = Kint::$return;
            Kint::$return       = true;
            $fp                 = \fopen('php://stderr', 'ab');
            \fwrite($fp, Kint::dump(...$vars));
            \fclose($fp);
            $return       = Kint::$return;
            Kint::$return = $return;
        }

        Kint::$aliases[] = 'dump';
    } else {
        function dump(...$vars)
        {
        }
    }
}

/*
 * Dump to stderr and exit
 */
if (!\function_exists('dd')) {
    function dd(...$vars): void
    {
        dump(...$vars);

        exit();
    }
    if (class_exists(Kint::class)) {
        Kint::$aliases[] = 'dd';
    }
}
