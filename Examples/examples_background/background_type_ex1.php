<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];

// Create the graph. These two calls are always required
$__width  = 350;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMargin(40, 40, 50, 50);

// Setup the grid and plotarea box
$graph->ygrid->SetLineStyle('dashed');
$graph->ygrid->setColor('darkgray');
$graph->SetBox(true);

// Steup graph titles
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 12);
$graph->title->Set('Using background image');
$graph->subtitle->SetFont(FF_COURIER, FS_BOLD, 11);
$graph->subtitle->Set('"BGIMG_CENTER"');
$graph->subtitle->SetColor('darkred');

// Add background with 25% mix
$graph->SetBackgroundImage(__DIR__ . '/../assets/heat1.jpg', BGIMG_CENTER);
$graph->SetBackgroundImageMix(25);

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
