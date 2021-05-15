<?php

/**
 * JPGraph v4.1.0-beta.01
 */

//
// Example of frequence bar
//
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Utility function to calculate the accumulated frequence
// for a set of values and ocurrences
function accfreq($data)
{
    rsort($data);
    $s   = array_sum($data);
    $as  = [$data[0]];
    $asp = [100 * $as[0] / $s];
    $n   = count($data);
    for ($i = 1; $i < $n; ++$i) {
        $as[$i]  = $as[$i - 1] + $data[$i];
        $asp[$i] = 100.0 * $as[$i] / $s;
    }

    return $asp;
}

// some data
$data_freq    = [22, 20, 12, 10, 5, 4, 2];
$data_accfreq = accfreq($data_freq);

// Create the graph.
$__width  = 350;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);

// Setup some basic graph parameters
$graph->SetScale('textlin');
$graph->SetY2Scale('lin', 0, 100);
$graph->img->SetMargin(50, 70, 30, 40);
$graph->yaxis->SetTitleMargin(30);
$graph->SetMarginColor('#EEEEEE');

// Setup titles and fonts$example_title='Frequence plot'; $graph->title->set($example_title);
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Turn the tickmarks
$graph->xaxis->SetTickSide(Graph\Configs::getConfig('SIDE_DOWN'));
$graph->yaxis->SetTickSide(Graph\Configs::getConfig('SIDE_LEFT'));

$graph->y2axis->SetTickSide(Graph\Configs::getConfig('SIDE_RIGHT'));
$graph->y2axis->SetColor('black', 'blue');
$graph->y2axis->SetLabelFormat('%3d.0%%');

// Create a bar pot
$bplot = new Plot\BarPlot($data_freq);

// Create accumulative graph
$lplot = new Plot\LinePlot($data_accfreq);

// We want the line plot data point in the middle of the bars
$lplot->SetBarCenter();

// Use transperancy
$lplot->SetFillColor('lightblue@0.6');
$lplot->SetColor('blue@0.6');
$graph->AddY2($lplot);

// Setup the bars
$bplot->SetFillColor('orange@0.2');
$bplot->SetValuePos('center');
$bplot->value->SetFormat('%d');
$bplot->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 9);
$bplot->value->Show();

// Add it to the graph
$graph->Add($bplot);

// Send back the Graph\Configs::getConfig('HTML') page which will call this script again
// to retrieve the image.
$graph->Stroke();
