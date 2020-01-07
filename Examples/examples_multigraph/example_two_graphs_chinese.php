<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33];

$__width  = 300;
$__height = 250;

$data = [0.1235, 0.4567, 0.67, 0.45, 0.832];

// Callback function
// Get called with the actual value and should return the
// value to be displayed as a string
function cbFmtPercentage($aVal)
{
    return sprintf('%.1f%%', 100 * $aVal); // Convert to string
}

$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$example_title1 = '中示例能有对应的';
$graph->title->set($example_title1);

$graph->title->SetFont(
    Graph\Configs::FF_SIMSUN,
    Graph\Configs::FS_NORMAL,
    14
);

// Create a bar plots
$bar1 = new Plot\BarPlot($data);

// Setup the callback function
$bar1->value->SetFormatCallback('cbFmtPercentage');
$bar1->value->Show();

// Add the plot to the graph
$graph->Add($bar1);

$data2 = [60, 30, 11, 53];

$graph2 = new Graph\PieGraph($__width, $__height);
$graph2->SetShadow();
$example_title2 = '中文翻译或图片就好了';
$graph2->title->set($example_title2);

$graph2->title->SetFont(
    Graph\Configs::FF_CHINESE,
    Graph\Configs::FS_NORMAL,
    14
);

$p2 = new Plot\PiePlot($data2);
$graph2->Add($p2);

//-----------------------
// Create a multigraph
//----------------------
$mgraph = new Graph\MGraph();
$mgraph->SetMargin(2, 2, 2, 2);
$mgraph->SetFrame(true, 'darkgray', 2);
$mgraph->SetFillColor('lightgray');
$mgraph->Add($graph);
$mgraph->Add($graph2, 300, 0);

$mgraph->Stroke();
