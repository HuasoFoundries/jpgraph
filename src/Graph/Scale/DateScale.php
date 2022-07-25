<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph\Scale;

use Amenadiel\JpGraph\Graph\Configs;
use Amenadiel\JpGraph\Graph\Tick;
use Amenadiel\JpGraph\Util;
use function date;
use function floor;
use function min;
use function mktime;

/**
 * File:        JPGRAPH_DATE.PHP
 *  Description: Classes to handle Date scaling
 *  Created:     2005-05-02
 *  Ver:         $Id: jpgraph_date.php 1106 2009-02-22 20:16:35Z ljp $.
 * 
 *  Copyright (c) Asial Corporation. All rights reserved.
 */
class DateScale extends LinearScale
{
    private $date_format = '';

    private $iStartAlign = false;

    private $iEndAlign = false;

    private $iStartTimeAlign = false;

    private $iEndTimeAlign = false;

    /**
     * @param mixed $aMin
     * @param mixed $aMax
     * @param mixed $aType
     */
    public function __construct($aMin = 0, $aMax = 0, $aType = 'x')
    {
        \assert('x' === $aType);
        \assert($aMin <= $aMax);

        $this->type = $aType;
        $this->scale = [$aMin, $aMax];
        $this->world_size = $aMax - $aMin;
        $this->ticks = new Tick\LinearTicks();
        $this->intscale = true;
    }

    /**
     * Utility Function AdjDate()
     *  Description: Will round a given time stamp to an even year, month or day
     *  argument.
     *
     * @param mixed $aTime
     * @param mixed $aRound
     * @param mixed $aYearType
     * @param mixed $aMonthType
     * @param mixed $aDayType
     *
     * @return false|int
     */
    public function AdjDate($aTime, $aRound = 0, $aYearType = false, $aMonthType = false, $aDayType = false)
    {
        $y = (int) \date('Y', $aTime);
        $m = (int) \date('m', $aTime);
        $d = (int) \date('d', $aTime);
        $h = 0;
        $i = 0;
        $s = 0;

        if (false !== $aYearType) {
            $yearAdj = [0 => 1, 1 => 2, 2 => 5];

            if (0 === $aRound) {
                $y = \floor($y / $yearAdj[$aYearType]) * $yearAdj[$aYearType];
            } else {
                ++$y;
                $y = \ceil($y / $yearAdj[$aYearType]) * $yearAdj[$aYearType];
            }
            $m = 1;
            $d = 1;
        } elseif (false !== $aMonthType) {
            $monthAdj = [0 => 1, 1 => 6];

            if (0 === $aRound) {
                $m = \floor($m / $monthAdj[$aMonthType]) * $monthAdj[$aMonthType];
                $d = 1;
            } else {
                ++$m;
                $m = \ceil($m / $monthAdj[$aMonthType]) * $monthAdj[$aMonthType];
                $d = 1;
            }
        } elseif (false !== $aDayType) {
            if (0 === $aDayType) {
                if (1 === $aRound) {
                    //++$d;
                    $h = 23;
                    $i = 59;
                    $s = 59;
                }
            } else {
                // Adjust to an even week boundary.
                $w = (int) \date('w', $aTime); // Day of week 0=Sun, 6=Sat

                // Adjust to start on Mon
                if (0 === $w) {
                    $w = 6;
                } else {
                    --$w;
                }

                if (0 === $aRound) {
                    $d -= $w;
                } else {
                    $d += (7 - $w);
                    $h = 23;
                    $i = 59;
                    $s = 59;
                }
            }
        }

        return \mktime($h, $i, $s, $m, $d, $y);
    }

    /**
     * Wrapper for AdjDate that will round a timestamp to an even date rounding
     *  it downwards.
     *
     * @param mixed $aTime
     * @param mixed $aYearType
     * @param mixed $aMonthType
     * @param mixed $aDayType
     */
    public function AdjStartDate($aTime, $aYearType = false, $aMonthType = false, $aDayType = false)
    {
        return $this->AdjDate($aTime, 0, $aYearType, $aMonthType, $aDayType);
    }

