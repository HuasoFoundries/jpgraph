<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;

/**
 * Class CCBPGraph
 * Utility class to create Critical Chain Buffer penetration charts.
 */
final class CCBPGraph
{
    public const TickStep = 25;
    public const YTitle = '% Buffer used';
    public const XTitle = '% CC Completed';
    public const NColorMaps = 2;

    /**
     * @var \Amenadiel\JpGraph\Graph\Graph|null
     */
    private $graph;

    /**
     * @var int
     */
    private $iWidth;

    /**
     * @var int
     */
    private $iHeight;

    /**
     * @var mixed[]
     */
    private $iPlots = [];

    /**
     * @var int|float
     */
    private $iXMin = -50;

    /**
     * @var int|float
     */
    private $iXMax = 100;

    /**
     * @var int|float
     */
    private $iYMin = -50;

    /**
     * @var int|float
     */
    private $iYMax = 150;

    /**
     * @var array<int, array<int>>|mixed[]
     */
    private $iColorInd = [
        [5, 75], /* Green */
        [25, 85], /* Yellow */
        [50, 100],
    ]; /* Red */
    /**
     * @var int
     */
    private $iColorMap = 0;

    /**
     * @var array<int, array<string>>|mixed[]
     */
    private $iColorSpec = [
        ['darkgreen:1.0', 'yellow:1.4', 'red:0.8', 'darkred:0.85'],
        ['#c6e9af', '#ffeeaa', '#ffaaaa', '#de8787'],
    ];

    private const I_MARGIN_COLOR = ['darkgreen@0.7', 'darkgreen@0.9'];

    /**
     * @var string
     */
    private $iSubTitle = '';

    /**
     * @var string
     */
    private $iTitle = 'CC Buffer penetration';
    /**
     * @var string
     */
    private const DARKGRAY = 'darkgray';
    // Use an accumulated fille line graph to create the colored bands
    /**
     * @var int
     */
    private const N = 3;

    /**
     * Construct a new instance of CCBPGraph.
     *
     * @param int $aWidth
     * @param int $aHeight
     *
     * @return CCBPGraph
     */
    public function __construct($aWidth, $aHeight)
    {
        $this->iWidth = $aWidth;
        $this->iHeight = $aHeight;
    }

    /**
     * Set the title and subtitle for the graph.
     */
    public function SetTitle(string $aTitle, string $aSubTitle): void
    {
        $this->iTitle = $aTitle;
        $this->iSubTitle = $aSubTitle;
    }

    /**
     * Set the x-axis min and max values.
     */
    public function SetXMinMax(int $aMin, int $aMax): void
    {
        $this->iXMin = \floor($aMin / self::TickStep) * self::TickStep;
        $this->iXMax = \ceil($aMax / self::TickStep) * self::TickStep;
    }

    /**
     * Specify what color map to use.
     */
    public function SetColorMap(int $aMap): void
    {
        $this->iColorMap = $aMap % self::NColorMaps;
    }

    /**
     * Set the y-axis min and max values.
     */
    public function SetYMinMax(int $aMin, int $aMax): void
    {
        $this->iYMin = \floor($aMin / self::TickStep) * self::TickStep;
        $this->iYMax = \ceil($aMax / self::TickStep) * self::TickStep;
    }

    /**
     * Set the specification of the color backgrounds and also the
     * optional exact colors to be used.
     *
     * @param mixed $aSpec   An array of 3 1x2 arrays. Each array specify the
     *                       color indication value at x=0 and x=max x in order to determine the slope
     * @param mixed $aColors An array with four elements specifying the colors
     *                       of each color indicator
     */
    public function SetColorIndication(array $aSpec, ?array $aColors = null): void
    {
        if (
            Configs::safe_count($aSpec) !== 3
        ) {
            Util\JpGraphError::Raise('Specification of scale values for background indicators must be an array with three elements.');
        }
        $this->iColorInd = $aSpec;

        if (null === $aColors) {
            return;
        }

        if (\is_array($aColors) && Configs::safe_count($aColors) === 4) {
            $this->iColorSpec = $aColors;
        } else {
            Util\JpGraphError::Raise('Color specification for background indication must have four colors.');
        }
    }

    /**
     * Add a line or scatter plot to the graph.
     *
     * @param mixed $aPlots
     */
    public function Add($aPlots): void
    {
        if (\is_array($aPlots)) {
            $this->iPlots = \array_merge($this->iPlots, $aPlots);
        } else {
            $this->iPlots[] = $aPlots;
        }
    }

    /**
     * Stroke the graph back to the client or to a file.
     *
     * @param mixed $aFile
     */
    public function Stroke($aFile = ''): void
    {
        $this->Init();

        if (
            Configs::safe_count($this->iPlots) > 0
        ) {
            $this->graph->Add($this->iPlots);
        }
        $this->graph->Stroke($aFile);
    }

