<?php

/**
 *  Graph\Configs::getConfig('JPG')raph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$datay = [25, 29, 29, 39, 55];

$__width  = 400;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height, 'auto');
$graph->img->SetMargin(40, 40, 40, 20);

$graph->SetScale('linlin');
$graph->SetShadow();
$example_title = 'Top X-axis';
$example_title = $example_title;
$graph->title->set($example_title);

// Start at 0
$graph->yscale->SetAutoMin(0);

// Add some air around the Y-scale
$graph->yscale->SetGrace(100);

// Use built in font
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Adjust the X-axis
$graph->xaxis->SetPos('max');
$graph->xaxis->SetLabelSide(Graph\Configs::getConfig('SIDE_UP'));
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));

// Create the line plot
$p1 = new Plot\LinePlot($datay);
$p1->SetColor('blue');

// Specify marks for the line plots
$p1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$p1->mark->SetFillColor('red');
$p1->mark->SetWidth(4);

// Show values
$p1->value->Show();

// Add lineplot to graph
$graph->Add($p1);

// Output line
$graph->Stroke();
