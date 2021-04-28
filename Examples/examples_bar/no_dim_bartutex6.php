<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// new Graph\Graph with a drop shadow
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetShadow();

// Some data
$databary = [];
$databarx = [];
$months = $graph->gDateLocale->GetShortMonth();
\mt_srand((float) \microtime() * 1000000);

for ($i = 0; 25 > $i; ++$i) {
    $databary[] = \mt_rand(1, 50);
    $databarx[] = $months[$i % 12];
}
// Use a text X-scale
$graph->SetScale('textlin');

// Specify X-labels
$graph->xaxis->SetTickLabels($databarx);
$graph->xaxis->SetTextLabelInterval(3);

// Hide the tick marks
$graph->xaxis->HideTicks();

// Set title and subtitle
$example_title = 'Bar tutorial example 6';
$graph->title->set($example_title);

// Use built in font
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Create the bar plot
$b1 = new Plot\BarPlot($databary);
$b1->SetLegend('Temperature');
$b1->SetWidth(0.4);

// The order the plots are added determines who's ontop
$graph->Add($b1);

// Finally output the  image
$graph->Stroke();
