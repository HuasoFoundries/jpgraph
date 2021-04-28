<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

\define('DATAPERMONTH', 40);
// new Graph\Graph with a drop shadow
$__width = 400;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
//$graph->SetShadow();

// Some data
$months = [];
$datay = [];
$m = $graph->gDateLocale->GetShortMonth();
$k = 0;

for ($i = 0; 480 > $i; ++$i) {
    $datay[$i] = \mt_rand(1, 40);

    if ($i % Graph\Configs::getConfig('DATAPERMONTH') === 0) {
        $months[$i] = $m[(int) ($i / Graph\Configs::getConfig('DATAPERMONTH'))];
    } else {
        $months[$i] = 'xx';
    }
}

// Use a text X-scale
$graph->SetScale('textlin');

// Specify X-labels
$graph->xaxis->SetTickLabels($months);
$graph->xaxis->SetTextTickInterval(Graph\Configs::getConfig('DATAPERMONTH'), 0);
$graph->xaxis->SetTextLabelInterval(2);

// Set title and subtitle
$example_title = 'Textscale with tickinterval=2';
$graph->title->set($example_title);

// Use built in font
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$graph->SetBox(true, 'red');

// Create the bar plot
$lp1 = new Plot\LinePlot($datay);
$lp1->SetLegend('Temperature');

// The order the plots are added determines who's ontop
$graph->Add($lp1);

// Finally output the  image
$graph->Stroke();
