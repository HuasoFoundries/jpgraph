<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;

/**
 * @class GanttScale
  *  Description: Responsible for calculating and showing
  *  the scale in a gantt chart. This includes providing methods for
  *  converting dates to position in the chart as well as stroking the
  *  date headers (days, week, etc).
 */
class GanttScale
{
    /**
     * @var HeaderProperty
     */
    public $minute;

    /**
     * @var HeaderProperty
     */
    public $hour;

    /**
     * @var HeaderProperty
     */
    public $day;

    /**
     * @var HeaderProperty
     */
    public $week;

    /**
     * @var HeaderProperty
     */
    public $month;

    /**
     * @var HeaderProperty
     */
    public $year;

    /**
     * @var LineProperty
     */
    public $divider;

    /**
     * @var LineProperty
     */
    public $dividerh;

    /**
     * @var Text\TextProperty
     */
    public $tableTitle;

    public $iStartDate = -1;

    public $iEndDate = -1;

    // Number of gantt bar position (n.b not necessariliy the same as the number of bars)
    // we could have on bar in position 1, and one bar in position 5 then there are two
    // bars but the number of bar positions is 5
    /**
     * @var GanttActivityInfo
     */
    public $actinfo;

    /**
     * @var int
     */
    public $iTopPlotMargin = 10;

    /**
     * @var int
     */
    public $iBottomPlotMargin = 15;

    /**
     * @var int
     */
    public $iVertLines = -1;

    public $iVertHeaderSize = -1;

    // The width of the labels (defaults to the widest of all labels)
    private $iLabelWidth;

    // Out image to stroke the scale to
    private $iImg;

    private $iTableHeaderBackgroundColor = 'white';

    /**
     * @var string
     */
    private $iTableHeaderFrameColor = 'black';

    /**
     * @var int
     */
    private $iTableHeaderFrameWeight = 1;

    private $iAvailableHeight = -1;

    private $iVertSpacing = -1;

    /**
     * @var Util\DateLocale
     */
    private $iDateLocale;

    private $iVertLayout = Configs::GANTT_EVEN;

    private $iUsePlotWeekendBackground = true;

    private $iWeekStart = 1; // Default to have weekends start on Monday

    /**
     * @param mixed $aImg
     */
    public function __construct($aImg)
    {
        $this->iImg = $aImg;
        $this->iDateLocale = new Util\DateLocale();

        $this->minute = new HeaderProperty();
        $this->minute->SetIntervall(15);
        $this->minute->SetLabelFormatString('i');
        $this->minute->SetFont(Configs::FF_FONT0);
        $this->minute->grid->SetColor('gray');

        $this->hour = new HeaderProperty();
        $this->hour->SetFont(Configs::FF_FONT0);
        $this->hour->SetIntervall(6);
        $this->hour->SetStyle(Configs::HOURSTYLE_HM24);
        $this->hour->SetLabelFormatString('H:i');
        $this->hour->grid->SetColor('gray');

        $this->day = new HeaderProperty();
        $this->day->grid->SetColor('gray');
        $this->day->SetLabelFormatString('l');

        $this->week = new HeaderProperty();
        $this->week->SetLabelFormatString('w%d');
        $this->week->SetFont(Configs::FF_FONT1);

        $this->month = new HeaderProperty();
        $this->month->SetFont(Configs::FF_FONT1, Configs::FS_BOLD);

        $this->year = new HeaderProperty();
        $this->year->SetFont(Configs::FF_FONT1, Configs::FS_BOLD);

        $this->divider = new LineProperty();
        $this->dividerh = new LineProperty();
        $this->dividerh->SetWeight(2);
        $this->divider->SetWeight(6);
        $this->divider->SetColor('gray');
        $this->divider->SetStyle('fancy');

        $this->tableTitle = new Text\TextProperty();
        $this->tableTitle->Show(false);
        $this->actinfo = new GanttActivityInfo();
    }

    /**
     * PUBLIC METHODS
     *  Specify what headers should be visible.
     *
     * @param mixed $aFlg
     *
     * @return void
     */
    public function ShowHeaders($aFlg)
    {
        $this->day->Show($aFlg & Configs::GANTT_HDAY);
        $this->week->Show($aFlg & Configs::GANTT_HWEEK);
        $this->month->Show($aFlg & Configs::GANTT_HMONTH);
        $this->year->Show($aFlg & Configs::GANTT_HYEAR);
        $this->hour->Show($aFlg & Configs::GANTT_HHOUR);
        $this->minute->Show($aFlg & Configs::GANTT_HMIN);

        // Make some default settings of gridlines whihc makes sense
        if ($aFlg & Configs::GANTT_HWEEK) {
            $this->month->grid->Show(false);
            $this->year->grid->Show(false);
        }

        if (!($aFlg & Configs::GANTT_HHOUR)) {
            return;
        }

        $this->day->grid->SetColor('black');
    }

    // Should the weekend background stretch all the way down in the plotarea
    /**
     * @return void
     */
    public function UseWeekendBackground($aShow)
    {
        $this->iUsePlotWeekendBackground = $aShow;
    }

    // Have a range been specified?
    /**
     * @return bool
     */
    public function IsRangeSet()
    {
        return -1 !== $this->iStartDate && -1 !== $this->iEndDate;
    }

    // Should the layout be from top or even?
    /**
     * @return void
     */
    public function SetVertLayout($aLayout)
    {
        $this->iVertLayout = $aLayout;
    }

    // Which locale should be used?
    /**
     * @return void
     */
    public function SetDateLocale($aLocale)
    {
        $this->iDateLocale->Set($aLocale);
    }

    // Number of days we are showing
    /**
     * @return float
     */
    public function GetNumberOfDays()
    {
        return \round(($this->iEndDate - $this->iStartDate) / Configs::SECPERDAY);
    }

    // The width of the actual plot area
    public function GetPlotWidth()
    {
        $img = $this->iImg;

        return $img->width - $img->left_margin - $img->right_margin;
    }

