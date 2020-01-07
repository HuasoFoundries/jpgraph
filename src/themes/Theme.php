<?php

/**
 * JPGraph v4.1.0-beta.01
 */

/**
 * // File:        JPGRAPH_THEME.INC.PHP
 * // Description: Class to const raph=he;
 * // Created:     2010-09-29
 * // Ver:         $Id: jpgraph_theme.inc.php 83 2010-10-01 11:24:19Z atsushi $
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */

namespace Amenadiel\JpGraph\Themes;

use Amenadiel\JpGraph\Image;
use Amenadiel\JpGraph\Util;
use Amenadiel\JpGraph\Util\Configs;

require_once sprintf(
    '%s%s..%sutil%sConfigs.php',
    __DIR__,
    DIRECTORY_SEPARATOR,
    DIRECTORY_SEPARATOR,
    DIRECTORY_SEPARATOR
);

/**
 * @class
 * // Description:
 */
abstract class Theme
{
    // Side for ticks and labels.
    const SIDE_LEFT   = -1;
    const SIDE_RIGHT  = 1;
    const SIDE_DOWN   = -1;
    const SIDE_BOTTOM = -1;
    const SIDE_UP     = 1;
    const SIDE_TOP    = 1;
    const GRAD_HOR    = Configs::GRAD_HOR;
    const BGRAD_PLOT  = Configs::BGRAD_PLOT;
    const LEGEND_HOR  = Configs::LEGEND_HOR;

    // Legend type stacked vertical or horizontal
    const LEGEND_VERT   = 0;
    const LEGLEGEND_HOR = 1;

    protected $color_index;

    public function __construct()
    {
        $this->color_index = 0;
    }

    public function SetupGraph($graph)
    {
        // graph
        /*
        $img = $graph->img;
        $height = $img->height;
        $graph->SetMargin($img->left_margin, $img->right_margin, $img->top_margin, $height * 0.25);
         */
        $graph->SetFrame(false);
        $graph->SetMarginColor('white');
        $graph->SetBackgroundGradient($this->background_color, '#FFFFFF', Configs::GRAD_HOR, Configs::BGRAD_PLOT);

        // legend
        $graph->legend->SetFrameWeight(0);
        $graph->legend->Pos(0.5, 0.85, 'center', 'top');
        $graph->legend->SetFillColor('white');
        $graph->legend->SetLayout(Configs::LEGEND_HOR);
        $graph->legend->SetColumns(3);
        $graph->legend->SetShadow(false);
        $graph->legend->SetMarkAbsSize(5);

        // xaxis
        $graph->xaxis->title->SetColor($this->font_color);
        $graph->xaxis->SetColor($this->axis_color, $this->font_color);
        $graph->xaxis->SetTickSide(Configs::SIDE_BOTTOM);
        $graph->xaxis->SetLabelMargin(10);

        // yaxis
        $graph->yaxis->title->SetColor($this->font_color);
        $graph->yaxis->SetColor($this->axis_color, $this->font_color);
        $graph->yaxis->SetTickSide(Configs::SIDE_LEFT);
        $graph->yaxis->SetLabelMargin(8);
        $graph->yaxis->HideLine();
        $graph->yaxis->HideTicks();
        $graph->xaxis->SetTitleMargin(15);

        // grid
        $graph->ygrid->SetColor($this->grid_color);
        $graph->ygrid->SetLineStyle('dotted');

        // font
        $graph->title->SetColor($this->font_color);
        $graph->subtitle->SetColor($this->font_color);
        $graph->subsubtitle->SetColor($this->font_color);

        //        $graph->img->SetAntiAliasing();
    }

