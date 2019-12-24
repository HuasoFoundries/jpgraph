<?php

/**
 * JPGraph v4.0.0
 */

/**
 * // File:        config.inc.php
 * // Description: Configuration constants and settings for JpGraph library
 * // Created:     2004-03-27
 * // Ver:         $Id: jpg-config.inc.php 1871 2009-09-29 05:56:39Z ljp $
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */

// check if jpgraph is the root folder
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));
} elseif (file_exists(dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/autoload.php')) {
    // otherwise, jpgraph was required as a composer dependency
    defined('ROOT_PATH') || define('ROOT_PATH', dirname(dirname(dirname(dirname(__DIR__)))));
}
require_once ROOT_PATH . '/vendor/autoload.php';

if (is_readable(ROOT_PATH . '/.env') && class_exists('\Symfony\Component\Dotenv\Dotenv')) {
    $dotenv = new \Symfony\Component\Dotenv\Dotenv();
    $dotenv->load(ROOT_PATH . '/.env');
}

if (getenv('JPGRAPH_DEBUGMODE') && !defined('DEBUGMODE')) {
    define('DEBUGMODE', getenv('JPGRAPH_DEBUGMODE'));
}
// Sets DEBUGMODE for the app. Set this to true to enable debugging outputs
defined('DEBUGMODE') || define('DEBUGMODE', false);

ini_set('display_errors', (int) DEBUGMODE);
ini_set('display_startup_errors', (int) DEBUGMODE);
if (DEBUGMODE) {
    error_reporting(E_ALL);
}
use \Amenadiel\JpGraph\Util;
define('USE_IMAGE_ERROR_HANDLER', false);
ini_set('display_errors', 1);
require __DIR__ . '/includes/polyfills.php';
//$retorno = UTil\Constants::SECPERDAY(86400);
//~d($retorno);

// init
Util\Helper::bootstrapLibrary();

// global variables I won't use anymore but maybe you do.
$__jpg_err_locale = Util\Helper::getErrLocale();
$__jpg_OldHandler = Util\JpGraphException::$previous_exception_handler;