    // Specify the width of the titles(labels) for the activities
    // (This is by default set to the minimum width enought for the
    // widest title)
    /**
     * @return void
     */
    public function SetLabelWidth($aLabelWidth)
    {
        $this->iLabelWidth = $aLabelWidth;
    }

    // Which day should the week start?
    // 0==Sun, 1==Monday, 2==Tuesday etc
    /**
     * @return void
     */
    public function SetWeekStart($aStartDay)
    {
        $this->iWeekStart = $aStartDay % 7;

        //Recalculate the startday since this will change the week start
        $this->SetRange($this->iStartDate, $this->iEndDate);
    }

    // Do we show min scale?
    public function IsDisplayMinute()
    {
        return $this->minute->iShowLabels;
    }

    // Do we show day scale?
    public function IsDisplayHour()
    {
        return $this->hour->iShowLabels;
    }

    // Do we show day scale?
    public function IsDisplayDay()
    {
        return $this->day->iShowLabels;
    }

    // Do we show week scale?
    public function IsDisplayWeek()
    {
        return $this->week->iShowLabels;
    }

    // Do we show month scale?
    public function IsDisplayMonth()
    {
        return $this->month->iShowLabels;
    }

    // Do we show year scale?
    public function IsDisplayYear()
    {
        return $this->year->iShowLabels;
    }

    // Specify spacing (in percent of bar height) between activity bars
    /**
     * @return void
     */
    public function SetVertSpacing($aSpacing)
    {
        $this->iVertSpacing = $aSpacing;
    }

    // Specify scale min and max date either as timestamp or as date strings
    // Always round to the nearest week boundary
    /**
     * @return void
     */
    public function SetRange($aMin, $aMax)
    {
        $this->iStartDate = $this->NormalizeDate($aMin);
        $this->iEndDate = $this->NormalizeDate($aMax);
    }

    // Adjust the start and end date so they fit to beginning/ending
    // of the week taking the specified week start day into account.
    /**
     * @return void
     */
    public function AdjustStartEndDay()
    {
        if (!($this->IsDisplayYear() || $this->IsDisplayMonth() || $this->IsDisplayWeek())) {
            // Don't adjust
            return;
        }

        // Get day in week for start and ending date (Sun==0)
        $ds = \strftime('%w', $this->iStartDate);
        $de = \strftime('%w', $this->iEndDate);

        // We want to start on iWeekStart day. But first we subtract a week
        // if the startdate is "behind" the day the week start at.
        // This way we ensure that the given start date is always included
        // in the range. If we don't do this the nearest correct weekday in the week
        // to start at might be later than the start date.
        if ($ds < $this->iWeekStart) {
            $d = \strtotime('-7 day', $this->iStartDate);
        } else {
            $d = $this->iStartDate;
        }

        $adjdate = \strtotime(($this->iWeekStart - $ds) . ' day', $d/*$this->iStartDate*/);
        $this->iStartDate = $adjdate;

        // We want to end on the last day of the week
        $preferredEndDay = ($this->iWeekStart + 6) % 7;

        if ($preferredEndDay === $de) {
            return;
        }

        // Solve equivalence eq:    $de + x ~ $preferredDay (mod 7)
        $adj = (7 + ($preferredEndDay - $de)) % 7;
        $adjdate = \strtotime("+{$adj} day", $this->iEndDate);
        $this->iEndDate = $adjdate;
    }

    // Specify background for the table title area (upper left corner of the table)
    /**
     * @return void
     */
    public function SetTableTitleBackground($aColor)
    {
        $this->iTableHeaderBackgroundColor = $aColor;
    }

    ///////////////////////////////////////
    // PRIVATE Methods

    // Determine the height of all the scale headers combined
    public function GetHeaderHeight()
    {
        $img = $this->iImg;
        $height = 1;

        if ($this->minute->iShowLabels) {
            $height += $this->minute->GetFontHeight($img);
            $height += $this->minute->iTitleVertMargin;
        }

        if ($this->hour->iShowLabels) {
            $height += $this->hour->GetFontHeight($img);
            $height += $this->hour->iTitleVertMargin;
        }

        if ($this->day->iShowLabels) {
            $height += $this->day->GetFontHeight($img);
            $height += $this->day->iTitleVertMargin;
        }

        if ($this->week->iShowLabels) {
            $height += $this->week->GetFontHeight($img);
            $height += $this->week->iTitleVertMargin;
        }

        if ($this->month->iShowLabels) {
            $height += $this->month->GetFontHeight($img);
            $height += $this->month->iTitleVertMargin;
        }

        if ($this->year->iShowLabels) {
            $height += $this->year->GetFontHeight($img);
            $height += $this->year->iTitleVertMargin;
        }

        return $height;
    }

    // Get width (in pixels) for a single day
    public function GetDayWidth()
    {
        return ($this->GetPlotWidth() - $this->iLabelWidth + 1) / $this->GetNumberOfDays();
    }

    // Get width (in pixels) for a single hour
    public function GetHourWidth()
    {
        return $this->GetDayWidth() / 24;
    }

    public function GetMinuteWidth()
    {
        return $this->GetHourWidth() / 60;
    }

    // Nuber of days in a year
    /**
     * @return int
     *
     * @psalm-return 365|366
     */
    public function GetNumDaysInYear($aYear)
    {
        if ($this->IsLeap($aYear)) {
            return 366;
        }

        return 365;
    }

