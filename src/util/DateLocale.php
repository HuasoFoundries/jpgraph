<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Util;

use function array_keys;
use function explode;
use function in_array;
use function is_array;
use const LC_TIME;
use function setlocale;
use function settype;
use function strftime;
use function strtotime;
use function strtoupper;
use function ucfirst;

/**
 * @class DateLocale
 * // Description: Hold localized text used in dates
 */
class DateLocale
{
    public $iLocale = 'C'; // environmental locale be used by default
    private $iDayAbb;
    private $iShortDay;
    private $iShortMonth;
    private $iMonthName;

    public function __construct()
    {
        settype($this->iDayAbb, 'array');
        settype($this->iShortDay, 'array');
        settype($this->iShortMonth, 'array');
        settype($this->iMonthName, 'array');
        $this->Set('C');
    }

    public function Set($aLocale)
    {
        if (in_array($aLocale, array_keys($this->iDayAbb), true)) {
            $this->iLocale = $aLocale;

            return true; // already cached nothing else to do!
        }

        $pLocale = setlocale(LC_TIME, 0); // get current locale for LC_TIME

        if (is_array($aLocale)) {
            foreach ($aLocale as $loc) {
                $res = @setlocale(LC_TIME, $loc);
                if ($res) {
                    $aLocale = $loc;

                    break;
                }
            }
        } else {
            $res = @setlocale(LC_TIME, $aLocale);
        }

        if (!$res) {
            JpGraphError::RaiseL(25007, $aLocale);
            //("You are trying to use the locale ($aLocale) which your PHP installation does not support. Hint: Use '' to indicate the default locale for this geographic region.");
            return false;
        }

        $this->iLocale = $aLocale;
        for ($i = 0, $ofs = 0 - strftime('%w'); $i < 7; $i++, $ofs++) {
            $day                         = strftime('%a', strtotime("${ofs} day"));
            $day[0]                      = strtoupper($day[0]);
            $this->iDayAbb[$aLocale][]   = $day[0];
            $this->iShortDay[$aLocale][] = $day;
        }

        for ($i = 1; $i <= 12; ++$i) {
            list($short, $full)                = explode('|', strftime('%b|%B', strtotime("2001-${i}-01")));
            $this->iShortMonth[$aLocale][]     = ucfirst($short);
            $this->iMonthName[$aLocale][]      = ucfirst($full);
        }

        setlocale(LC_TIME, $pLocale);

        return true;
    }

    public function GetDayAbb()
    {
        return $this->iDayAbb[$this->iLocale];
    }

    public function GetShortDay()
    {
        return $this->iShortDay[$this->iLocale];
    }

    public function GetShortMonth()
    {
        return $this->iShortMonth[$this->iLocale];
    }

    public function GetShortMonthName($aNbr)
    {
        return $this->iShortMonth[$this->iLocale][$aNbr];
    }

    public function GetLongMonthName($aNbr)
    {
        return $this->iMonthName[$this->iLocale][$aNbr];
    }

    public function GetMonth()
    {
        return $this->iMonthName[$this->iLocale];
    }
}
