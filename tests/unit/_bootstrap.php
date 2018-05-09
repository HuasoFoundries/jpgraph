<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

//define('CACHE_DIR', __DIR__ . '/_output/');
//define('USE_CACHE', true);

function GetFiles($folder)
{
    $d = @dir($folder);
    $a = [];
    while ($entry = $d->Read()) {
        if (is_file($folder . $entry) &&
            strstr($entry, '.php') &&
            strstr($entry, 'ex')
            && !strstr($entry, 'no_test')
            && !strstr($entry, 'no_dim')) {
            $a[] = $entry;
        }
    }
    $d->Close();
    if (count($a) == 0) {
        die("PANIC: Apache/PHP does not have enough permission to read the scripts in directory: {$folder}");
    }
    sort($a);

    return $a;
}

function getRoot($class)
{
    return UNIT_TEST_FOLDER . '/Examples/examples_' . $class . '/';
}

define('UNIT_TEST_FOLDER', dirname(dirname(__DIR__)));