    // Get week number
    /**
     * @param false|int $aDate
     *
     * @return float|int
     */
    public function GetWeekNbr($aDate, $aSunStart = true)
    {
        // We can't use the internal strftime() since it gets the weeknumber
        // wrong since it doesn't follow ISO on all systems since this is
        // system linrary dependent.
        // Even worse is that this works differently if we are on a Windows
        // or UNIX box (it even differs between UNIX boxes how strftime()
        // is natively implemented)
        //
        // Credit to Nicolas Hoizey <nhoizey@phpheaven.net> for this elegant
        // version of Week Nbr calculation.

        $day = $this->NormalizeDate($aDate);

        if ($aSunStart) {
            $day += 60 * 60 * 24;
        }

        /**
         * According to ISO-8601 :
         * "Week 01 of a year is per definition the first week that has the Thursday in this year,
         * which is equivalent to the week that contains the fourth day of January.
         * In other words, the first week of a new year is the week that has the majority of its
         * days in the new year.".
         *
         * Be carefull, with PHP, -3 % 7 = -3, instead of 4 !!!
         *
         * day of year             = date("z", $day) + 1
         * offset to thursday      = 3 - (date("w", $day) + 6) % 7
         * first thursday of year  = 1 + (11 - date("w", mktime(0, 0, 0, 1, 1, date("Y", $day)))) % 7
         * week number             = (thursday's day of year - first thursday's day of year) / 7 + 1
         * ---------------------------------------------------------------------------*/
        $thursday = $day + 60 * 60 * 24 * (3 - (\date('w', $day) + 6) % 7); // take week's thursday

        return 1 + (\date('z', $thursday) - (11 - \date('w', \mktime(0, 0, 0, 1, 1, \date('Y', $thursday)))) % 7) / 7;
    }

    // Is year a leap year?
    /**
     * @param float|int $aYear
     *
     * @return bool
     */
    public function IsLeap($aYear)
    {
        // Is the year a leap year?
        //$year = 0+date("Y",$aDate);
        if ($aYear % 4 === 0) {
            if (!($aYear % 100 === 0) || ($aYear % 400 === 0)) {
                return true;
            }
        }

        return false;
    }

    // Get current year
    /**
     * @return float|int
     */
    public function GetYear($aDate)
    {
        return 0 + \date('Y', $aDate);
    }

    // Return number of days in a year
    /**
     * @param float|int $aYear
     *
     * @return int
     *
     * @psalm-return 28|29|30|31
     */
    public function GetNumDaysInMonth($aMonth, $aYear)
    {
        $days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $daysl = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        if ($this->IsLeap($aYear)) {
            return $daysl[$aMonth];
        }

        return $days[$aMonth];
    }

    // Get day in month
    /**
     * @return float|int
     */
    public function GetMonthDayNbr($aDate)
    {
        return 0 + \strftime('%d', $aDate);
    }

    // Get day in year
    /**
     * @return float|int
     */
    public function GetYearDayNbr($aDate)
    {
        return 0 + \strftime('%j', $aDate);
    }

    // Get month number
    /**
     * @return float|int
     */
    public function GetMonthNbr($aDate)
    {
        return 0 + \strftime('%m', $aDate);
    }

    // Translate a date to screen coordinates (horizontal scale)
    public function TranslateDate($aDate)
    {
        // In order to handle the problem with Daylight savings time
        // the scale written with equal number of seconds per day beginning
        // with the start date. This means that we "cement" the state of
        // DST as it is in the start date. If later the scale includes the
        // switchover date (depends on the locale) we need to adjust back
        // if the date we try to translate has a different DST status since
        // we would otherwise be off by one hour.
        $aDate = $this->NormalizeDate($aDate);
        $tmp = \localtime($aDate);
        $cloc = $tmp[8];
        $tmp = \localtime($this->iStartDate);
        $sloc = $tmp[8];
        $offset = 0;

        if ($sloc !== $cloc) {
            if ($sloc) {
                $offset = 3600;
            } else {
                $offset = -3600;
            }
        }
        $img = $this->iImg;

        return ($aDate - $this->iStartDate - $offset) / Configs::SECPERDAY * $this->GetDayWidth() + $img->left_margin + $this->iLabelWidth;
    }

    // Get screen coordinatesz for the vertical position for a bar
    public function TranslateVertPos($aPos, $atTop = false)
    {
        $img = $this->iImg;

        if ($aPos > $this->iVertLines) {
            Util\JpGraphError::RaiseL(6015, $aPos);
        }

        // 'Illegal vertical position %d'
        if (Configs::GANTT_EVEN === $this->iVertLayout) {
            // Position the top bar at 1 vert spacing from the scale
            $pos = \round($img->top_margin + $this->iVertHeaderSize + ($aPos + 1) * $this->iVertSpacing);
        } else {
            // position the top bar at 1/2 a vert spacing from the scale
            $pos = \round($img->top_margin + $this->iVertHeaderSize + $this->iTopPlotMargin + ($aPos + 1) * $this->iVertSpacing);
        }

        if ($atTop) {
            $pos -= $this->iVertSpacing;
        }

        return $pos;
    }

    // What is the vertical spacing?
    public function GetVertSpacing()
    {
        return $this->iVertSpacing;
    }

    // Convert a date to timestamp
    /**
     * @param false|int $aDate
     *
     * @return false|float|int|null
     */
    public function NormalizeDate($aDate)
    {
        if (false === $aDate) {
            return false;
        }

        if (\is_string($aDate)) {
            $t = \strtotime($aDate);

            if (false === $t || -1 === $t) {
                Util\JpGraphError::RaiseL(6016, $aDate);
                //("Date string ($aDate) specified for Gantt activity can not be interpretated. Please make sure it is a valid time string, e.g. 2005-04-23 13:30");
            }

            return $t;
        }

        if (\is_int($aDate) || \is_float($aDate)) {
            return $aDate;
        }
        Util\JpGraphError::RaiseL(6017, $aDate);

        //Unknown date format in GanttScale ($aDate).");
    }

    // Convert a time string to minutes

    public function TimeToMinutes($aTimeString)
    {
        // Split in hours and minutes
        $pos = \mb_strpos($aTimeString, ':');
        $minint = 60;

        if (false === $pos) {
            $hourint = $aTimeString;
            $minint = 0;
        } else {
            $hourint = \floor(\mb_substr($aTimeString, 0, $pos));
            $minint = \floor(\mb_substr($aTimeString, $pos + 1));
        }
        $minint += 60 * $hourint;

        return $minint;
    }