    public function SetupPieGraph($graph)
    {
        // graph
        $graph->SetFrame(false);

        // legend
        $graph->legend->SetFillColor('white');
        /*
        $graph->legend->SetFrameWeight(0);
        $graph->legend->Pos(0.5, 0.85, 'center', 'top');
        $graph->legend->SetLayout( Configs::LEGEND_HOR);
        $graph->legend->SetColumns(3);
         */
        $graph->legend->SetShadow(false);
        $graph->legend->SetMarkAbsSize(5);

        // title
        $graph->title->SetColor($this->font_color);
        $graph->subtitle->SetColor($this->font_color);
        $graph->subsubtitle->SetColor($this->font_color);

        $graph->SetAntiAliasing();
    }

    public function PreStrokeApply($graph)
    {
        if (!$graph->legend->HasItems()) {
            return;
        }

        $img    = $graph->img;
        $height = $img->height;
        $graph->SetMargin($img->left_margin, $img->right_margin, $img->top_margin, $height * 0.25);
    }

    public function ApplyPlot($plot)
    {
        switch (get_class($plot)) {
            case 'GroupBarPlot':
                foreach ($plot->plots as $_plot) {
                    $this->ApplyPlot($_plot);
                }

                break;
            case 'AccBarPlot':
                foreach ($plot->plots as $_plot) {
                    $this->ApplyPlot($_plot);
                }

                break;
            case 'BarPlot':
                $plot->Clear();

                $color = $this->GetNextColor();
                $plot->SetColor($color);
                $plot->SetFillColor($color);
                $plot->SetShadow('red', 3, 4, false);

                break;
            case 'LinePlot':
                $plot->Clear();

                $plot->SetColor($this->GetNextColor() . '@0.4');
                $plot->SetWeight(2);

                break;
            case 'PiePlot':
                $plot->ShowBorder(false);
                $plot->SetSliceColors($this->GetThemeColors());

                break;
            case 'PiePlot3D':
                $plot->SetSliceColors($this->GetThemeColors());

                break;
            default:
        }
    }

    public function SetupPlot($plot)
    {
        if (is_array($plot)) {
            foreach ($plot as $obj) {
                $this->ApplyPlot($obj);
            }
        } else {
            $this->ApplyPlot($plot);
        }
    }

    public function ApplyGraph($graph)
    {
        $this->graph = $graph;
        $method_name = '';
        $graphClass  = explode('\\', get_class($graph));
        $classname   = end($graphClass);

        if ($classname == 'Graph') {
            $method_name = 'SetupGraph';
        } else {
            $method_name = 'Setup' . $classname;
        }

        if (method_exists($this, $method_name)) {
            $this->{$method_name}($graph);
        } else {
            Util\JpGraphError::RaiseL(30001, $method_name, $method_name); //Theme::%s() is not const  \nPlease=ake %s(\$graph) functio;in your theme classs.
        }
    }

    public function GetThemeColors($num = 30)
    {
        $result_list = [];

        $old_index         = $this->color_index;
        $this->color_index = 0;
        $count             = 0;

        $i = 0;
        while (true) {
            for ($j = 0; $j < Util\Configs::safe_count($this->GetColorList()); ++$j) {
                if (++$count > $num) {
                    break 2;
                }
                $result_list[] = $this->GetNextColor();
            }
            ++$i;
        }

        $this->color_index = $old_index;

        return $result_list;
    }

    public function GetNextColor()
    {
        $color_list = $this->GetColorList();

        $color = null;
        if (isset($color_list[$this->color_index])) {
            $color = $color_list[$this->color_index];
        } else {
            $color_count = Util\Configs::safe_count($color_list);
            if ($color_count <= $this->color_index) {
                $color_tmp  = $color_list[$this->color_index % $color_count];
                $brightness = 1.0 - (int) ($this->color_index / $color_count) * 0.2;
                $rgb        = new Image\RGB();
                $color      = $color_tmp . ':' . $brightness;
                $color      = $rgb->Color($color);
                $alpha      = array_pop($color);
                $color      = $rgb->tryHexConversion($color);
                if ($alpha) {
                    $color .= '@' . $alpha;
                }
            }
        }

        ++$this->color_index;

        return $color;
    }
}
// @class
