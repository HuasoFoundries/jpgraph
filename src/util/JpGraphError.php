<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Util;

//
// A wrapper class that is used to access the specified error object
// (to hide the global error parameter and avoid having a GLOBAL directive
// in all methods.
//
class JpGraphError
{
    private static $__iImgFlg  = true;
    private static $__iLogFile = '';
    private static $__iTitle   = 'JpGraph Error: ';
    public static $previous_handler;

    /**
     * Generic error or exception messages
     *
     * @param <type>  $aMsg   A message
     *
     * @throws JpGraphException  (description)
     */
    public static function Raise($aMsg)
    {
        throw new JpGraphException($aMsg);
    }

    /**
     * Customized and i18n error messages
     *
     * @param int  $error_number  The error number (it will be searched in locale file)
     * @param string  $a1            A 1
     * @param string  $a2            A 2
     * @param string  $a3            A 3
     * @param string  $a4            A 4
     * @param string  $a5            A 5
     *
     * @throws JpGraphExceptionL  (description)
     */
    public static function RaiseL($error_number, $a1 = null, $a2 = null, $a3 = null, $a4 = null, $a5 = null)
    {
        $errtxt = new ErrMsgText();
        self::SetTitle('JpGraph Error: ' . $error_number);
        $exceptionMessage = $errtxt->Get($error_number, $a1, $a2, $a3, $a4, $a5);
        throw new JpGraphException($exceptionMessage);
    }

    public static function SetImageFlag($aFlg = true)
    {
        self::$__iImgFlg = $aFlg;
    }

    public static function GetImageFlag()
    {
        return self::$__iImgFlg;
    }

    public static function SetLogFile($aFile)
    {
        self::$__iLogFile = $aFile;
    }

    public static function GetLogFile()
    {
        return self::$__iLogFile;
    }

    public static function SetTitle($aTitle)
    {
        self::$__iTitle = $aTitle;
    }

    public static function GetTitle()
    {
        return self::$__iTitle;
    }

    //
    // Setup PHP error handler
    //
    public static function phpErrorHandler(int $errno, string $errmsg, string $filename = '', int $errline = 0, array $errcontext = [])
    {
        // Respect current error level
        if ($errno & error_reporting()) {
            self::RaiseL(25003, basename($filename), $errline, $errmsg);
        }
    }

    public static function registerHandler()
    {
        self::$previous_handler = set_error_handler([__CLASS__, 'phpErrorHandler']);
    }
}
