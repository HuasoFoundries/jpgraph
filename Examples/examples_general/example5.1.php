<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];
$y2data = [354, 200, 265, 99, 111, 91, 198, 225, 293, 251];

// Create the graph. These two calls are always required
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(40, 40, 20, 40);
$graph->SetScale('textlin');
$graph->SetY2Scale('lin');
$graph->SetShadow();

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot2 = new Plot\LinePlot($y2data);

// Add the plot to the graph
$graph->Add($lineplot);
$graph->AddY2($lineplot2);
$lineplot2->SetColor('orange');
$lineplot2->SetWeight(2);
$graph->y2axis->SetColor('orange');
$example_title = 'Example 5';
$graph->title->set($example_title);
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);
$graph->yaxis->title->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);
$graph->xaxis->title->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);

$lineplot->SetColor('blue');
$lineplot->SetWeight(2);

$lineplot2->SetColor('orange');
$lineplot2->SetWeight(2);

$graph->yaxis->SetColor('blue');

$lineplot->SetLegend('Plot 1');
$lineplot2->SetLegend('Plot 2');

// Display the graph
$graph->Stroke();
