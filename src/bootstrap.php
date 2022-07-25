<?php

/**
 * JPGraph - Community Edition
 */

use Amenadiel\JpGraph\Util\Helper;
use Kint\Kint;
use Symfony\Component\Console\Output\ConsoleOutput;

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
if (!\function_exists('kdump')) {
    // I'm sure this can be improved... just not today
    if (\class_exists(Kint::class)) {
        function kdump(...$vars)
        {
            Kint::$enabled_mode = Kint::MODE_CLI;
            $return = Kint::$return;
            Kint::$return = true;
            //\fwrite(STDERR, Kint::dump(...$vars));
            $fp = \fopen('php://stderr', 'ab');
            \fwrite(STDERR, Kint::dump(...$vars));
            \fclose($fp);

            Kint::$return = $return;
        }

        Kint::$aliases[] = 'kdump';
    } else {
        function kdump(...$vars)
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
        kdump(...$vars);

        exit();
    }

    if (\class_exists(Kint::class)) {
        Kint::$aliases[] = 'dd';
    }
}
/*
 * Dump to stderr and exit
 */
if (!\function_exists('dump')) {
    function dump(...$vars): void
    {
        kdump(...$vars);

        exit();
    }

    if (\class_exists(Kint::class)) {
        Kint::$aliases[] = 'dump';
    }
}
if (!function_exists('boot_jpgraph')) {
    function boot_jpgraph()
    {
        return   Helper::getInstance();
    }
}
if (!function_exists('console')) {
    function console(): ConsoleOutput
    {
        return   Helper::getConsole();
    }
}
