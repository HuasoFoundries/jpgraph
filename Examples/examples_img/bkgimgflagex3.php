<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$datay1 = [140, 110, 50];
$datay2 = [35, 90, 190];
$datay3 = [20, 60, 70];

// Create the basic graph
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMargin(40, 20, 20, 40);
$graph->SetMarginColor('white:0.9');
$graph->SetColor('white');
$graph->SetShadow();

// Apply a perspective transformation at the end
$graph->Set3DPerspective(Graph\Configs::getConfig('SKEW3D_DOWN'), 100, 180);

// Adjust the position of the legend box
$graph->legend->Pos(0.03, 0.10);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.1');
$graph->legend->Hide();

// Get localised version of the month names
$graph->xaxis->SetTickLabels($graph->gDateLocale->GetShortMonth());

$graph->SetBackgroundCountryFlag('mais', Graph\Configs::getConfig('BGIMG_COPY'), 50);

// Set axis titles and fonts
$graph->xaxis->title->Set('Year 2002');
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetColor('white');

$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->SetColor('navy');

$graph->yaxis->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->SetColor('navy');

//$graph->ygrid->Show(false);
$graph->ygrid->SetColor('white@0.5');

// Setup graph title
$example_title = 'Using a country flag background SKEW3D_DOWN';
$graph->title->set($example_title);

// Some extra margin (from the top)
$graph->title->SetMargin(3);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 12);

// Create the three var series we will combine
$bplot1 = new Plot\BarPlot($datay1);
$bplot2 = new Plot\BarPlot($datay2);
$bplot3 = new Plot\BarPlot($datay3);

// Setup the colors with 40% transparency (alpha channel)
$bplot1->SetFillColor('yellow@0.4');
$bplot2->SetFillColor('red@0.4');
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
