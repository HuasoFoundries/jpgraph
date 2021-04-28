<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// create the graph
$__width = 400;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);

$ydata = [5, 10, 15, 20, 15, 10];

$graph->SetScale('textlin');
$graph->SetShadow(true);
$graph->SetMarginColor('antiquewhite');
$graph->img->SetMargin(60, 40, 40, 50);
$graph->img->setTransparent('white');
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_FONT1'));
$graph->xaxis->setTextTickInterval(1);
$graph->xaxis->SetTextLabelInterval(1);
$graph->legend->SetFillColor('antiquewhite');
$graph->legend->SetShadow(true);
$graph->legend->SetLayout(Graph\Configs::getConfig('LEGEND_VERT'));
$graph->legend->Pos(0.02, 0.01);
$example_title = 'Step Styled Example';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetColor('black');
$lineplot->setFillColor('gray7');
$lineplot->SetStepStyle();
$lineplot->SetLegend(' 2002 ');

// add plot to the graph
$graph->Add($lineplot);
$graph->ygrid->show(false, false);

// display graph
$graph->Stroke();
