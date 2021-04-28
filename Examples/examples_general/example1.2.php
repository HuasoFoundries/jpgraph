<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];

// Create the graph. These two calls are always required
$__width = 350;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->img->SetMargin(30, 90, 40, 50);
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$example_title = 'Dashed lineplot';
$graph->title->set($example_title);

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetLegend('Test 1');
$lineplot->SetColor('blue');

// Style can also be specified as SetStyle([1|2|3|4]) or
// SetStyle("solid"|"dotted"|"dashed"|"lobgdashed")
$lineplot->SetStyle('dashed');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
