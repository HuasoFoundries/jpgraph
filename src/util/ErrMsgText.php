<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Util;

/*
 * File:        JPGRAPH_ERRHANDLER.PHP
 * // Description: Error handler class together with handling of localized
 * //              error messages. All localized error messages are stored
 * //              in a separate file under the "lang/" subdirectory.
 * // Created:     2006-09-24
 * // Ver:         $Id: jpgraph_errhandler.inc.php 1920 2009-12-08 10:02:26Z ljp $
 * //
 * // Copyright 2006 (c) Aditus Consulting. All rights reserved.
 */
if (!defined('DEFAULT_ERR_LOCALE')) {
    define('DEFAULT_ERR_LOCALE', 'en');
}

if (!defined('USE_IMAGE_ERROR_HANDLER')) {
    define('USE_IMAGE_ERROR_HANDLER', true);
}

class ErrMsgText
{
    private $lt;

    public function __construct()
    {

        $locale_messages_file = sprintf('%s/lang/%s.inc.php', dirname(__DIR__), Helper::getErrLocale());

        if (!file_exists($locale_messages_file)) {
            $error_message =
                sprintf(
                'Chosen locale file ("%s") for error messages does not exist or is not readable for the PHP process. Please make sure that the file exists and that the file permissions are such that the PHP process is allowed to read this file.', $locale_messages_file);
            die($error_message);
        }
        require $locale_messages_file;

        $this->lt = $_jpg_messages;
    }

    public function Get($errnbr, $a1 = null, $a2 = null, $a3 = null, $a4 = null, $a5 = null)
    {
        if (!isset($this->lt[$errnbr])) {
            return sprintf(
                'Internal error: The specified error message (%s) does not exist in the chosen locale (%s)',
                $errnbr,
                Helper::getErrLocale());
        }
        $ea = $this->lt[$errnbr];
        /**
         * @TODO I've been avoiding refactoring this madness. I know
         *
         * @var integer
         */
        $j = 0;
        if ($a1 !== null) {
            $argv[$j++] = $a1;
            if ($a2 !== null) {
                $argv[$j++] = $a2;
                if ($a3 !== null) {
                    $argv[$j++] = $a3;
                    if ($a4 !== null) {
                        $argv[$j++] = $a4;
                        if ($a5 !== null) {
                            $argv[$j++] = $a5;
                        }
                    }
                }
            }
        }
        $numargs = $j;
        if ($ea[1] != $numargs) {
            // Error message argument count do not match.
            // Just return the error message without arguments.
            return $ea[0];
        }
        switch ($numargs) {
            case 1:
                $msg = sprintf($ea[0], $argv[0]);

                break;
            case 2:
                $msg = sprintf($ea[0], $argv[0], $argv[1]);

                break;
            case 3:
                $msg = sprintf($ea[0], $argv[0], $argv[1], $argv[2]);

                break;
            case 4:
                $msg = sprintf($ea[0], $argv[0], $argv[1], $argv[2], $argv[3]);

                break;
            case 5:
                $msg = sprintf($ea[0], $argv[0], $argv[1], $argv[2], $argv[3], $argv[4]);

                break;
            case 0:
            default:
                $msg = sprintf($ea[0]);

                break;
        }

        return $msg;
    }
}
