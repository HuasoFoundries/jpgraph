<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$INTERVAL = 5 * 60;

// First create some "dummy" data
$m = 5; // Number of data sets
$n = 4; // Number of bids to show
$startbid = 8000;

for ($i = 0; $i < $m; ++$i) {
    $bids[$i] = [$startbid + \mt_rand(100, 500) * 10];

    for ($j = 1; $j < $n; ++$j) {
        $bids[$i][$j] = $bids[$i][$j - 1] + \mt_rand(20, 500) * 10;
    }
}

$start = \floor(\time() / $INTERVAL) * $INTERVAL;
$times = [$start];

for ($i = 1; $i < $n; ++$i) {
    // Create a timestamp for every 5 minutes
    $times[$i] = $times[$i - 1] + $INTERVAL;
}

// Setup the bid graph
$__width = 600;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMargin(80, 30, 50, 40);
$graph->SetMarginColor('white');
$graph->SetScale('dateint');
$example_title = 'Current Bids';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$subtitle_text = '(Updated every 5 minutes)';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_ITALIC'), 10);

// Enable antialias
$graph->img->SetAntiAliasing();

// Setup the y-axis to show currency values
$graph->yaxis->SetLabelFormatCallback('number_format');
$graph->yaxis->SetLabelFormat('$%s');

//Use hour:minute format for the labels
$graph->xaxis->scale->SetDateFormat('H:i');

// Force labels to only be displayed every 5 minutes
$graph->xaxis->scale->ticks->Set($INTERVAL);

// Adjust the start time for an "even" 5 minute, i.e. 5,10,15,20,25, ...
$graph->xaxis->scale->SetTimeAlign(Graph\Configs::getConfig('MINADJ_5'));

// Create the plots using the dummy data created at the beginning
$line = [];

for ($i = 0; $i < $m; ++$i) {
    $line[$i] = new Plot\LinePlot($bids[$i], $times);
    $line[$i]->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));
}
$graph->Add($line);

// Send the graph back to the client
$graph->Stroke();
