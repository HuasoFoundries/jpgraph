<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Amenadiel\JpGraph\Util;

Util\Helper::bootstrapLibrary();

// global variables I won't use anymore but maybe you do.
$__jpg_err_locale = Util\Helper::getErrLocale();
$__jpg_OldHandler = Util\JpGraphException::$previous_exception_handler;
