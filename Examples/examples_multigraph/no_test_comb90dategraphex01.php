<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

require_once 'jpgraph/jpgraph_date.php';
require_once 'jpgraph/jpgraph_mgraph.php';

// Setup some fake data to simulate some wind speed and direction

define('NDATAPOINTS', 420);
define('SAMPLERATE', 300);
$start                 = time();
$end                   = $start + NDATAPOINTS * SAMPLERATE;
$data                  = [];
$xdata                 = [];
$data_winddirection[0] = rand(100, 200);
$data_windspeed[0]     = rand(7, 10);
for ($i = 0; $i < NDATAPOINTS - 1; ++$i) {
    $data_winddirection[$i + 1] = $data_winddirection[$i] + rand(-4, 4);
    if ($data_winddirection[$i + 1] < 0 || $data_winddirection[$i + 1] > 359) {
        $data_winddirection[$i + 1] = 0;
    }

    $data_windspeed[$i + 1] = $data_windspeed[$i] + rand(-2, 2);
    if ($data_windspeed[$i + 1] < 0) {
        $data_windspeed[$i + 1] = 0;
    }

    $xdata[$i] = $start + $i * SAMPLERATE;
}
$xdata[$i] = $start + $i * SAMPLERATE;

// Setup the Wind direction graph
$__width  = 300;
$__height = 800;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetMarginColor('lightgray:1.7');
$graph->SetScale('datlin', 0, 360);
$graph->Set90AndMargin(50, 30, 60, 30);
$graph->SetFrame(true, 'white', 0);
$graph->SetBox();

$graph->title->Set('Wind direction');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph->title->SetMargin(10);

$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);
$graph->xaxis->scale->SetDateFormat('h:i');
$graph->xgrid->Show();

$graph->yaxis->SetLabelAngle(45);
$graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);
$graph->yaxis->SetLabelMargin(0);
$graph->yaxis->scale->SetAutoMin(0);

$line = new Plot\LinePlot($data_winddirection, $xdata);
$line->SetStepStyle();
$line->SetColor('blue');

$graph->Add($line);

// Setup the wind speed graph
$__width  = 300;
$__height = 800;
$graph2   = new Graph\Graph($__width, $__height);
$graph2->SetScale('datlin');
$graph2->Set90AndMargin(50, 30, 60, 30);
$graph2->SetMarginColor('lightgray:1.7');
$graph2->SetFrame(true, 'white', 0);
$graph2->SetBox();

$graph2->title->Set('Windspeed');
$graph2->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph2->title->SetMargin(10);

$graph2->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);
$graph2->xaxis->scale->SetDateFormat('h:i');
$graph2->xgrid->Show();

$graph2->yaxis->SetLabelAngle(45);
$graph2->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);
$graph2->yaxis->SetLabelMargin(0);
$graph2->yaxis->scale->SetAutoMin(0);

$line2 = new Plot\LinePlot($data_windspeed, $xdata);
$line2->SetStepStyle();
$line2->SetColor('red');

$graph2->Add($line2);

//-----------------------
// Create a multigraph
//----------------------
$mgraph = new MGraph();
$mgraph->SetMargin(2, 2, 2, 2);
$mgraph->SetFrame(true, 'darkgray', 2);
$mgraph->SetFillColor('lightgray');
$mgraph->Add($graph);
$mgraph->Add($graph2, 300, 0);
$mgraph->Stroke();
