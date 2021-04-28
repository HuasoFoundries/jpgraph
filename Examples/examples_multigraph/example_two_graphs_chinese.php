<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;

$data = [40, 60, 21, 33];

$__width = 300;
$__height = 250;

$data = [0.1235, 0.4567, 0.67, 0.45, 0.832];

$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$example_title1 = '中示例能有对应的';
$graph->title->set($example_title1);
$SIMSUN_PATH = __DIR__ . '/../../src/fonts/simsun.ttc';
$graph->SetUserFont1($SIMSUN_PATH);

$graph->title->SetFont(
    Text\Configs::FF_USERFONT1, //FF_SIMSUN,
    Text\Configs::FS_NORMAL,
    14
);

// Create a bar plots
$bar1 = new Plot\BarPlot($data);

// Setup the callback function
$bar1->value->Show();

// Add the plot to the graph
$graph->Add($bar1);

/**
 * Add second graph, pie plot.
 *
 * @var array
 */
$data2 = [60, 30, 11, 53];

$graph2 = new Graph\PieGraph($__width, $__height);
$graph2->SetShadow();
$example_title2 = '中文翻译或图片就好了';
$graph2->title->set($example_title2);

$graph2->title->SetFont(
    Text\Configs::FF_CHINESE,
    Text\Configs::FS_NORMAL,
    14
);

$p2 = new Plot\PiePlot($data2);
$graph2->Add($p2);

/**
 * Adds a third graph (Impulse plot, scatter).
 *
 * @var Graph
 */
$datay = [20, 22, 12, 13, 17, 20, 16, 19, 30, 31, 40, 43];

$graph3 = new Graph\Graph($__width, $__height);
$graph3->SetScale('textlin');

$graph3->SetShadow();
$graph3->img->SetMargin(40, 40, 40, 40);
$example_title3 = '中示例能有对应的';
$graph3->title->set($example_title3);

$graph3->title->SetFont(
    Text\Configs::FF_SIMSUN, //FF_SIMSUN,
    Text\Configs::FS_NORMAL,
    14
);

$sp1 = new Plot\ScatterPlot($datay);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));
$sp1->SetImpuls();

$graph3->Add($sp1);

//-----------------------
// Create a multigraph
//----------------------
$mgraph = new Graph\MGraph();
$mgraph->SetMargin(2, 2, 2, 2);
$mgraph->SetFrame(true, 'darkgray', 2);
$mgraph->SetFillColor('lightgray');
$mgraph->Add($graph);
$mgraph->Add($graph2, 300, 0);
$mgraph->Add($graph3, 0, 250);

$mgraph->Stroke();