    // Stroke the day scale (including gridlines)
    /**
     * @param bool $getHeight
     */
    public function StrokeMinutes($aYCoord, $getHeight = false)
    {
        $img = $this->iImg;
        $xt = $img->left_margin + $this->iLabelWidth;
        $yt = $aYCoord + $img->top_margin;

        if ($this->minute->iShowLabels) {
            $img->SetFont($this->minute->iFFamily, $this->minute->iFStyle, $this->minute->iFSize);
            $yb = $yt + $img->GetFontHeight() +
            $this->minute->iTitleVertMargin + $this->minute->iFrameWeight;

            if ($getHeight) {
                return $yb - $img->top_margin;
            }
            $xb = $img->width - $img->right_margin + 1;
            $img->SetColor($this->minute->iBackgroundColor);
            $img->FilledRectangle($xt, $yt, $xb, $yb);

            $x = $xt;
            $img->SetTextAlign('center');
            $day = \date('w', $this->iStartDate);
            $minint = $this->minute->GetIntervall();

            if (60 % $minint !== 0) {
                Util\JpGraphError::RaiseL(6018, $minint);
                //'Intervall for minutes must divide the hour evenly, e.g. 1,5,10,12,15,20,30 etc You have specified an intervall of '.$minint.' minutes.');
            }

            $n = 60 / $minint;
            $datestamp = $this->iStartDate;
            $width = $this->GetHourWidth() / $n;

            if (8 > $width) {
                // TO small width to draw minute scale
                Util\JpGraphError::RaiseL(6019, $width);
                //('The available width ('.$width.') for minutes are to small for this scale to be displayed. Please use auto-sizing or increase the width of the graph.');
            }

            $nh = \ceil(24 * 60 / $this->TimeToMinutes($this->hour->GetIntervall()));
            $nd = $this->GetNumberOfDays();
            // Convert to intervall to seconds
            $minint *= 60;

            for ($j = 0; $j < $nd; ++$j, ++$day, $day %= 7) {
                for ($k = 0; $k < $nh; ++$k) {
                    for ($i = 0; $i < $n; ++$i, $x += $width, $datestamp += $minint) {
                        if (6 === $day || 0 === $day) {
                            $img->PushColor($this->day->iWeekendBackgroundColor);

                            if ($this->iUsePlotWeekendBackground) {
                                $img->FilledRectangle($x, $yt + $this->day->iFrameWeight, $x + $width, $img->height - $img->bottom_margin);
                            } else {
                                $img->FilledRectangle($x, $yt + $this->day->iFrameWeight, $x + $width, $yb - $this->day->iFrameWeight);
                            }

                            $img->PopColor();
                        }

                        if (0 === $day) {
                            $img->SetColor($this->day->iSundayTextColor);
                        } else {
                            $img->SetColor($this->day->iTextColor);
                        }

                        switch ($this->minute->iStyle) {
                            case Configs::MINUTESTYLE_CUSTOM:
                                $txt = \date($this->minute->iLabelFormStr, $datestamp);

                                break;
                            case Configs::MINUTESTYLE_MM:
                            default:
                                // 15
                                $txt = \date('i', $datestamp);

                                break;
                        }
                        $img->StrokeText(\round($x + $width / 2), \round($yb - $this->minute->iTitleVertMargin), $txt);

                        // Fix a rounding problem the wrong way ..
                        // If we also have hour scale then don't draw the firsta or last
                        // gridline since that will be overwritten by the hour scale gridline if such exists.
                        // However, due to the propagation of rounding of the 'x+=width' term in the loop
                        // this might sometimes be one pixel of so we fix this by not drawing it.
                        // The proper way to fix it would be to re-calculate the scale for each step and
                        // not using the additive term.
                        if (($i === $n || 0 === $i) && $this->hour->iShowLabels && $this->hour->grid->iShow) {
                            // Fix a rounding problem the wrong way ..
                            // If we also have hour scale then don't draw the firsta or last
                            // gridline since that will be overwritten by the hour scale gridline if such exists.
                            // However, due to the propagation of rounding of the 'x+=width' term in the loop
                            // this might sometimes be one pixel of so we fix this by not drawing it.
                            // The proper way to fix it would be to re-calculate the scale for each step and
                            // not using the additive term.
                            continue;
                            // Fix a rounding problem the wrong way ..
                            // If we also have hour scale then don't draw the firsta or last
                            // gridline since that will be overwritten by the hour scale gridline if such exists.
                            // However, due to the propagation of rounding of the 'x+=width' term in the loop
                            // this might sometimes be one pixel of so we fix this by not drawing it.
                            // The proper way to fix it would be to re-calculate the scale for each step and
                            // not using the additive term.
                        }

                        $img->SetColor($this->minute->grid->iColor);
                        $img->SetLineWeight($this->minute->grid->iWeight);
                        $img->Line($x, $yt, $x, $yb);
                        $this->minute->grid->Stroke($img, $x, $yb, $x, $img->height - $img->bottom_margin);
                    }
                }
            }
            $img->SetColor($this->minute->iFrameColor);
            $img->SetLineWeight($this->minute->iFrameWeight);
            $img->Rectangle($xt, $yt, $xb, $yb);

            return $yb - $img->top_margin;
        }

        return $aYCoord;
    }

