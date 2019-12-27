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

define('NDATAPOINTS', 280);
define('SAMPLERATE', 300);

$start = time();
$end   = $start + Graph\Configs::getConfig('NDATAPOINTS') * Graph\Configs::getConfig('SAMPLERATE');
$xdata = [];

$data_winddirection[0] = rand(100, 200);
$data_windspeed[0]     = rand(7, 10);
$data_windtemp[0]      = rand(5, 20);

for ($i = 0; $i < Graph\Configs::getConfig('NDATAPOINTS') - 1; ++$i) {
    $data_winddirection[$i + 1] = $data_winddirection[$i] + rand(-4, 4);
    if ($data_winddirection[$i + 1] < 0 || $data_winddirection[$i + 1] > 359) {
        $data_winddirection[$i + 1] = 0;
    }

    $data_windspeed[$i + 1] = $data_windspeed[$i] + rand(-2, 2);
    if ($data_windspeed[$i + 1] < 0) {
        $data_windspeed[$i + 1] = 0;
    }

    $data_windtemp[$i + 1] = $data_windtemp[$i] + rand(-1.5, 1.5);

    $xdata[$i] = $start + $i * Graph\Configs::getConfig('SAMPLERATE');
}
$xdata[$i] = $start + $i * Graph\Configs::getConfig('SAMPLERATE');

//DEFINE('BKG_COLOR','lightgray:1.7');
define('BKG_COLOR', 'green:1.98');
define('WIND_HEIGHT', 800);
define('WIND_WIDTH', 250);

//------------------------------------------------------------------
// Setup the Wind direction graph
//------------------------------------------------------------------
$graph = new Graph\Graph(Graph\Configs::getConfig('WIND_WIDTH'), Graph\Configs::getConfig('WIND_HEIGHT'));
$graph->SetMarginColor(Graph\Configs::getConfig('BKG_COLOR'));
$graph->SetScale('datlin', 0, 360);
$graph->Set90AndMargin(50, 10, 70, 30);
$graph->SetFrame(true, 'white', 0);
$graph->SetBox();
$example_title = 'Wind direction';
$graph->title->set($example_title);
$graph->title->SetColor('blue');
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$graph->title->SetMargin(5);

$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$graph->xaxis->scale->SetDateFormat('H:i');
$graph->xgrid->Show();

$graph->yaxis->SetLabelAngle(90);
$graph->yaxis->SetColor('blue');
$graph->yaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$graph->yaxis->SetLabelMargin(0);
$graph->yaxis->scale->SetAutoMin(0);

$line = new Plot\LinePlot($data_winddirection, $xdata);
$line->SetStepStyle();
$line->SetColor('blue');

$graph->Add($line);

//------------------------------------------------------------------
// Setup the wind speed graph
//------------------------------------------------------------------
$graph2 = new Graph\Graph(Graph\Configs::getConfig('WIND_WIDTH') - 30, Graph\Configs::getConfig('WIND_HEIGHT'));
$graph2->SetScale('datlin');
$graph2->Set90AndMargin(5, 20, 70, 30);
$graph2->SetMarginColor(Graph\Configs::getConfig('BKG_COLOR'));
$graph2->SetFrame(true, 'white', 0);
$graph2->SetBox();
$example_title = 'Windspeed';
$graph2->title->set($example_title);
$graph2->title->SetColor('red');
$graph2->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$graph2->title->SetMargin(5);

$graph2->xaxis->HideLabels();
$graph2->xgrid->Show();

$graph2->yaxis->SetLabelAngle(90);
$graph2->yaxis->SetColor('red');
$graph2->yaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$graph2->yaxis->SetLabelMargin(0);
$graph2->yaxis->scale->SetAutoMin(0);

$line2 = new Plot\LinePlot($data_windspeed, $xdata);
$line2->SetStepStyle();
$line2->SetColor('red');

$graph2->Add($line2);

//------------------------------------------------------------------
// Setup the wind temp graph
//------------------------------------------------------------------
$graph3 = new Graph\Graph(Graph\Configs::getConfig('WIND_WIDTH') - 30, Graph\Configs::getConfig('WIND_HEIGHT'));
$graph3->SetScale('datlin');
$graph3->Set90AndMargin(5, 20, 70, 30);
$graph3->SetMarginColor(Graph\Configs::getConfig('BKG_COLOR'));
$graph3->SetFrame(true, 'white', 0);
$graph3->SetBox();
$example_title = 'Temperature';
$graph3->title->set($example_title);
$graph3->title->SetColor('black');
$graph3->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$graph3->title->SetMargin(5);

$graph3->xaxis->HideLabels();
$graph3->xgrid->Show();

$graph3->yaxis->SetLabelAngle(90);
$graph3->yaxis->SetColor('black');
$graph3->yaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$graph3->yaxis->SetLabelMargin(0);
$graph3->yaxis->scale->SetAutoMin(-10);

$line3 = new Plot\LinePlot($data_windtemp, $xdata);
$line3->SetStepStyle();
$line3->SetColor('black');

$graph3->Add($line3);

//-----------------------
// Create a multigraph
//----------------------
$mgraph = new MGraph();
$mgraph->SetMargin(2, 2, 2, 2);
$mgraph->SetFrame(true, 'darkgray', 2);
$mgraph->SetFillColor(Graph\Configs::getConfig('BKG_COLOR'));
$mgraph->Add($graph, 0, 50);
$mgraph->Add($graph2, 250, 50);
$mgraph->Add($graph3, 460, 50);
$example_title = 'Climate diagram 12 March 2009';
$mgraph->title->set($example_title);
$mgraph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 20);
$mgraph->title->SetMargin(8);
$mgraph->Stroke();