    /**
     * Wrapper for AdjDate that will round a timestamp to an even date rounding
     *  it upwards.
     *
     * @param mixed $aTime
     * @param mixed $aYearType
     * @param mixed $aMonthType
     * @param mixed $aDayType
     */
    public function AdjEndDate($aTime, $aYearType = false, $aMonthType = false, $aDayType = false)
    {
        return $this->AdjDate($aTime, 1, $aYearType, $aMonthType, $aDayType);
    }

    /**
     * Utility Function AdjTime()
     *  Description: Will round a given time stamp to an even time according to
     *  argument.
     *
     * @param mixed $aTime
     * @param mixed $aRound
     * @param mixed $aHourType
     * @param mixed $aMinType
     * @param mixed $aSecType
     *
     * @return false|int
     */
    public function AdjTime($aTime, $aRound = 0, $aHourType = false, $aMinType = false, $aSecType = false)
    {
        $y = (int) \date('Y', $aTime);
        $m = (int) \date('m', $aTime);
        $d = (int) \date('d', $aTime);
        $h = (int) \date('H', $aTime);
        $i = (int) \date('i', $aTime);
        $s = (int) \date('s', $aTime);

        if (false !== $aHourType) {
            $aHourType %= 6;
            $hourAdj = [0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 6, 5 => 12];

            if (0 === $aRound) {
                $h = \floor($h / $hourAdj[$aHourType]) * $hourAdj[$aHourType];
            } else {
                if (($h % $hourAdj[$aHourType] === 0) && (0 < $i || 0 < $s)) {
                    ++$h;
                }
                $h = \ceil($h / $hourAdj[$aHourType]) * $hourAdj[$aHourType];

                if (24 <= $h) {
                    $aTime += 86400;
                    $y = (int) \date('Y', $aTime);
                    $m = (int) \date('m', $aTime);
                    $d = (int) \date('d', $aTime);
                    $h -= 24;
                }
            }
            $i = 0;
            $s = 0;
        } elseif (false !== $aMinType) {
            $aMinType %= 5;
            $minAdj = [0 => 1, 1 => 5, 2 => 10, 3 => 15, 4 => 30];

            if (0 === $aRound) {
                $i = \floor($i / $minAdj[$aMinType]) * $minAdj[$aMinType];
            } else {
                if (($i % $minAdj[$aMinType] === 0) && 0 < $s) {
                    ++$i;
                }
                $i = \ceil($i / $minAdj[$aMinType]) * $minAdj[$aMinType];

                if (60 <= $i) {
                    $aTime += 3600;
                    $y = (int) \date('Y', $aTime);
                    $m = (int) \date('m', $aTime);
                    $d = (int) \date('d', $aTime);
                    $h = (int) \date('H', $aTime);
                    $i = 0;
                }
            }
            $s = 0;
        } elseif (false !== $aSecType) {
            $aSecType %= 5;
            $secAdj = [0 => 1, 1 => 5, 2 => 10, 3 => 15, 4 => 30];

            if (0 === $aRound) {
                $s = \floor($s / $secAdj[$aSecType]) * $secAdj[$aSecType];
            } else {
                $s = \ceil($s / $secAdj[$aSecType] * 1.0) * $secAdj[$aSecType];

                if (60 <= $s) {
                    $s = 0;
                    $aTime += 60;
                    $y = (int) \date('Y', $aTime);
                    $m = (int) \date('m', $aTime);
                    $d = (int) \date('d', $aTime);
                    $h = (int) \date('H', $aTime);
                    $i = (int) \date('i', $aTime);
                }
            }
        }

        return \mktime($h, $i, $s, $m, $d, $y);
    }

    /**
     * Wrapper for AdjTime that will round a timestamp to an even time rounding
     *  it downwards.
     *  Example: AdjStartTime(mktime(18,27,13,2,22,2005),false,2) => 18:20.
     *
     * @param mixed $aTime
     * @param mixed $aHourType
     * @param mixed $aMinType
     * @param mixed $aSecType
     */
    public function AdjStartTime($aTime, $aHourType = false, $aMinType = false, $aSecType = false)
    {
        return $this->AdjTime($aTime, 0, $aHourType, $aMinType, $aSecType);
    }

