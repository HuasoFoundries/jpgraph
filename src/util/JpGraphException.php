<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Util;

use Amenadiel\JpGraph\Image;
use Amenadiel\JpGraph\Text;
use Exception;
use Throwable;

class JpGraphException extends Exception
{
    public static $previous_exception_handler;

    private $iDest; // 'php://stderr';

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }

    // custom string representation of object
    public function _toString()
    {
        return \sprintf(
            '[%s : %s]: %s ' . \PHP_EOL . // class and error code, plus error message
                ' %s  %s' . \PHP_EOL . // filename and line number
                '%s ' . \PHP_EOL, // Trace
            __CLASS__,
            $this->code,
            $this->message,
            $this->getFile(),
            $this->getLine(),
            $this->getTraceAsString()
        );
    }

    /**
     * custom representation of error as an image.
     */
    public function Stroke()
    {
        //$sent_headers = headers_list();
        kdump($this->_toString());

        if (JpGraphError::GetImageFlag()) {
            $this->handleImgException();
        } else {
            $this->handleTextException();
        }
    }

    public static function defaultHandler(Throwable $exception)
    {
        if (!($exception instanceof self)) {
            // Restore old handler
            if (null !== self::$previous_exception_handler) {
                \set_exception_handler(self::$previous_exception_handler);
            }

            throw $exception;
        }

        $exception->Stroke();
    }
    private   $__iTitle = 'JpGraph Error: ';

    /**
     * Register exception handler for JpGraphException.
     */
    public static function registerHandler()
    {
        self::$previous_exception_handler = \set_exception_handler([__CLASS__, 'defaultHandler']);
    }

    // If aHalt is true then execution can't continue. Typical used for fatal errors
    public function handleTextException($aHalt = HALT_ON_ERRORS)
    {
        $logDestination = JpGraphError::GetLogFile();
        $aMsg = JpGraphError::GetTitle() . $this->getMessage();

        if (!$logDestination) {
            // Check SAPI and if we are called from the command line
            // send the error to STDERR instead
            if (\PHP_SAPI === 'cli' || \PHP_SAPI === 'cli-server') {
                \fwrite(\STDOUT, $aMsg);
            }
            \error_log($aMsg);

            if (\ini_get('display_errors')) {
                echo $aMsg;
            }
        } elseif ('syslog' === $this->iDest) {
            \error_log($this->__iTitle . $aMsg);
        } else {
            $str = '[' . \date('r') . '] ' . $this->__iTitle . ', ' . $aMsg . "\n";
            $f = \fopen($this->iDest, 'ab');

            if ($f) {
                \fwrite($f, $str);
                \fclose($f);
            }
        }

        if ($aHalt) {
            exit(1);
        }
    }

    public function handleImgException($aHalt = HALT_ON_ERRORS)
    {
        $img_iconerror =
            'iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAAaV' .
            'BMVEX//////2Xy8mLl5V/Z2VvMzFi/v1WyslKlpU+ZmUyMjEh/' .
            'f0VyckJlZT9YWDxMTDjAwMDy8sLl5bnY2K/MzKW/v5yyspKlpY' .
            'iYmH+MjHY/PzV/f2xycmJlZVlZWU9MTEXY2Ms/PzwyMjLFTjea' .
            'AAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACx' .
            'IAAAsSAdLdfvwAAAAHdElNRQfTBgISOCqusfs5AAABLUlEQVR4' .
            '2tWV3XKCMBBGWfkranCIVClKLd/7P2Q3QsgCxjDTq+6FE2cPH+' .
            'xJ0Ogn2lQbsT+Wrs+buAZAV4W5T6Bs0YXBBwpKgEuIu+JERAX6' .
            'wM2rHjmDdEITmsQEEmWADgZm6rAjhXsoMGY9B/NZBwJzBvn+e3' .
            'wHntCAJdGu9SviwIwoZVDxPB9+Rc0TSEbQr0j3SA1gwdSn6Db0' .
            '6Tm1KfV6yzWGQO7zdpvyKLKBDmRFjzeB3LYgK7r6A/noDAfjtS' .
            'IXaIzbJSv6WgUebTMV4EoRB8a2mQiQjgtF91HdKDKZ1gtFtQjk' .
            'YcWaR5OKOhkYt+ZsTFdJRfPAApOpQYJTNHvCRSJR6SJngQadfc' .
            'vd69OLMddVOPCGVnmrFD8bVYd3JXfxXPtLR/+mtv59/ALWiiMx' .
            'qL72fwAAAABJRU5ErkJggg==';

        if (\function_exists('imagetypes')) {
            $supported = \imagetypes();
        } else {
            $supported = 0;
        }

        if (!\function_exists('imagecreatefromstring')) {
            $supported = 0;
        }

        if (\ob_get_length() || \headers_sent() || !($supported & \IMG_PNG)) {
            // Special case for headers already sent or that the installation doesn't support
            // the PNG format (which the error icon is encoded in).
            // Dont return an image since it can't be displayed
            exit($this->__iTitle . ' ' . $this->getMessage());
        }

        $aMsg = \wordwrap($this->getMessage(), 55);
        $lines = \mb_substr_count($this->getMessage(), "\n");

        // Create the error icon GD
        $erricon = Image\Image::CreateFromString(\base64_decode($img_iconerror, true));

        // Create an image that contains the error text.
        $w = 400;
        $h = 100 + 15 * \max(0, $lines - 3);

        $img = new Image\Image($w, $h);

        // Drop shadow
        $img->SetColor('gray');
        $img->FilledRectangle(5, 5, $w - 1, $h - 1, 10);
        $img->SetColor('gray:0.7');
        $img->FilledRectangle(5, 5, $w - 3, $h - 3, 10);

        // Window background
        $img->SetColor('lightblue');
        $img->FilledRectangle(1, 1, $w - 5, $h - 5);
        $img->CopyCanvasH($img->img, $erricon, 5, 30, 0, 0, 40, 40);

        // Window border
        $img->SetColor('black');
        $img->Rectangle(1, 1, $w - 5, $h - 5);
        $img->Rectangle(0, 0, $w - 4, $h - 4);

        // Window top row
        $img->SetColor('darkred');

        for ($y = 3; 18 > $y; $y += 2) {
            $img->Line(1, $y, $w - 6, $y);
        }

        // "White shadow"
        $img->SetColor('white');

        // Left window edge
        $img->Line(2, 2, 2, $h - 5);
        $img->Line(2, 2, $w - 6, 2);

        // "Gray button shadow"
        $img->SetColor('darkgray');

        // Gray window shadow
        $img->Line(2, $h - 6, $w - 5, $h - 6);
        $img->Line(3, $h - 7, $w - 5, $h - 7);

        // Window title
        $m = \floor($w / 2 - 5);
        $l = 110;
        $img->SetColor('lightgray:1.3');
        $img->FilledRectangle($m - $l, 2, $m + $l, 16);

        // Stroke text
        $img->SetColor('darkred');
        $img->SetFont(
            Configs::FF_FONT2,
            Configs::FS_BOLD
        );
        $img->StrokeText($m - 90, 15, JpGraphError::GetTitle());
        $img->SetColor('black');
        $img->SetFont(
            Configs::FF_FONT1,
            Configs::FS_NORMAL
        );
        $txt = new Text\Text($this->getMessage(), 52, 25);
        $txt->SetFont(
            Configs::FF_FONT1
        );
        $txt->Align('left', 'top');
        $txt->Stroke($img);

        if ($this->iDest) {
            $img->Stream($this->iDest);
        } else {
            $img->Headers();
            $img->Stream();
        }

        if ($aHalt) {
            exit;
        }
    }
}
