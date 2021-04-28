<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;

/**
 * @class DateScaleUtils
  *  Description: Help to create a manual date scale
 */
class DateScaleUtils
{
    public static $iMin = 0;

    public static $iMax = 0;

    /**
     * @var null|numeric-string
     */
    private static $starthour;

    /**
     * @var null|numeric-string
     */
    private static $startmonth;

    /**
     * @var null|numeric-string
     */
    private static $startday;

    /**
     * @var null|numeric-string
     */
    private static $startyear;

    /**
     * @var null|numeric-string
     */
    private static $endmonth;

    /**
     * @var null|numeric-string
     */
    private static $endyear;

    /**
     * @var null|numeric-string
     */
    private static $endday;

    private static $tickPositions = [];

    private static $minTickPositions = [];

    private static $iUseWeeks = true;

    /**
     * @return void
     */
    public static function UseWeekFormat($aFlg)
    {
        self::$iUseWeeks = $aFlg;
    }

    /**
     * @param int|string $aType
     *
     * @return void
     */
    public static function doYearly($aType, $aMinor = false)
    {
        $i = 0;
        $j = 0;
        $m = self::$startmonth;
        $y = self::$startyear;

        if (1 === self::$startday) {
            self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, 1, $y);
        }
        ++$m;

        switch ($aType) {
            case Configs::DSUTILS_YEAR1:
                for ($y = self::$startyear; $y <= self::$endyear; ++$y) {
                    if ($aMinor) {
                        while (12 >= $m) {
                            if (!($y === self::$endyear && $m > self::$endmonth)) {
                                self::$minTickPositions[$j++] = \mktime(0, 0, 0, $m, 1, $y);
                            }
                            ++$m;
                        }
                        $m = 1;
                    }
                    self::$tickPositions[$i++] = \mktime(0, 0, 0, 1, 1, $y);
                }

                break;
            case Configs::DSUTILS_YEAR2:
                $y = self::$startyear;

                while ($y <= self::$endyear) {
                    self::$tickPositions[$i++] = \mktime(0, 0, 0, 1, 1, $y);

                    for ($k = 0; 1 > $k; ++$k) {
                        ++$y;

                        if (!$aMinor) {
                            continue;
                        }

                        self::$minTickPositions[$j++] = \mktime(0, 0, 0, 1, 1, $y);
                    }
                    ++$y;
                }

                break;
            case Configs::DSUTILS_YEAR5:
                $y = self::$startyear;

                while ($y <= self::$endyear) {
                    self::$tickPositions[$i++] = \mktime(0, 0, 0, 1, 1, $y);

                    for ($k = 0; 4 > $k; ++$k) {
                        ++$y;

                        if (!$aMinor) {
                            continue;
                        }

                        self::$minTickPositions[$j++] = \mktime(0, 0, 0, 1, 1, $y);
                    }
                    ++$y;
                }

                break;
        }
    }

    /**
     * @param int|string $aType
     *
     * @return void
     */
    public static function doDaily($aType, $aMinor = false)
    {
        $m = self::$startmonth;
        $y = self::$startyear;
        $d = self::$startday;
        $h = self::$starthour;
        $i = 0;
        $j = 0;

        if (0 === $h) {
            self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, $d, $y);
        }
        $t = \mktime(0, 0, 0, $m, $d, $y);

        switch ($aType) {
            case Configs::DSUTILS_DAY1:
                while ($t <= self::$iMax) {
                    $t = \strtotime('+1 day', $t);
                    self::$tickPositions[$i++] = $t;

                    if (!$aMinor) {
                        continue;
                    }

                    self::$minTickPositions[$j++] = \strtotime('+12 hours', $t);
                }

                break;
            case Configs::DSUTILS_DAY2:
                while ($t <= self::$iMax) {
                    $t = \strtotime('+1 day', $t);

                    if ($aMinor) {
                        self::$minTickPositions[$j++] = $t;
                    }
                    $t = \strtotime('+1 day', $t);
                    self::$tickPositions[$i++] = $t;
                }

                break;
            case Configs::DSUTILS_DAY4:
                while ($t <= self::$iMax) {
                    for ($k = 0; 3 > $k; ++$k) {
                        $t = \strtotime('+1 day', $t);

                        if (!$aMinor) {
                            continue;
                        }

                        self::$minTickPositions[$j++] = $t;
                    }
                    $t = \strtotime('+1 day', $t);
                    self::$tickPositions[$i++] = $t;
                }

                break;
        }
    }

    /**
     * @param int|string $aType
     *
     * @return void
     */
    public static function doWeekly($aType, $aMinor = false)
    {
        $hpd = 3600 * 24;
        $hpw = 3600 * 24 * 7;
        // Find out week number of min date
        $thursday = self::$iMin + $hpd * (3 - (\date('w', self::$iMin) + 6) % 7);
        $week = 1 + (\date('z', $thursday) - (11 - \date('w', \mktime(0, 0, 0, 1, 1, \date('Y', $thursday)))) % 7) / 7;
        $daynumber = \date('w', self::$iMin);

        if (0 === $daynumber) {
            $daynumber = 7;
        }

        $m = self::$startmonth;
        $y = self::$startyear;
        $d = self::$startday;
        $i = 0;
        $j = 0;
        // The assumption is that the weeks start on Monday. If the first day
        // is later in the week then the first week tick has to be on the following
        // week.
        if (1 === $daynumber) {
            self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, $d, $y);
            $t = \mktime(0, 0, 0, $m, $d, $y) + $hpw;
        } else {
            $t = \mktime(0, 0, 0, $m, $d, $y) + $hpd * (8 - $daynumber);
        }

        switch ($aType) {
            case Configs::DSUTILS_WEEK1:
                $cnt = 0;

                break;
            case Configs::DSUTILS_WEEK2:
                $cnt = 1;

                break;
            case Configs::DSUTILS_WEEK4:
                $cnt = 3;

                break;
        }

        while ($t <= self::$iMax) {
            self::$tickPositions[$i++] = $t;

            for ($k = 0; $k < $cnt; ++$k) {
                $t += $hpw;

                if (!$aMinor) {
                    continue;
                }

                self::$minTickPositions[$j++] = $t;
            }
            $t += $hpw;
        }
    }

    /**
     * @param int|string $aType
     *
     * @return ((false|int)[]|mixed)[]
     *
     * @psalm-return array{0: array<positive-int, false|int>|mixed, 1: array<positive-int, false|int>|mixed}
     */
    public static function doMonthly($aType, $aMinor = false)
    {
        $monthcount = 0;
        $m = self::$startmonth;
        $y = self::$startyear;
        $i = 0;
        $j = 0;

        // Skip the first month label if it is before the startdate
        if (1 === self::$startday) {
            self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, 1, $y);
            $monthcount = 1;
        }

        if (1 === $aType) {
            if (15 > self::$startday) {
                self::$minTickPositions[$j++] = \mktime(0, 0, 0, $m, 15, $y);
            }
        }
        ++$m;

        // Loop through all the years included in the scale
        for ($y = self::$startyear; $y <= self::$endyear; ++$y) {
            // Loop through all the months. There are three cases to consider:
            // 1. We are in the first year and must start with the startmonth
            // 2. We are in the end year and we must stop at last month of the scale
            // 3. A year in between where we run through all the 12 months
            $stopmonth = $y === self::$endyear ? self::$endmonth : 12;

            while ($m <= $stopmonth) {
                switch ($aType) {
                    case Configs::DSUTILS_MONTH1:
                        // Set minor tick at the middle of the month
                        if ($aMinor) {
                            if ($m <= $stopmonth) {
                                if (!($y === self::$endyear && $m === $stopmonth && 15 > self::$endday)) {
                                    self::$minTickPositions[$j++] = \mktime(0, 0, 0, $m, 15, $y);
                                }
                            }
                        }
                        // Major at month
                        // Get timestamp of first hour of first day in each month
                        self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, 1, $y);

                        break;
                    case Configs::DSUTILS_MONTH2:
                        if ($aMinor) {
                            // Set minor tick at start of each month
                            self::$minTickPositions[$j++] = \mktime(0, 0, 0, $m, 1, $y);
                        }

                        // Major at every second month
                        // Get timestamp of first hour of first day in each month
                        if ($monthcount % 2 === 0) {
                            self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, 1, $y);
                        }

                        break;
                    case Configs::DSUTILS_MONTH3:
                        if ($aMinor) {
                            // Set minor tick at start of each month
                            self::$minTickPositions[$j++] = \mktime(0, 0, 0, $m, 1, $y);
                        }
                        // Major at every third month
                        // Get timestamp of first hour of first day in each month
                        if ($monthcount % 3 === 0) {
                            self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, 1, $y);
                        }

                        break;
                    case Configs::DSUTILS_MONTH6:
                        if ($aMinor) {
                            // Set minor tick at start of each month
                            self::$minTickPositions[$j++] = \mktime(0, 0, 0, $m, 1, $y);
                        }
                        // Major at every third month
                        // Get timestamp of first hour of first day in each month
                        if ($monthcount % 6 === 0) {
                            self::$tickPositions[$i++] = \mktime(0, 0, 0, $m, 1, $y);
                        }

                        break;
                }
                ++$m;
                ++$monthcount;
            }
            $m = 1;
        }

        // For the case where all dates are within the same month
        // we want to make sure we have at least two ticks on the scale
        // since the scale want work properly otherwise
        if (self::$startmonth === self::$endmonth && self::$startyear === self::$endyear && 1 === $aType) {
            self::$tickPositions[$i++] = \mktime(0, 0, 0, self::$startmonth + 1, 1, self::$startyear);
        }

        return [self::$tickPositions, self::$minTickPositions];
    }

    public static function GetTicks($aData, $aType = 1, $aMinor = false, $aEndPoints = false)
    {
        $n = Configs::safe_count($aData);

        return self::GetTicksFromMinMax($aData[0], $aData[$n - 1], $aType, $aMinor, $aEndPoints);
    }

    /**
     * @return (int|mixed|string)[]|null
     *
     * @psalm-return array{0: -1|1|2|3|4|5|6|7|8|9|10|11|12|13|14|30|60|90|180|352|704|string, 1: mixed, 2: mixed, 3: -1|1|2|3|4|5|6|7|8|9|10|11|12|13|14|30|60|90|180|352|704|string}|null
     */
    public static function GetAutoTicks($aMin, $aMax, $aMaxTicks = 10, $aMinor = false)
    {
        $diff = $aMax - $aMin;
        $spd = 3600 * 24;
        $spw = $spd * 7;
        $spm = $spd * 30;
        $spy = $spd * 352;

        if (self::$iUseWeeks) {
            $w = 'W';
        } else {
            $w = 'd M';
        }

        // Decision table for suitable scales
        // First value: Main decision point
        // Second value: Array of formatting depending on divisor for wanted max number of ticks. <divisor><formatting><format-string>,..
        $tt = [
            [$spw, [1, Configs::DSUTILS_DAY1, 'd M', 2, Configs::DSUTILS_DAY2, 'd M', -1, Configs::DSUTILS_DAY4, 'd M']],
            [$spm, [1, Configs::DSUTILS_DAY1, 'd M', 2, Configs::DSUTILS_DAY2, 'd M', 4, Configs::DSUTILS_DAY4, 'd M', 7, Configs::DSUTILS_WEEK1, $w, -1, Configs::DSUTILS_WEEK2, $w]],
            [$spy, [1, Configs::DSUTILS_DAY1, 'd M', 2, Configs::DSUTILS_DAY2, 'd M', 4, Configs::DSUTILS_DAY4, 'd M', 7, Configs::DSUTILS_WEEK1, $w, 14, Configs::DSUTILS_WEEK2, $w, 30, Configs::DSUTILS_MONTH1, 'M', 60, Configs::DSUTILS_MONTH2, 'M', -1, Configs::DSUTILS_MONTH3, 'M']],
            [-1, [30, Configs::DSUTILS_MONTH1, 'M-Y', 60, Configs::DSUTILS_MONTH2, 'M-Y', 90, Configs::DSUTILS_MONTH3, 'M-Y', 180, Configs::DSUTILS_MONTH6, 'M-Y', 352, Configs::DSUTILS_YEAR1, 'Y', 704, Configs::DSUTILS_YEAR2, 'Y', -1, Configs::DSUTILS_YEAR5, 'Y']],
        ];

        $ntt = Configs::safe_count($tt);
        $nd = \floor($diff / $spd);

        for ($i = 0; $i < $ntt; ++$i) {
            if ($diff > $tt[$i][0] && $ntt - 1 !== $i) {
                continue;
            }

            $t = $tt[$i][1];
            $n = Configs::safe_count($t) / 3;

            for ($j = 0; $j < $n; ++$j) {
                if ($nd / $t[3 * $j] <= $aMaxTicks || $n - 1 === $j) {
                    $type = $t[3 * $j + 1];
                    $fs = $t[3 * $j + 2];
                    [$tickPositions, $minTickPositions] = self::GetTicksFromMinMax($aMin, $aMax, $type, $aMinor);

                    return [$fs, $tickPositions, $minTickPositions, $type];
                }
            }
        }
    }

    /**
     * @param int|string $aType
     *
     * @return array
     *
     * @psalm-return array{0: mixed, 1: mixed}
     */
    public static function GetTicksFromMinMax($aMin, $aMax, $aType, $aMinor = false, $aEndPoints = false)
    {
        self::$starthour = \date('G', $aMin);
        self::$startmonth = \date('n', $aMin);
        self::$startday = \date('j', $aMin);
        self::$startyear = \date('Y', $aMin);
        self::$endmonth = \date('n', $aMax);
        self::$endyear = \date('Y', $aMax);
        self::$endday = \date('j', $aMax);
        self::$iMin = $aMin;
        self::$iMax = $aMax;

        if (Configs::DSUTILS_MONTH6 >= $aType) {
            self::doMonthly($aType, $aMinor);
        } elseif (Configs::DSUTILS_WEEK4 >= $aType) {
            self::doWeekly($aType, $aMinor);
        } elseif (Configs::DSUTILS_DAY4 >= $aType) {
            self::doDaily($aType, $aMinor);
        } elseif (Configs::DSUTILS_YEAR5 >= $aType) {
            self::doYearly($aType, $aMinor);
        } else {
            JpGraphError::RaiseL(24003);
        }
        // put a label at the very left data pos
        if ($aEndPoints) {
            $tickPositions[$i++] = $aData[0];
        }

        // put a label at the very right data pos
        if ($aEndPoints) {
            $tickPositions[$i] = $aData[$n - 1];
        }

        return [self::$tickPositions, self::$minTickPositions];
    }
}