    /**
     * Wrapper for AdjTime that will round a timestamp to an even time rounding
     *  it upwards
     *  Example: AdjEndTime(mktime(18,27,13,2,22,2005),false,2) => 18:30.
     *
     * @param mixed $aTime
     * @param mixed $aHourType
     * @param mixed $aMinType
     * @param mixed $aSecType
     */
    public function AdjEndTime($aTime, $aHourType = false, $aMinType = false, $aSecType = false)
    {
        return $this->AdjTime($aTime, 1, $aHourType, $aMinType, $aSecType);
    }

    /**
     * DateAutoScale
     *  Autoscale a date axis given start and end time
     *  Returns an array ($start,$end,$major,$minor,$format).
     *
     * @param mixed $aStartTime
     * @param mixed $aEndTime
     * @param mixed $aDensity
     * @param mixed $aAdjust
     *
     * @return array|false
     *
     * @psalm-return array{0: mixed, 1: mixed, 2: mixed, 3: mixed, 4: mixed}|false
     */
    public function DoDateAutoScale($aStartTime, $aEndTime, $aDensity = 0, $aAdjust = true)
    {
        // Format of array
        // array ( Decision point,  array( array( Major-scale-step-array ),
        //       array( Minor-scale-step-array ),
        //       array( 0=date-adjust, 1=time-adjust, adjustment-alignment) )
        $scalePoints =
            [
                /* Intervall larger than 10 years */
                Configs::SECPERYEAR * 10,
                [
                    [
                        Configs::SECPERYEAR * 5,
                        Configs::SECPERYEAR * 2,
                    ],
                    [
                        Configs::SECPERYEAR,
                    ],
                    [
                        0,
                        Configs::YEARADJ_1,
                        0,
                        Configs::YEARADJ_1,
                    ],
                ],

                /* Intervall larger than 2 years */
                Configs::SECPERYEAR * 2,
                [
                    [
                        Configs::SECPERYEAR,
                    ], [
                        Configs::SECPERYEAR,
                    ],
                    [
                        0,
                        Configs::YEARADJ_1,
                    ],
                ],

                /* Intervall larger than 90 days (approx 3 month) */
                Configs::SECPERDAY * 90,
                [
                    [
                        Configs::SECPERDAY * 30,
                        Configs::SECPERDAY * 14,
                        Configs::SECPERDAY * 7,
                        Configs::SECPERDAY,
                    ],
                    [
                        Configs::SECPERDAY * 5,
                        Configs::SECPERDAY * 7,
                        Configs::SECPERDAY,
                        Configs::SECPERDAY,
                    ],
                    [
                        0,
                        Configs::MONTHADJ_1,
                        0,
                        Configs::DAYADJ_WEEK,
                        0,
                        Configs::DAYADJ_1,
                        0,
                        Configs::DAYADJ_1,
                    ],
                ],

                /* Intervall larger than 30 days (approx 1 month) */
                Configs::SECPERDAY * 30,
                [
                    [
                        Configs::SECPERDAY * 14,
                        Configs::SECPERDAY * 7,
                        Configs::SECPERDAY * 2,
                        Configs::SECPERDAY,
                    ],
                    [
                        Configs::SECPERDAY,
                        Configs::SECPERDAY,
                        Configs::SECPERDAY,
                        Configs::SECPERDAY,
                    ],
                    [
                        0,
                        Configs::DAYADJ_WEEK,
                        0,
                        Configs::DAYADJ_1,
                        0,
                        Configs::DAYADJ_1,
                        0,
                        Configs::DAYADJ_1,
                    ],
                ],

                /* Intervall larger than 7 days */
                Configs::SECPERDAY * 7,
                [
                    [
                        Configs::SECPERDAY,
                        Configs::SECPERHOUR * 12,
                        Configs::SECPERHOUR * 6,
                        Configs::SECPERHOUR * 2,
                    ],
                    [
                        Configs::SECPERHOUR * 6,
                        Configs::SECPERHOUR * 3,
                        Configs::SECPERHOUR,
                        Configs::SECPERHOUR,
                    ],
                    [
                        0,
                        Configs::DAYADJ_1,
                        1,
                        Configs::HOURADJ_12,
                        1,
                        Configs::HOURADJ_6,
                        1,
                        Configs::HOURADJ_1,
                    ],
                ],

                /* Intervall larger than 1 day */
                Configs::SECPERDAY,
                [
                    [
                        Configs::SECPERDAY,
                        Configs::SECPERHOUR * 12,
                        Configs::SECPERHOUR * 6,
                        Configs::SECPERHOUR * 2,
                        Configs::SECPERHOUR,
                    ],
                    [
                        Configs::SECPERHOUR * 6,
                        Configs::SECPERHOUR * 2,
                        Configs::SECPERHOUR,
                        Configs::SECPERHOUR,
                        Configs::SECPERHOUR,
                    ],
                    [
                        1,
                        Configs::HOURADJ_12,
                        1,
                        Configs::HOURADJ_6,
                        1,
                        Configs::HOURADJ_1,
                        1,
                        Configs::HOURADJ_1,
                    ],
                ],

                /* Intervall larger than 12 hours */
                Configs::SECPERHOUR * 12,
                [
                    [
                        Configs::SECPERHOUR * 2,
                        Configs::SECPERHOUR,
                        Configs::SECPERMIN * 30,
                        900,
                        600,
                    ],
                    [1800, 1800, 900, 300, 300],
                    [
                        1,
                        Configs::HOURADJ_1,
                        1,
                        Configs::MINADJ_30,
                        1,
                        Configs::MINADJ_15,
                        1,
                        Configs::MINADJ_10,
                        1,
                        Configs::MINADJ_5,
                    ],
                ],

                /* Intervall larger than 2 hours */
                Configs::SECPERHOUR * 2,
                [
                    [
                        Configs::SECPERHOUR,
                        Configs::SECPERMIN * 30,
                        900,
                        600,
                        300,
                    ],
                    [1800, 900, 300, 120, 60],
                    [
                        1,
                        Configs::HOURADJ_1,
                        1,
                        Configs::MINADJ_30,
                        1,
                        Configs::MINADJ_15,
                        1,
                        Configs::MINADJ_10,
                        1,
                        Configs::MINADJ_5,
                    ],
                ],

                /* Intervall larger than 1 hours */
                Configs::SECPERHOUR,
                [
                    [
                        Configs::SECPERMIN * 30,
                        900,
                        600,
                        300,
                    ], [900, 300, 120, 60],
                    [
                        1,
                        Configs::MINADJ_30,
                        1,
                        Configs::MINADJ_15,
                        1,
                        Configs::MINADJ_10,
                        1,
                        Configs::MINADJ_5,
                    ],
                ],

                /* Intervall larger than 30 min */
                Configs::SECPERMIN * 30,
                [
                    [
                        Configs::SECPERMIN * 15,
                        Configs::SECPERMIN * 10,
                        Configs::SECPERMIN * 5,
                        Configs::SECPERMIN,
                    ],
                    [300, 300, 60, 10],
                    [
                        1,
                        Configs::MINADJ_15,
                        1,
                        Configs::MINADJ_10,
                        1,
                        Configs::MINADJ_5,
                        1,
                        Configs::MINADJ_1,
                    ],
                ],

                /* Intervall larger than 1 min */
                Configs::SECPERMIN,
                [
                    [
                        Configs::SECPERMIN,
                        15,
                        10,
                        5,
                    ],
                    [15, 5, 2, 1],
                    [
                        1,
                        Configs::MINADJ_1,
                        1,
                        Configs::SECADJ_15,
                        1,
                        Configs::SECADJ_10,
                        1,
                        Configs::SECADJ_5,
                    ],
                ],

                /* Intervall larger than 10 sec */
                10,
                [
                    [5, 2],
                    [1, 1],
                    [
                        1,
                        Configs::SECADJ_5,
                        1,
                        Configs::SECADJ_1,
                    ],
                ],

                /* Intervall larger than 1 sec */
                1,
                [
                    [1],
                    [1],
                    [
                        1,
                        Configs::SECADJ_1,
                    ],
                ],
            ];

        $ns = Configs::safe_count($scalePoints);
        // Establish major and minor scale units for the date scale
        $diff = $aEndTime - $aStartTime;

        if (1 > $diff) {
            return false;
        }

        $done = false;
        $i = 0;

        while (!$done) {
            if ($scalePoints[2 * $i] < $diff) {
                // Get major and minor scale for this intervall
                $scaleSteps = $scalePoints[2 * $i + 1];
                $major = $scaleSteps[0][\min($aDensity, Configs::safe_count($scaleSteps[0]) - 1)];
                // Try to find out which minor step looks best
                $minor = $scaleSteps[1][\min($aDensity, Configs::safe_count($scaleSteps[1]) - 1)];

                if ($aAdjust) {
                    // Find out how we should align the start and end timestamps
                    $idx = 2 * \min($aDensity, \floor(
                        Configs::safe_count($scaleSteps[2]) / 2
                    ) - 1);

                    if (0 === $scaleSteps[2][$idx]) {
                        // Use date adjustment
                        $adj = $scaleSteps[2][$idx + 1];

                        if (30 <= $adj) {
                            $start = $this->AdjStartDate($aStartTime, $adj - 30);
                            $end = $this->AdjEndDate($aEndTime, $adj - 30);
                        } elseif (20 <= $adj) {
                            $start = $this->AdjStartDate($aStartTime, false, $adj - 20);
                            $end = $this->AdjEndDate($aEndTime, false, $adj - 20);
                        } else {
                            $start = $this->AdjStartDate($aStartTime, false, false, $adj);
                            $end = $this->AdjEndDate($aEndTime, false, false, $adj);
                            // We add 1 second for date adjustment to make sure we end on 00:00 the following day
                            // This makes the final major tick be srawn when we step day-by-day instead of ending
                            // on xx:59:59 which would not draw the final major tick
                            ++$end;
                        }
                    } else {
                        // Use time adjustment
                        $adj = $scaleSteps[2][$idx + 1];

                        if (30 <= $adj) {
                            $start = $this->AdjStartTime($aStartTime, $adj - 30);
                            $end = $this->AdjEndTime($aEndTime, $adj - 30);
                        } elseif (20 <= $adj) {
                            $start = $this->AdjStartTime($aStartTime, false, $adj - 20);
                            $end = $this->AdjEndTime($aEndTime, false, $adj - 20);
                        } else {
                            $start = $this->AdjStartTime($aStartTime, false, false, $adj);
                            $end = $this->AdjEndTime($aEndTime, false, false, $adj);
                        }
                    }
                }
                // If the overall date span is larger than 1 day ten we show date
                $format = '';

                if (
                    Configs::SECPERDAY < ($end - $start)
                ) {
                    $format = 'Y-m-d ';
                }
                // If the major step is less than 1 day we need to whow hours + min
                if (
                    Configs::SECPERDAY > $major
                ) {
                    $format .= 'H:i';
                }
                // If the major step is less than 1 min we need to show sec
                if (60 > $major) {
                    $format .= ':s';
                }
                $done = true;
            }
            ++$i;
        }

        return [$start, $end, $major, $minor, $format];
    }

