<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

/*
 * File:        JPGRAPH_RADAR.PHP
 * // Description: Radar plot extension for JpGraph
 * // Created:     2001-02-04
 * // Ver:         $Id: jpgraph_radar.php 1783 2009-08-25 11:41:01Z ljp $
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */

/**
 * @class RadarGrid
 * // Description: Draws grid for the radar graph
 */
class RadarGrid
{
    //extends Grid {
    private $type = 'solid';

    private $grid_color = '#DDDDDD';

    private $show = false;

    private $weight = 1;

    public function __construct()
    {
        // Empty
    }

    public function SetColor($aMajColor)
    {
        $this->grid_color = $aMajColor;
    }

    public function SetWeight($aWeight)
    {
        $this->weight = $aWeight;
    }

    // Specify if grid should be dashed, dotted or solid
    public function SetLineStyle($aType)
    {
        $this->type = $aType;
    }

    // Decide if both major and minor grid should be displayed
    public function Show($aShowMajor = true)
    {
        $this->show = $aShowMajor;
    }

    public function Stroke($img, $grid)
    {
        if (!$this->show) {
            return;
        }

        $nbrticks = Configs::safe_count($grid[0]) / 2;
        $nbrpnts = Configs::safe_count($grid);
        $img->SetColor($this->grid_color);
        $img->SetLineWeight($this->weight);

        for ($i = 0; $i < $nbrticks; ++$i) {
            for ($j = 0; $j < $nbrpnts; ++$j) {
                $pnts[$j * 2] = $grid[$j][$i * 2];
                $pnts[$j * 2 + 1] = $grid[$j][$i * 2 + 1];
            }

            for ($k = 0; $k < $nbrpnts; ++$k) {
                $l = ($k + 1) % $nbrpnts;

                if ('solid' === $this->type) {
                    $img->Line($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1]);
                } elseif ('dotted' === $this->type) {
                    $img->DashedLine($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1], 1, 6);
                } elseif ('dashed' === $this->type) {
                    $img->DashedLine($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1], 2, 4);
                } elseif ('longdashed' === $this->type) {
                    $img->DashedLine($pnts[$k * 2], $pnts[$k * 2 + 1], $pnts[$l * 2], $pnts[$l * 2 + 1], 8, 6);
                }
            }
            $pnts = [];
        }
    }
}
