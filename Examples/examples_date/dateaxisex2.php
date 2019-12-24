<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Create a data set in range (50,70) and X-positions
$NDATAPOINTS = 360;
$SAMPLERATE  = 240;
$start       = time();
$end         = $start + $NDATAPOINTS * $SAMPLERATE;
$data        = [];
$xdata       = [];
for ($i = 0; $i < $NDATAPOINTS; ++$i) {
    $data[$i]  = rand(50, 70);
    $xdata[$i] = $start + $i * $SAMPLERATE;
}

// Create the new Graph\Graph
$__width  = 540;
$__height = 300;
$graph    = new Graph\Graph($__width, $__height);

// Slightly larger than normal margins at the bottom to have room for
// the x-axis labels
$graph->SetMargin(40, 40, 30, 130);

// Fix the Y-scale to go between [0,100] and use date for the x-axis
$graph->SetScale('datlin', 0, 100);
$example_title = 'Example on Date scale';
$graph->title->set($example_title);

// Set the angle for the labels to 90 degrees
$graph->xaxis->SetLabelAngle(90);

$line = new Plot\LinePlot($data, $xdata);
$line->SetLegend('Year 2005');
$line->SetFillColor('lightblue@0.5');
$graph->Add($line);
$graph->Stroke();
