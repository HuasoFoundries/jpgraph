<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Util;

/**
 * @class Grid
 *  Description: responsible for drawing grid lines in graph
 */
class Grid
{
    protected $img;

    public $scale;

    protected $majorcolor = '#CCCCCC';

    protected $minorcolor = '#DDDDDD';

    protected $majortype = 'solid';

    protected $minortype = 'solid';

    protected $show = false;

    protected $showMinor = false;

    protected $majorweight = 1;

    protected $minorweight = 1;

    protected $fill = false;

    /**
     * @var (mixed|string)[]
     *
     * @psalm-var array{0: mixed|string, 1: mixed|string}
     */
    protected $fillcolor = ['#EFEFEF', '#BBCCFF'];

    public function __construct($aAxis)
    {
        $this->scale = $aAxis->scale;
        $this->img = $aAxis->img;
    }

    public function SetColor($aMajColor, $aMinColor = false)
    {
        $this->majorcolor = $aMajColor;

        if (false === $aMinColor) {
            $aMinColor = $aMajColor;
        }
        $this->minorcolor = $aMinColor;
    }

    public function SetWeight($aMajorWeight, $aMinorWeight = 1)
    {
        $this->majorweight = $aMajorWeight;
        $this->minorweight = $aMinorWeight;
    }

    // Specify if grid should be dashed, dotted or solid
    public function SetLineStyle($aMajorType, $aMinorType = 'solid')
    {
        $this->majortype = $aMajorType;
        $this->minortype = $aMinorType;
    }

    public function SetStyle($aMajorType, $aMinorType = 'solid')
    {
        $this->SetLineStyle($aMajorType, $aMinorType);
    }

    // Decide if both major and minor grid should be displayed
    public function Show($aShowMajor = true, $aShowMinor = false)
    {
        $this->show = $aShowMajor;
        $this->showMinor = $aShowMinor;
    }

    public function SetFill($aFlg = true, $aColor1 = 'lightgray', $aColor2 = 'lightblue')
    {
        $this->fill = $aFlg;
        $this->fillcolor = [$aColor1, $aColor2];
    }

    // Display the grid
    public function Stroke()
    {
        if ($this->showMinor && !$this->scale->textscale) {
            $this->DoStroke($this->scale->ticks->ticks_pos, $this->minortype, $this->minorcolor, $this->minorweight);
            $this->DoStroke($this->scale->ticks->maj_ticks_pos, $this->majortype, $this->majorcolor, $this->majorweight);
        } else {
            $this->DoStroke($this->scale->ticks->maj_ticks_pos, $this->majortype, $this->majorcolor, $this->majorweight);
        }
    }

    /**
     * Private methods
     *  Draw the grid.
     *
     * @param mixed $aTicksPos
     * @param mixed $aType
     * @param mixed $aColor
     * @param mixed $aWeight
     */
    public function DoStroke($aTicksPos, $aType, $aColor, $aWeight)
    {
        $nbrgrids = Configs::safe_count($aTicksPos);

        if (!$this->show || 0 === $nbrgrids) {
            return;
        }

        if ('y' === $this->scale->type) {
            $xl = $this->img->left_margin;
            $xr = $this->img->width - $this->img->right_margin;

            if ($this->fill) {
                // Draw filled areas
                $y2 = $aTicksPos[0];
                $i = 1;

                while ($i < $nbrgrids) {
                    $y1 = $y2;
                    $y2 = $aTicksPos[$i++];
                    $this->img->SetColor($this->fillcolor[$i & 1]);
                    $this->img->FilledRectangle($xl, $y1, $xr, $y2);
                }
            }

            $this->img->SetColor($aColor);
            $this->img->SetLineWeight($aWeight);

            // Draw grid lines
            switch ($aType) {
                case 'solid':
                    $style = Configs::getConfig('LINESTYLE_SOLID');

                    break;
                case 'dotted':
                    $style = Configs::getConfig('LINESTYLE_DOTTED');

                    break;
                case 'dashed':
                    $style = Configs::getConfig('LINESTYLE_DASHED');

                    break;
                case 'longdashed':
                    $style = Configs::getConfig('LINESTYLE_LONGDASH');

                    break;

                default:
                    $style = Configs::getConfig('LINESTYLE_SOLID');

                    break;
            }

            for ($i = 0; $i < $nbrgrids; ++$i) {
                $y = $aTicksPos[$i];
                $this->img->StyleLine($xl, $y, $xr, $y, $style, true);
            }
        } elseif ('x' === $this->scale->type) {
            $yu = $this->img->top_margin;
            $yl = $this->img->height - $this->img->bottom_margin;
            $limit = $this->img->width - $this->img->right_margin;

            if ($this->fill) {
                // Draw filled areas
                $x2 = $aTicksPos[0];
                $i = 1;

                while ($i < $nbrgrids) {
                    $x1 = $x2;
                    $x2 = \min($aTicksPos[$i++], $limit);
                    $this->img->SetColor($this->fillcolor[$i & 1]);
                    $this->img->FilledRectangle($x1, $yu, $x2, $yl);
                }
            }

            $this->img->SetColor($aColor);
            $this->img->SetLineWeight($aWeight);

            // We must also test for limit since we might have
            // an offset and the number of ticks is calculated with
            // assumption offset==0 so we might end up drawing one
            // to many gridlines
            $i = 0;
            $x = $aTicksPos[$i];

            while (
                Configs::safe_count($aTicksPos) > $i && ($x = $aTicksPos[$i]) <= $limit
            ) {
                if ('solid' === $aType) {
                    $this->img->Line($x, $yl, $x, $yu);
                } elseif ('dotted' === $aType) {
                    $this->img->DashedLineForGrid($x, $yl, $x, $yu, 1, 6);
                } elseif ('dashed' === $aType) {
                    $this->img->DashedLineForGrid($x, $yl, $x, $yu, 2, 4);
                } elseif ('longdashed' === $aType) {
                    $this->img->DashedLineForGrid($x, $yl, $x, $yu, 8, 6);
                }

                ++$i;
            }
        } else {
            throw      Util\JpGraphError::make(25054, $this->scale->type); //('Internal error: Unknown grid axis ['.$this->scale->type.']');
        }

        return true;
    }
}

// @class
