<?php

/**
 * JPGraph - Community Edition
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

class ExceptionFactory
{
    /**
     * 
     * @param mixed $errnbr 
     * @param mixed $args 
     * @return string
     */
    public function Get($errnbr, ...$args)
    {
        if (!$errorMessageStr = Helper::getErrorMessage($errnbr)) {
            return \sprintf(
                'Internal error: The specified error message (%s) does not exist in the chosen locale (%s)',
                $errnbr,
                Helper::getErrLocale()
            );
        }

        try {
            return \vsprintf($errorMessageStr[0], $args);
        } catch (\Exception $e) {
            return $errorMessageStr[0];
        }
    }
    /**
     * 
     * @param mixed $errnbr 
     * @param mixed $args 
     * @return JpGraphException 
     */
    public static function create($errnbr, ...$args):JpGraphException
    {
        return new JpGraphException((new self())->Get($errnbr, ...$args));
    }
}