    // Overrides the automatic determined date format. Must be a valid date() format string
    /**
     * @return void
     */
    public function SetDateFormat($aFormat)
    {
        $this->date_format = $aFormat;
        $this->ticks->SetLabelDateFormat($this->date_format);
    }

    /**
     * @return void
     */
    public function AdjustForDST($aFlg = true)
    {
        $this->ticks->AdjustForDST($aFlg);
    }

    /**
     * @return void
     */
    public function SetDateAlign($aStartAlign, $aEndAlign = false)
    {
        if (false === $aEndAlign) {
            $aEndAlign = $aStartAlign;
        }
        $this->iStartAlign = $aStartAlign;
        $this->iEndAlign = $aEndAlign;
    }

    /**
     * @return void
     */
    public function SetTimeAlign($aStartAlign, $aEndAlign = false)
    {
        if (false === $aEndAlign) {
            $aEndAlign = $aStartAlign;
        }
        $this->iStartTimeAlign = $aStartAlign;
        $this->iEndTimeAlign = $aEndAlign;
    }

    /**
     * @param float $aNumSteps
     * @param false $majend
     *
     * @return void
     */
    public function AutoScale($img, $min, $max, $maxsteps, $majend = false)
    {
        // We need to have one dummy argument to make the signature of AutoScale()
        // identical to LinearScale::AutoScale
        if ($min === $max) {
            // Special case when we only have one data point.
            // Create a small artifical intervall to do the autoscaling
            $min -= 10;
            $max += 10;
        }
        $done = false;
        $i = 0;

        while (!$done && 5 > $i) {
            [$adjstart, $adjend, $maj, $min_new, $format] = $this->DoDateAutoScale($min, $max, $i);
            $n = \floor(($adjend - $adjstart) / $maj);

            if ($n * 1.7 > $maxsteps) {
                $done = true;
            }
            ++$i;
        }

        /*
        if( 0 ) { // DEBUG
        echo "    Start =".date("Y-m-d H:i:s",$aStartTime)."<br>";
        echo "    End   =".date("Y-m-d H:i:s",$aEndTime)."<br>";
        echo "Adj Start =".date("Y-m-d H:i:s",$adjstart)."<br>";
        echo "Adj End   =".date("Y-m-d H:i:s",$adjend)."<p>";
        echo "Major = $maj s, ".floor($maj/60)."min, ".floor($maj/3600)."h, ".floor($maj/86400)."day<br>";
        echo "Min = $min s, ".floor($min/60)."min, ".floor($min/3600)."h, ".floor($min/86400)."day<br>";
        echo "Format=$format<p>";
        }
         */

        if (false !== $this->iStartTimeAlign && false !== $this->iStartAlign) {
            throw      Util\JpGraphError::make(3001);
            //('It is only possible to use either SetDateAlign() or SetTimeAlign() but not both');
        }

        if (false !== $this->iStartTimeAlign) {
            if (30 <= $this->iStartTimeAlign) {
                $adjstart = $this->AdjStartTime($min, $this->iStartTimeAlign - 30);
            } elseif (20 <= $this->iStartTimeAlign) {
                $adjstart = $this->AdjStartTime($min, false, $this->iStartTimeAlign - 20);
            } else {
                $adjstart = $this->AdjStartTime($min, false, false, $this->iStartTimeAlign);
            }
        }

        if (false !== $this->iEndTimeAlign) {
            if (30 <= $this->iEndTimeAlign) {
                $adjend = $this->AdjEndTime($max, $this->iEndTimeAlign - 30);
            } elseif (20 <= $this->iEndTimeAlign) {
                $adjend = $this->AdjEndTime($max, false, $this->iEndTimeAlign - 20);
            } else {
                $adjend = $this->AdjEndTime($max, false, false, $this->iEndTimeAlign);
            }
        }

        if (false !== $this->iStartAlign) {
            if (30 <= $this->iStartAlign) {
                $adjstart = $this->AdjStartDate($min, $this->iStartAlign - 30);
            } elseif (20 <= $this->iStartAlign) {
                $adjstart = $this->AdjStartDate($min, false, $this->iStartAlign - 20);
            } else {
                $adjstart = $this->AdjStartDate($min, false, false, $this->iStartAlign);
            }
        }

        if (false !== $this->iEndAlign) {
            if (30 <= $this->iEndAlign) {
                $adjend = $this->AdjEndDate($max, $this->iEndAlign - 30);
            } elseif (20 <= $this->iEndAlign) {
                $adjend = $this->AdjEndDate($max, false, $this->iEndAlign - 20);
            } else {
                $adjend = $this->AdjEndDate($max, false, false, $this->iEndAlign);
            }
        }
        $this->Update($img, $adjstart, $adjend);

        if (!$this->ticks->IsSpecified()) {
            $this->ticks->Set($maj, $min_new);
        }

        if ('' === $this->date_format) {
            $this->ticks->SetLabelDateFormat($format);
        } else {
            $this->ticks->SetLabelDateFormat($this->date_format);
        }
    }
}
