<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$datay1 = [140, 110, 50, 60];
$datay2 = [35, 90, 190, 190];
$datay3 = [20, 60, 70, 140];

// Create the basic graph
$__width = 450;
$__height = 250;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');
$graph->img->SetMargin(40, 80, 30, 40);

// Adjust the position of the legend box
$graph->legend->Pos(0.02, 0.15);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');

// Get localised version of the month names
$graph->xaxis->SetTickLabels($graph->gDateLocale->GetShortMonth());

// Set a nice summer (in Stockholm) image
$graph->SetBackgroundImage(__DIR__ . '/../assets/stship.jpg', Graph\Configs::getConfig('BGIMG_COPY'));

// Set axis titles and fonts
$graph->xaxis->title->Set('Year 2002');
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetColor('white');

$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->SetColor('white');

$graph->yaxis->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->SetColor('white');

//$graph->ygrid->Show(false);
$graph->ygrid->SetColor('white@0.5');

// Setup graph title
$example_title = 'Using alpha blending with a background';
$graph->title->set($example_title);
// Some extra margin (from the top)
$graph->title->SetMargin(3);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 12);

// Create the three var series we will combine
$bplot1 = new Plot\BarPlot($datay1);
$bplot2 = new Plot\BarPlot($datay2);
$bplot3 = new Plot\BarPlot($datay3);

// Setup the colors with 40% transparency (alpha channel)
$bplot1->SetFillColor('orange@0.4');
$bplot2->SetFillColor('brown@0.4');
$bplot3->SetFillColor('darkgreen@0.4');

// Setup legends
$bplot1->SetLegend('Label 1');
$bplot2->SetLegend('Label 2');
$bplot3->SetLegend('Label 3');

// Setup each bar with a shadow of 50% transparency
$bplot1->SetShadow('black@0.4');
$bplot2->SetShadow('black@0.4');
$bplot3->SetShadow('black@0.4');

$gbarplot = new Plot\GroupBarPlot([$bplot1, $bplot2, $bplot3]);
$gbarplot->SetWidth(0.6);
$graph->Add($gbarplot);

$graph->Stroke();