    // Stroke the day scale (including gridlines)
    /**
     * @param bool $getHeight
     */
    public function StrokeHours($aYCoord, $getHeight = false)
    {
        $img = $this->iImg;
        $xt = $img->left_margin + $this->iLabelWidth;
        $yt = $aYCoord + $img->top_margin;

        if ($this->hour->iShowLabels) {
            $img->SetFont($this->hour->iFFamily, $this->hour->iFStyle, $this->hour->iFSize);
            $yb = $yt + $img->GetFontHeight() +
            $this->hour->iTitleVertMargin + $this->hour->iFrameWeight;

            if ($getHeight) {
                return $yb - $img->top_margin;
            }
            $xb = $img->width - $img->right_margin + 1;
            $img->SetColor($this->hour->iBackgroundColor);
            $img->FilledRectangle($xt, $yt, $xb, $yb);

            $x = $xt;
            $img->SetTextAlign('center');
            $tmp = $this->hour->GetIntervall();
            $minint = $this->TimeToMinutes($tmp);

            if (1440 % $minint !== 0) {
                Util\JpGraphError::RaiseL(6020, $tmp);
                //('Intervall for hours must divide the day evenly, e.g. 0:30, 1:00, 1:30, 4:00 etc. You have specified an intervall of '.$tmp);
            }

            $n = \ceil(24 * 60 / $minint);
            $datestamp = $this->iStartDate;
            $day = \date('w', $this->iStartDate);
            $doback = !$this->minute->iShowLabels;
            $width = $this->GetDayWidth() / $n;

            for ($j = 0; $this->GetNumberOfDays() > $j; ++$j, ++$day, $day %= 7) {
                for ($i = 0; $i < $n; ++$i, $x += $width) {
                    if (6 === $day || 0 === $day) {
                        $img->PushColor($this->day->iWeekendBackgroundColor);

                        if ($this->iUsePlotWeekendBackground && $doback) {
                            $img->FilledRectangle($x, $yt + $this->day->iFrameWeight, $x + $width, $img->height - $img->bottom_margin);
                        } else {
                            $img->FilledRectangle($x, $yt + $this->day->iFrameWeight, $x + $width, $yb - $this->day->iFrameWeight);
                        }

                        $img->PopColor();
                    }

                    if (0 === $day) {
                        $img->SetColor($this->day->iSundayTextColor);
                    } else {
                        $img->SetColor($this->day->iTextColor);
                    }

                    switch ($this->hour->iStyle) {
                        case Configs::HOURSTYLE_HMAMPM:
                            // 1:35pm
                            $txt = \date('g:ia', $datestamp);

                            break;
                        case Configs::HOURSTYLE_H24:
                            // 13
                            $txt = \date('H', $datestamp);

                            break;
                        case Configs::HOURSTYLE_HAMPM:
                            $txt = \date('ga', $datestamp);

                            break;
                        case Configs::HOURSTYLE_CUSTOM:
                            $txt = \date($this->hour->iLabelFormStr, $datestamp);

                            break;
                        case Configs::HOURSTYLE_HM24:
                        default:
                            $txt = \date('H:i', $datestamp);

                            break;
                    }
                    $img->StrokeText(\round($x + $width / 2), \round($yb - $this->hour->iTitleVertMargin), $txt);
                    $img->SetColor($this->hour->grid->iColor);
                    $img->SetLineWeight($this->hour->grid->iWeight);
                    $img->Line($x, $yt, $x, $yb);
                    $this->hour->grid->Stroke($img, $x, $yb, $x, $img->height - $img->bottom_margin);
                    //$datestamp += $minint*60
                    $datestamp = \mktime(
                        \date('H', $datestamp),
                        \date('i', $datestamp) + $minint,
                        0,
                        \date('m', $datestamp),
                        \date('d', $datestamp) + 1,
                        \date('Y', $datestamp)
                    );
                }
            }
            $img->SetColor($this->hour->iFrameColor);
            $img->SetLineWeight($this->hour->iFrameWeight);
            $img->Rectangle($xt, $yt, $xb, $yb);

            return $yb - $img->top_margin;
        }

        return $aYCoord;
    }

