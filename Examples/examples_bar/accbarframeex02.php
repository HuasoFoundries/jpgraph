<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [13, 8, 19, 7, 17, 6];
$datay2 = [4, 5, 2, 7, 5, 25];

// Create the graph.
$__width = 350;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMarginColor('white');

// Setup title
$example_title = 'Acc bar with gradient';
$graph->title->set($example_title);

// Create the first bar
$bplot = new Plot\BarPlot($datay1);
$bplot->SetFillGradient('AntiqueWhite2', 'AntiqueWhite4:0.8', Graph\Configs::getConfig('GRAD_VERT'));
$bplot->SetColor('darkred');

// Create the second bar
$bplot2 = new Plot\BarPlot($datay2);
$bplot2->SetFillGradient('olivedrab1', 'olivedrab4', Graph\Configs::getConfig('GRAD_VERT'));
$bplot2->SetColor('darkgreen');

// And join them in an accumulated bar
$accbplot = new Plot\AccBarPlot([$bplot, $bplot2]);
$accbplot->SetColor('red');
$accbplot->SetWeight(1);
$graph->Add($accbplot);

$graph->Stroke();
