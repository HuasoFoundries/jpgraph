<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
define('DEBUGMODE', true);
ini_set('display_errors', (int) DEBUGMODE);
ini_set('display_startup_errors', (int) DEBUGMODE);
if (DEBUGMODE) {
    error_reporting(E_ALL);
}

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;

$datay = [12, 26, 9, 17, 31];

// Create the graph.
$__width  = 400;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMargin(50, 80, 20, 40);
$graph->yaxis->SetTitleMargin(30);
$graph->yaxis->scale->SetGrace(30);
$graph->SetShadow();

// Create a bar pot
$bplot = new Plot\BarPlot($datay);

// Create targets for the bars image maps. One for each column
$targ = ['bar_csimex1.php#1', 'bar_csimex1.php#2', 'bar_csimex1.php#3', 'bar_csimex1.php#4', 'bar_csimex1.php#5', 'bar_csimex1.php#6'];
$alts = ['val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d', 'val=%d'];
$bplot->SetCSIMTargets($targ, $alts);
$bplot->SetFillColor('orange');
$bplot->SetLegend('Year 2001 %%', '#kalle ', '%s');

// Display the values on top of each bar
$bplot->SetShadow();
$bplot->value->SetFormat(' $ %2.1f', 70);
$bplot->value->SetFont(FF_ARIAL, FS_NORMAL, 9);
$bplot->value->SetColor('blue');
$bplot->value->Show();

$graph->Add($bplot);

// Create a big "button" that has an image map action
$txt1 = new Text\Text("A simple text with\ntwo rows");
$txt1->SetFont(FF_ARIAL);
$txt1->SetBox('lightblue', 'black', 'white@1', 5);
$txt1->SetParagraphAlign('center');
$txt1->SetPos(40, 50);
$txt1->SetCSIMTarget('#88', 'Text element');
$graph->Add($txt1);

// Add image map to the graph title as well (you can do this to the
// sub- and subsub-title as well)
$graph->title->Set('Image maps barex1');
$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->title->SetCSIMTarget('#45', 'Title for Bar');
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

// Setup the axis title image map and font style
$graph->yaxis->title->SetFont(FF_FONT2, FS_BOLD);
$graph->yaxis->title->SetCSIMTarget('#55', 'Y-axis title');
$graph->xaxis->title->SetFont(FF_FONT2, FS_BOLD);
$graph->xaxis->title->SetCSIMTarget('#55', 'X-axis title');

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM();
