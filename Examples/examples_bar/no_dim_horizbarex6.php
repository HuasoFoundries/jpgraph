<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;

$datay = [2, 3, 5, 8, 12, 6, 3];
$datax = ['320x240', '640x480', '600x800', '1024x768', '1280x1024(16)', '1280x1024(32)',
    '1600x1200(32)'];

// Size of graph
$__width  = 300;
$__height = 400;

// Set the basic parameters of the graph
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');

// No frame around the image
$graph->SetFrame(false);

// Rotate graph 90 degrees and set margin
$graph->Set90AndMargin(100, 20, 50, 30);

// Set white margin color
$graph->SetMarginColor('white');

// Use a box around the plot area
$graph->SetBox();

// Use a gradient to fill the plot area
$graph->SetBackgroundGradient('white', 'lightblue', Graph\Configs::getConfig('GRAD_HOR'), Graph\Configs::getConfig('BGRAD_PLOT'));

// Setup title$example_title='Graphic card performance'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 11);
$subtitle_text = '(Non optimized)';
$graph->subtitle->Set($subtitle_text);

// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 8);

// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(10);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right', 'center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);

// We don't want to display Y-axis
$graph->yaxis->Hide();

// Now create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetShadow();

//You can change the width of the bars if you like
//$bplot->SetWidth(0.5);

// Set gradient fill for bars
$bplot->SetFillGradient('darkred', 'yellow', Graph\Configs::getConfig('GRAD_HOR'));

// We want to display the value of each bar at the top
$bplot->value->Show();
$bplot->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);
//$bplot->value->SetAlign('left','center');
$bplot->value->SetColor('white');
$bplot->value->SetFormat('%.1f');
$bplot->SetValuePos('max');

// Add the bar to the graph
$graph->Add($bplot);

// Add some explanation text
$txt = new Text\Text('Note: Higher value is better.');
$txt->SetPos(190, 399, 'center', 'bottom');
$txt->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
$graph->Add($txt);

// .. and stroke the graph
$graph->Stroke();