    // Stroke the day scale (including gridlines)
    /**
     * @param bool $getHeight
     */
    public function StrokeDays($aYCoord, $getHeight = false)
    {
        $img = $this->iImg;
        $daywidth = $this->GetDayWidth();
        $xt = $img->left_margin + $this->iLabelWidth;
        $yt = $aYCoord + $img->top_margin;

        if ($this->day->iShowLabels) {
            $img->SetFont($this->day->iFFamily, $this->day->iFStyle, $this->day->iFSize);
            $yb = $yt + $img->GetFontHeight() + $this->day->iTitleVertMargin + $this->day->iFrameWeight;

            if ($getHeight) {
                return $yb - $img->top_margin;
            }
            $xb = $img->width - $img->right_margin + 1;
            $img->SetColor($this->day->iBackgroundColor);
            $img->FilledRectangle($xt, $yt, $xb, $yb);

            $x = $xt;
            $img->SetTextAlign('center');
            $day = \date('w', $this->iStartDate);
            $datestamp = $this->iStartDate;

            $doback = !($this->hour->iShowLabels || $this->minute->iShowLabels);

            \setlocale(\LC_TIME, $this->iDateLocale->iLocale);

            for ($i = 0; $this->GetNumberOfDays() > $i; ++$i, $x += $daywidth, ++$day, $day %= 7) {
                if (6 === $day || 0 === $day) {
                    $img->SetColor($this->day->iWeekendBackgroundColor);

                    if ($this->iUsePlotWeekendBackground && $doback) {
                        $img->FilledRectangle(
                            $x,
                            $yt + $this->day->iFrameWeight,
                            $x + $daywidth,
                            $img->height - $img->bottom_margin
                        );
                    } else {
                        $img->FilledRectangle(
                            $x,
                            $yt + $this->day->iFrameWeight,
                            $x + $daywidth,
                            $yb - $this->day->iFrameWeight
                        );
                    }
                }

                $mn = \strftime('%m', $datestamp);

                if ('0' === $mn[0]) {
                    $mn = $mn[1];
                }

                switch ($this->day->iStyle) {
                    case Configs::DAYSTYLE_LONG:
                        // "Monday"
                        $txt = \strftime('%A', $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORT:
                        // "Mon"
                        $txt = \strftime('%a', $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORTDAYDATE1:
                        // "Mon 23/6"
                        $txt = \strftime('%a %d/' . $mn, $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORTDAYDATE2:
                        // "Mon 23 Jun"
                        $txt = \strftime('%a %d %b', $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORTDAYDATE3:
                        // "Mon 23 Jun 2003"
                        $txt = \strftime('%a %d %b %Y', $datestamp);

                        break;
                    case Configs::DAYSTYLE_LONGDAYDATE1:
                        // "Monday 23 Jun"
                        $txt = \strftime('%A %d %b', $datestamp);

                        break;
                    case Configs::DAYSTYLE_LONGDAYDATE2:
                        // "Monday 23 Jun 2003"
                        $txt = \strftime('%A %d %b %Y', $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORTDATE1:
                        // "23/6"
                        $txt = \strftime('%d/' . $mn, $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORTDATE2:
                        // "23 Jun"
                        $txt = \strftime('%d %b', $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORTDATE3:
                        // "Mon 23"
                        $txt = \strftime('%a %d', $datestamp);

                        break;
                    case Configs::DAYSTYLE_SHORTDATE4:
                        // "23"
                        $txt = \strftime('%d', $datestamp);

                        break;
                    case Configs::DAYSTYLE_CUSTOM:
                        // Custom format
                        $txt = \strftime($this->day->iLabelFormStr, $datestamp);

                        break;
                    case Configs::DAYSTYLE_ONELETTER:
                    default:
                        // "M"
                        $txt = \strftime('%A', $datestamp);
                        $txt = \mb_strtoupper($txt[0]);

                        break;
                }

                if (0 === $day) {
                    $img->SetColor($this->day->iSundayTextColor);
                } else {
                    $img->SetColor($this->day->iTextColor);
                }

                $img->StrokeText(
                    \round($x + $daywidth / 2 + 1),
                    \round($yb - $this->day->iTitleVertMargin),
                    $txt
                );
                $img->SetColor($this->day->grid->iColor);
                $img->SetLineWeight($this->day->grid->iWeight);
                $img->Line($x, $yt, $x, $yb);
                $this->day->grid->Stroke($img, $x, $yb, $x, $img->height - $img->bottom_margin);
                $datestamp = \mktime(0, 0, 0, \date('m', $datestamp), \date('d', $datestamp) + 1, \date('Y', $datestamp));
                //$datestamp += Configs::SECPERDAY;
            }
            $img->SetColor($this->day->iFrameColor);
            $img->SetLineWeight($this->day->iFrameWeight);
            $img->Rectangle($xt, $yt, $xb, $yb);

            return $yb - $img->top_margin;
        }

        return $aYCoord;
    }

    // Stroke week header and grid
    /**
     * @param bool $getHeight
     */
    public function StrokeWeeks($aYCoord, $getHeight = false)
    {
        if ($this->week->iShowLabels) {
            $img = $this->iImg;
            $yt = $aYCoord + $img->top_margin;
            $img->SetFont($this->week->iFFamily, $this->week->iFStyle, $this->week->iFSize);
            $yb = $yt + $img->GetFontHeight() + $this->week->iTitleVertMargin + $this->week->iFrameWeight;

            if ($getHeight) {
                return $yb - $img->top_margin;
            }

            $xt = $img->left_margin + $this->iLabelWidth;
            $weekwidth = $this->GetDayWidth() * 7;
            $wdays = $this->iDateLocale->GetDayAbb();
            $xb = $img->width - $img->right_margin + 1;
            $week = $this->iStartDate;
            $weeknbr = $this->GetWeekNbr($week);
            $img->SetColor($this->week->iBackgroundColor);
            $img->FilledRectangle($xt, $yt, $xb, $yb);
            $img->SetColor($this->week->grid->iColor);
            $x = $xt;

            if (Configs::WEEKSTYLE_WNBR === $this->week->iStyle) {
                $img->SetTextAlign('center');
                $txtOffset = $weekwidth / 2 + 1;
            } elseif (Configs::WEEKSTYLE_FIRSTDAY === $this->week->iStyle
                || Configs::WEEKSTYLE_FIRSTDAY2 === $this->week->iStyle
                || Configs::WEEKSTYLE_FIRSTDAYWNBR === $this->week->iStyle
                || Configs::WEEKSTYLE_FIRSTDAY2WNBR === $this->week->iStyle) {
                $img->SetTextAlign('left');
                $txtOffset = 3;
            } else {
                Util\JpGraphError::RaiseL(6021);
                //("Unknown formatting style for week.");
            }

            for ($i = 0; $this->GetNumberOfDays() / 7 > $i; ++$i, $x += $weekwidth) {
                $img->PushColor($this->week->iTextColor);

                if (Configs::WEEKSTYLE_WNBR === $this->week->iStyle) {
                    $txt = \sprintf($this->week->iLabelFormStr, $weeknbr);
                } elseif (Configs::WEEKSTYLE_FIRSTDAY === $this->week->iStyle
                    || Configs::WEEKSTYLE_FIRSTDAYWNBR === $this->week->iStyle) {
                    $txt = \date('j/n', $week);
                } elseif (Configs::WEEKSTYLE_FIRSTDAY2 === $this->week->iStyle
                    || Configs::WEEKSTYLE_FIRSTDAY2WNBR === $this->week->iStyle) {
                    $monthnbr = \date('n', $week) - 1;
                    $shortmonth = $this->iDateLocale->GetShortMonthName($monthnbr);
                    $txt = \date('j', $week) . ' ' . $shortmonth;
                }

                if (Configs::WEEKSTYLE_FIRSTDAYWNBR === $this->week->iStyle
                    || Configs::WEEKSTYLE_FIRSTDAY2WNBR === $this->week->iStyle) {
                    $w = \sprintf($this->week->iLabelFormStr, $weeknbr);
                    $txt .= ' ' . $w;
                }

                $img->StrokeText(
                    \round($x + $txtOffset),
                    \round($yb - $this->week->iTitleVertMargin),
                    $txt
                );

                $week = \strtotime('+7 day', $week);
                $weeknbr = $this->GetWeekNbr($week);
                $img->PopColor();
                $img->SetLineWeight($this->week->grid->iWeight);
                $img->Line($x, $yt, $x, $yb);
                $this->week->grid->Stroke($img, $x, $yb, $x, $img->height - $img->bottom_margin);
            }
            $img->SetColor($this->week->iFrameColor);
            $img->SetLineWeight($this->week->iFrameWeight);
            $img->Rectangle($xt, $yt, $xb, $yb);

            return $yb - $img->top_margin;
        }

        return $aYCoord;
    }

    // Format the mont scale header string
    /**
     * @param float|int $year
     */
    public function GetMonthLabel($aMonthNbr, $year)
    {
        $sn = $this->iDateLocale->GetShortMonthName($aMonthNbr);
        $ln = $this->iDateLocale->GetLongMonthName($aMonthNbr);

        switch ($this->month->iStyle) {
            case Configs::getConfig('MONTHSTYLE_SHORTNAME'):
                $m = $sn;

                break;
            case Configs::getConfig('MONTHSTYLE_LONGNAME'):
                $m = $ln;

                break;
            case Configs::getConfig('MONTHSTYLE_SHORTNAMEYEAR2'):
                $m = $sn . " '" . \mb_substr('' . $year, 2);

                break;
            case Configs::getConfig('MONTHSTYLE_SHORTNAMEYEAR4'):
                $m = $sn . ' ' . $year;

                break;
            case Configs::getConfig('MONTHSTYLE_LONGNAMEYEAR2'):
                $m = $ln . " '" . \mb_substr('' . $year, 2);

                break;
            case Configs::getConfig('MONTHSTYLE_LONGNAMEYEAR4'):
                $m = $ln . ' ' . $year;

                break;
            case Configs::getConfig('MONTHSTYLE_FIRSTLETTER'):
                $m = $sn[0];

                break;
        }

        return $m;
    }

    // Stroke month scale and gridlines
    /**
     * @param bool $getHeight
     */
    public function StrokeMonths($aYCoord, $getHeight = false)
    {
        if ($this->month->iShowLabels) {
            $img = $this->iImg;
            $img->SetFont($this->month->iFFamily, $this->month->iFStyle, $this->month->iFSize);
            $yt = $aYCoord + $img->top_margin;
            $yb = $yt + $img->GetFontHeight() + $this->month->iTitleVertMargin + $this->month->iFrameWeight;

            if ($getHeight) {
                return $yb - $img->top_margin;
            }
            $monthnbr = $this->GetMonthNbr($this->iStartDate) - 1;
            $xt = $img->left_margin + $this->iLabelWidth;
            $xb = $img->width - $img->right_margin + 1;

            $img->SetColor($this->month->iBackgroundColor);
            $img->FilledRectangle($xt, $yt, $xb, $yb);

            $img->SetLineWeight($this->month->grid->iWeight);
            $img->SetColor($this->month->iTextColor);
            $year = 0 + \strftime('%Y', $this->iStartDate);
            $img->SetTextAlign('center');

            if ($this->GetMonthNbr($this->iStartDate) === $this->GetMonthNbr($this->iEndDate)
                && $this->GetYear($this->iStartDate) === $this->GetYear($this->iEndDate)) {
                $monthwidth = $this->GetDayWidth() * ($this->GetMonthDayNbr($this->iEndDate) - $this->GetMonthDayNbr($this->iStartDate) + 1);
            } else {
                $monthwidth = $this->GetDayWidth() * ($this->GetNumDaysInMonth($monthnbr, $year) - $this->GetMonthDayNbr($this->iStartDate) + 1);
            }
            // Is it enough space to stroke the first month?
            $monthName = $this->GetMonthLabel($monthnbr, $year);

            if (1.2 * $img->GetTextWidth($monthName) <= $monthwidth) {
                $img->SetColor($this->month->iTextColor);
                $img->StrokeText(
                    \round($xt + $monthwidth / 2 + 1),
                    \round($yb - $this->month->iTitleVertMargin),
                    $monthName
                );
            }
            $x = $xt + $monthwidth;

            while ($x < $xb) {
                $img->SetColor($this->month->grid->iColor);
                $img->Line($x, $yt, $x, $yb);
                $this->month->grid->Stroke($img, $x, $yb, $x, $img->height - $img->bottom_margin);
                ++$monthnbr;

                if (12 === $monthnbr) {
                    $monthnbr = 0;
                    ++$year;
                }
                $monthName = $this->GetMonthLabel($monthnbr, $year);
                $monthwidth = $this->GetDayWidth() * $this->GetNumDaysInMonth($monthnbr, $year);

                if ($x + $monthwidth < $xb) {
                    $w = $monthwidth;
                } else {
                    $w = $xb - $x;
                }

                if (1.2 * $img->GetTextWidth($monthName) <= $w) {
                    $img->SetColor($this->month->iTextColor);
                    $img->StrokeText(
                        \round($x + $w / 2 + 1),
                        \round($yb - $this->month->iTitleVertMargin),
                        $monthName
                    );
                }
                $x += $monthwidth;
            }
            $img->SetColor($this->month->iFrameColor);
            $img->SetLineWeight($this->month->iFrameWeight);
            $img->Rectangle($xt, $yt, $xb, $yb);

            return $yb - $img->top_margin;
        }

        return $aYCoord;
    }

    // Stroke year scale and gridlines
    /**
     * @param int $aYCoord
     * @param bool $getHeight
     */
    public function StrokeYears($aYCoord, $getHeight = false)
    {
        if ($this->year->iShowLabels) {
            $img = $this->iImg;
            $yt = $aYCoord + $img->top_margin;
            $img->SetFont($this->year->iFFamily, $this->year->iFStyle, $this->year->iFSize);
            $yb = $yt + $img->GetFontHeight() + $this->year->iTitleVertMargin + $this->year->iFrameWeight;

            if ($getHeight) {
                return $yb - $img->top_margin;
            }

            $xb = $img->width - $img->right_margin + 1;
            $xt = $img->left_margin + $this->iLabelWidth;
            $year = $this->GetYear($this->iStartDate);
            $img->SetColor($this->year->iBackgroundColor);
            $img->FilledRectangle($xt, $yt, $xb, $yb);
            $img->SetLineWeight($this->year->grid->iWeight);
            $img->SetTextAlign('center');

            if ($this->GetYear($this->iEndDate) === $year) {
                $yearwidth = $this->GetDayWidth() * ($this->GetYearDayNbr($this->iEndDate) - $this->GetYearDayNbr($this->iStartDate) + 1);
            } else {
                $yearwidth = $this->GetDayWidth() * ($this->GetNumDaysInYear($year) - $this->GetYearDayNbr($this->iStartDate) + 1);
            }

            // The space for a year must be at least 20% bigger than the actual text
            // so we allow 10% margin on each side
            if (1.20 * $img->GetTextWidth('' . $year) <= $yearwidth) {
                $img->SetColor($this->year->iTextColor);
                $img->StrokeText(
                    \round($xt + $yearwidth / 2 + 1),
                    \round($yb - $this->year->iTitleVertMargin),
                    $year
                );
            }
            $x = $xt + $yearwidth;

            while ($x < $xb) {
                $img->SetColor($this->year->grid->iColor);
                $img->Line($x, $yt, $x, $yb);
                $this->year->grid->Stroke($img, $x, $yb, $x, $img->height - $img->bottom_margin);
                ++$year;
                $yearwidth = $this->GetDayWidth() * $this->GetNumDaysInYear($year);

                if ($x + $yearwidth < $xb) {
                    $w = $yearwidth;
                } else {
                    $w = $xb - $x;
                }

                if (1.2 * $img->GetTextWidth('' . $year) <= $w) {
                    $img->SetColor($this->year->iTextColor);
                    $img->StrokeText(
                        \round($x + $w / 2 + 1),
                        \round($yb - $this->year->iTitleVertMargin),
                        $year
                    );
                }
                $x += $yearwidth;
            }
            $img->SetColor($this->year->iFrameColor);
            $img->SetLineWeight($this->year->iFrameWeight);
            $img->Rectangle($xt, $yt, $xb, $yb);

            return $yb - $img->top_margin;
        }

        return $aYCoord;
    }

    // Stroke table title (upper left corner)
    /**
     * @return void
     */
    public function StrokeTableHeaders($aYBottom)
    {
        $img = $this->iImg;
        $xt = $img->left_margin;
        $yt = $img->top_margin;
        $xb = $xt + $this->iLabelWidth;
        $yb = $aYBottom + $img->top_margin;

        if ($this->tableTitle->iShow) {
            $img->SetColor($this->iTableHeaderBackgroundColor);
            $img->FilledRectangle($xt, $yt, $xb, $yb);
            $this->tableTitle->Align('center', 'top');
            $this->tableTitle->Stroke($img, $xt + ($xb - $xt) / 2 + 1, $yt + 2);
            $img->SetColor($this->iTableHeaderFrameColor);
            $img->SetLineWeight($this->iTableHeaderFrameWeight);
            $img->Rectangle($xt, $yt, $xb, $yb);
        }

        $this->actinfo->Stroke($img, $xt, $yt, $xb, $yb, $this->tableTitle->iShow);

        // Draw the horizontal dividing line
        $this->dividerh->Stroke($img, $xt, $yb, $img->width - $img->right_margin, $yb);

        // Draw the vertical dividing line
        // We do the width "manually" since we want the line only to grow
        // to the left
        $fancy = 'fancy' === $this->divider->iStyle;

        if ($fancy) {
            $this->divider->iStyle = 'solid';
        }

        $tmp = $this->divider->iWeight;
        $this->divider->iWeight = 1;
        $y = $img->height - $img->bottom_margin;

        for ($i = 0; $i < $tmp; ++$i) {
            $this->divider->Stroke($img, $xb - $i, $yt, $xb - $i, $y);
        }

        // Should we draw "fancy" divider
        if (!$fancy) {
            // Should we draw "fancy" divider
            return;
            // Should we draw "fancy" divider
        }

        $img->SetLineWeight(1);
        $img->SetColor($this->iTableHeaderFrameColor);
        $img->Line($xb, $yt, $xb, $y);
        $img->Line($xb - $tmp + 1, $yt, $xb - $tmp + 1, $y);
        $img->SetColor('white');
        $img->Line($xb - $tmp + 2, $yt, $xb - $tmp + 2, $y);
    }

    // Main entry point to stroke scale
    /**
     * @return void
     */
    public function Stroke()
    {
        if (!$this->IsRangeSet()) {
            Util\JpGraphError::RaiseL(6022);
            //("Gantt scale has not been specified.");
        }
        $img = $this->iImg;

        // If minutes are displayed then hour interval must be 1
        if ($this->IsDisplayMinute() && $this->hour->GetIntervall() > 1) {
            Util\JpGraphError::RaiseL(6023);
            //('If you display both hour and minutes the hour intervall must be 1 (Otherwise it doesn\' make sense to display minutes).');
        }

        // Stroke all headers. As argument we supply the offset from the
        // top which depends on any previous headers

        // First find out the height of each header
        $offy = $this->StrokeYears(0, true);
        $offm = $this->StrokeMonths($offy, true);
        $offw = $this->StrokeWeeks($offm, true);
        $offd = $this->StrokeDays($offw, true);
        $offh = $this->StrokeHours($offd, true);
        $offmin = $this->StrokeMinutes($offh, true);

        // ... then we can stroke them in the "backwards order to ensure that
        // the larger scale gridlines is stroked over the smaller scale gridline
        $this->StrokeMinutes($offh);
        $this->StrokeHours($offd);
        $this->StrokeDays($offw);
        $this->StrokeWeeks($offm);
        $this->StrokeMonths($offy);
        $this->StrokeYears(0);

        // Now when we now the oaverall size of the scale headers
        // we can stroke the overall table headers
        $this->StrokeTableHeaders($offmin);

        // Now we can calculate the correct scaling factor for each vertical position
        $this->iAvailableHeight = $img->height - $img->top_margin - $img->bottom_margin - $offd;

        $this->iVertHeaderSize = $offmin;

        if (-1 !== $this->iVertSpacing) {
            return;
        }

        $this->iVertSpacing = $this->iAvailableHeight / $this->iVertLines;
    }
}