    /**
     * Construct the graph.
     */
    private function Init(): void
    {
        // Setup limits for color indications
        $lowx = $this->iXMin;
        $highx = $this->iXMax;
        $lowy = $this->iYMin;
        $highy = $this->iYMax;
        $width = $this->iWidth;
        $height = $this->iHeight;

        // Margins
        $lm = 50;
        $rm = 40;
        $tm = 60;
        $bm = 40;

        if (300 >= $width || 250 >= $height) {
            $labelsize = 8;
            $lm = 25;
            $rm = 25;
            $tm = 45;
            $bm = 25;
        } elseif (450 >= $width || 300 >= $height) {
            $labelsize = 8;
            $lm = 30;
            $rm = 30;
            $tm = 50;
            $bm = 30;
        } elseif (600 >= $width || 400 >= $height) {
            $labelsize = 9;
        } else {
            $labelsize = 11;
        }

        if ('' === $this->iSubTitle) {
            $tm -= $labelsize + 4;
        }

        $graph = new Graph($width, $height);
        $graph->clearTheme();
        $graph->SetScale('intint', $lowy, $highy, $lowx, $highx);
        $graph->SetMargin($lm, $rm, $tm, $bm);
        $graph->SetMarginColor(self::I_MARGIN_COLOR[$this->iColorMap]);
        $graph->SetClipping();

        $graph->title->Set($this->iTitle);
        $graph->subtitle->Set($this->iSubTitle);

        $graph->title->SetFont(
            Configs::FF_ARIAL,
            Configs::FS_BOLD,
            $labelsize + 4
        );
        $graph->subtitle->SetFont(
            Configs::FF_ARIAL,
            Configs::FS_BOLD,
            $labelsize + 1
        );

        $graph->SetBox(true, 'black@0.3');

        $graph->xaxis->SetFont(
            Configs::FF_ARIAL,
            Configs::FS_BOLD,
            $labelsize
        );
        $graph->yaxis->SetFont(
            Configs::FF_ARIAL,
            Configs::FS_BOLD,
            $labelsize
        );

        $graph->xaxis->scale->ticks->Set(self::TickStep, self::TickStep);
        $graph->yaxis->scale->ticks->Set(self::TickStep, self::TickStep);

        $graph->xaxis->HideZeroLabel();
        $graph->yaxis->HideZeroLabel();

        $graph->xaxis->SetLabelFormatString('%d%%');
        $graph->yaxis->SetLabelFormatString('%d%%');

        // For the x-axis we adjust the color so labels on the left of the Y-axis are in black
        $n1 = \floor(\abs($this->iXMin / 25)) + 1;
        $n2 = \floor($this->iXMax / 25);

        if (0 === $this->iColorMap) {
            $xlcolors = [];

            for ($i = 0; $i < $n1; ++$i) {
                $xlcolors[$i] = 'black';
            }

            for ($i = 0; $i < $n2; ++$i) {
                $xlcolors[$n1 + $i] = 'lightgray:1.5';
            }
            $graph->xaxis->SetColor('gray', $xlcolors);
            $graph->yaxis->SetColor('gray', 'lightgray:1.5');
        } else {
            $graph->xaxis->SetColor(self::DARKGRAY, 'darkgray:0.8');
            $graph->yaxis->SetColor(self::DARKGRAY, 'darkgray:0.8');
        }
        $graph->SetGridDepth(Configs::DEPTH_FRONT);
        $graph->ygrid->SetColor('gray@0.6');
        $graph->ygrid->SetLineStyle('dotted');

        $graph->ygrid->Show();

        $graph->xaxis->SetWeight(1);
        $graph->yaxis->SetWeight(1);

        $ytitle = new Text\Text(self::YTitle, \floor($lm * .75), ($height - $tm - $bm) / 2 + $tm);
        $ytitle->SetFont(Configs::FF_VERA, Configs::FS_BOLD, $labelsize + 1);
        $ytitle->SetAlign('right', 'center');
        $ytitle->SetAngle(90);
        $graph->Add($ytitle);

        $xtitle = new Text\Text(self::XTitle, ($width - $lm - $rm) / 2 + $lm, $height - 10);
        $xtitle->SetFont(Configs::FF_VERA, Configs::FS_BOLD, $labelsize);
        $xtitle->SetAlign('center', 'bottom');
        $graph->Add($xtitle);

        $df = 'D j:S M, Y';

        if (400 > $width) {
            $df = 'D j:S M';
        }

        $time = new Text\Text(\date($df), $width - 10, $height - 10);
        $time->SetAlign('right', 'bottom');
        // $time->SetFont(Configs::FF_VERA,Configs::getConfig('FS_NORMAL'),$labelsize-1);
        $time->SetColor(self::DARKGRAY);
        $graph->Add($time);

        for ($i = 0; $i < self::N; ++$i) {
            $b = $this->iColorInd[$i][0];
            $k = ($this->iColorInd[$i][1] - $this->iColorInd[$i][0]) / $this->iXMax;
            $colarea[$i] = [[$lowx, $lowx * $k + $b], [$highx, $highx * $k + $b]];
        }
        $colarea[3] = [[$lowx, $highy], [$highx, $highy]];

        $cb = [];

        for ($i = 0; 4 > $i; ++$i) {
            $cb[$i] = new Plot\LinePlot(
                [$colarea[$i][0][1], $colarea[$i][1][1]],
                [$colarea[$i][0][0], $colarea[$i][1][0]]
            );
            $cb[$i]->SetFillColor($this->iColorSpec[$this->iColorMap][$i]);
            $cb[$i]->SetFillFromYMin();
        }

        $graph->Add(\array_slice(\array_reverse($cb), 0, 4));
        $this->graph = $graph;
    }
}
