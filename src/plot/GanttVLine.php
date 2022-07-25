<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Plot;

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;

class GanttVLine extends GanttPlotObject
{
    private $iLine;

    private $title_margin = 3;

    private $iDayOffset = 0.5;

    private $iStartRow = -1;

    private $iEndRow = -1;

    /**
     * @param mixed $aDate
     * @param mixed $aTitle
     * @param mixed $aColor
     * @param mixed $aWeight
     * @param mixed $aStyle
     */
    public function __construct($aDate, $aTitle = '', $aColor = 'darkred', $aWeight = 2, $aStyle = 'solid')
    {
        parent::__construct();
        $this->iLine = new Graph\Scale\LineProperty();
        $this->iLine->SetColor($aColor);
        $this->iLine->SetWeight($aWeight);
        $this->iLine->SetStyle($aStyle);
        $this->iStart = $aDate;
        $this->title = new Text\TextPropertyBelow();
        $this->title->Set($aTitle);
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aStart
     * @param mixed $aEnd
     */
    // Set start and end rows for the VLine. By default the entire heigh of the
    // Gantt chart is used
    public function SetRowSpan($aStart, $aEnd = -1)
    {
        $this->iStartRow = $aStart;
        $this->iEndRow = $aEnd;
    }

    public function SetDayOffset($aOff = 0.5)
    {
        if (0.0 > $aOff || 1.0 < $aOff) {
            throw Util\JpGraphError::make(6029);
            //("Offset for vertical line must be in range [0,1]");
        }
        $this->iDayOffset = $aOff;
    }

    public function SetTitleMargin($aMarg)
    {
        $this->title_margin = $aMarg;
    }

    public function SetWeight($aWeight)
    {
        $this->iLine->SetWeight($aWeight);
    }

    public function Stroke($aImg, $aScale)
    {
        $d = $aScale->NormalizeDate($this->iStart);

        if ($d < $aScale->iStartDate || $d > $aScale->iEndDate) {
            return;
        }

        if (0.0 !== $this->iDayOffset) {
            $d += 24 * 60 * 60 * $this->iDayOffset;
        }

        $x = $aScale->TranslateDate($d); //d=1006858800,

        if (-1 < $this->iStartRow) {
            $y1 = $aScale->TranslateVertPos($this->iStartRow, true);
        } else {
            $y1 = $aScale->iVertHeaderSize + $aImg->top_margin;
        }

        if (-1 < $this->iEndRow) {
            $y2 = $aScale->TranslateVertPos($this->iEndRow);
        } else {
            $y2 = $aImg->height - $aImg->bottom_margin;
        }

        $this->iLine->Stroke($aImg, $x, $y1, $x, $y2);
        $this->title->Align('center', 'top');
        $this->title->Stroke($aImg, $x, $y2 + $this->title_margin);
    }
}
