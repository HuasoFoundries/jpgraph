<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

define('DATAPERMONTH', 40);
// new Graph\Graph with a drop shadow
$__width  = 400;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
//$graph->SetShadow();

// Some data
$months = [];
$datay  = [];
$m      = $graph->gDateLocale->GetShortMonth();
$k      = 0;
for ($i = 0; $i < 480; ++$i) {
    $datay[$i] = rand(1, 40);
    if ($i % DATAPERMONTH === 0) {
        $months[$i] = $m[(int) ($i / DATAPERMONTH)];
    } else {
        $months[$i] = 'xx';
    }
}

// Use a "text" X-scale
$graph->SetScale('textlin');

// Specify X-labels
$graph->xaxis->SetTickLabels($months);
$graph->xaxis->SetTextTickInterval(DATAPERMONTH, 0);
$graph->xaxis->SetTextLabelInterval(2);

// Set title and subtitle
$graph->title->Set('Textscale with tickinterval=2');

// Use built in font
$graph->title->SetFont(FF_FONT1, FS_BOLD);

$graph->SetBox(true, 'red');

// Create the bar plot
$lp1 = new Plot\LinePlot($datay);
$lp1->SetLegend('Temperature');

// The order the plots are added determines who's ontop
$graph->Add($lp1);

// Finally output the  image
$graph->Stroke();
