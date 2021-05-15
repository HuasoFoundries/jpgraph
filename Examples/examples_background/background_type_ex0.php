<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// [\(\s]([A-Z]{2}[A-Z_0-9]{2,100})
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
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$example_title = 'Using background image';
$example_title = $example_title;
$graph->title->set($example_title);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_COURIER'), Graph\Configs::getConfig('FS_BOLD'), 11);
$subtitle_text = 'BGIMG_COPY';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetColor('darkred');

// Add background with 25% mix
$graph->SetBackgroundImage(__DIR__ . '/../assets/heat1.jpg', Graph\Configs::getConfig('BGIMG_COPY'));
$graph->SetBackgroundImageMix(25);

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
