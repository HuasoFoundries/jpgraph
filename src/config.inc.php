<?php

/**
 * JPGraph v4.1.0-beta.01
 */
require_once __DIR__ . '/../vendor/autoload.php';


use Amenadiel\JpGraph\Util;

require_once __DIR__ . '/polyfills.php';
Util\Helper::bootstrapLibrary();

// global variables I won't use anymore but maybe you do.
$__jpg_err_locale = Util\Helper::getErrLocale();
$__jpg_OldHandler = Util\JpGraphException::$previous_exception_handler;
