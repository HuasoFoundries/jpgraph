<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

$f = new Util\FuncGenerator('cos($x)*$x');
[$xdata, $ydata] = $f->E(-1.2 * \M_PI, 1.2 * \M_PI);

$f = new Util\FuncGenerator('$x*$x');
[$x2data, $y2data] = $f->E(-2, 2);

// Setup the basic graph
$__width = 450;
$__height = 350;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
//$graph->SetShadow();
$graph->img->SetMargin(5, 10, 60, 9);
$graph->SetBox(true, 'green', 2);
$graph->SetMarginColor('black');
$graph->SetColor('black');

// ... and titles$example_title='Example of Function plot'; $graph->title->set($example_title);
$graph->title->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);
$graph->title->SetColor('lightgreen');
$graph->subtitle->Set("(With some more advanced axis formatting\nHiding first and last label)");
$graph->subtitle->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_NORMAL')
);
$graph->subtitle->SetColor('lightgreen');

$graph->xgrid->Show();
$graph->xgrid->SetColor('darkgreen');
$graph->ygrid->SetColor('darkgreen');

$graph->yaxis->SetPos(0);
$graph->yaxis->SetWeight(2);
$graph->yaxis->HideZeroLabel();
$graph->yaxis->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);
$graph->yaxis->SetColor('green', 'green');
$graph->yaxis->HideTicks(true, true);
$graph->yaxis->HideFirstLastLabel();

$graph->xaxis->SetWeight(2);
$graph->xaxis->HideZeroLabel();
$graph->xaxis->HideFirstLastLabel();
$graph->xaxis->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);
$graph->xaxis->SetColor('green', 'green');

$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->SetColor('yellow');
$lp1->SetWeight(2);

$lp2 = new Plot\LinePlot($y2data, $x2data);
[$xm, $ym] = $lp2->Max();
$lp2->SetColor('blue');
$lp2->SetWeight(2);

$graph->Add($lp1);
$graph->Add($lp2);
$graph->Stroke();
