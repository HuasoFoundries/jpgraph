<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_radar.php';

// Create the basic radar graph
$__width  = 300;
$__height = 200;
$graph    = new RadarGraph($__width, $__height);
$graph->img->SetAntiAliasing();

// Set background color and shadow
$graph->SetColor('white');
$graph->SetShadow();

// Position the graph
$graph->SetCenter(0.4, 0.55);

// Setup the axis formatting
$graph->axis->SetFont(FF_FONT1, FS_BOLD);

// Setup the grid lines
$graph->grid->SetLineStyle('solid');
$graph->grid->SetColor('navy');
$graph->grid->Show();
$graph->HideTickMarks();

// Setup graph titles
$graph->title->Set('Quality result');
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$graph->SetTitles($graph->gDateLocale->GetShortMonth());

// Create the first radar plot
$plot = new RadarPlot([70, 80, 60, 90, 71, 81, 47]);
$plot->SetLegend('Goal');
$plot->SetColor('red', 'lightred');
$plot->SetFill(false);
$plot->SetLineWeight(2);

// Create the second radar plot
$plot2 = new RadarPlot([70, 40, 30, 80, 31, 51, 14]);
$plot2->SetLegend('Actual');
$plot2->SetLineWeight(2);
$plot2->SetColor('blue');
$plot2->SetFill(false);

// Add the plots to the graph
$graph->Add($plot2);
$graph->Add($plot);

// And output the graph
$graph->Stroke();
