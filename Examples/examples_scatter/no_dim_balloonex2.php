<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Each ballon is specificed by four values.
// (X,Y,Size,Color)
$data = [
    [1, 12, 10, 'orange'],
    [3, 41, 15, 'red'],
    [4, 5, 19, 'lightblue'],
    [5, 70, 22, 'yellow'],
];

// We need to create X,Y data vectors suitable for the
// library from the above raw data.
$n = \count($data);

for ($i = 0; $i < $n; ++$i) {
    $datax[$i] = $data[$i][0];
    $datay[$i] = $data[$i][1];

    // Create a faster lookup array so we don't have to search
    // for the correct values in the callback function
    $format[(string) ($datax[$i])][(string) ($datay[$i])] = [$data[$i][2], $data[$i][3]];
}

// Callback for markers
// Must return array(width,border_color,fill_color,filename,imgscale)
// If any of the returned values are '' then the
// default value for that parameter will be used (possible empty)
$FCallback = function ($aYVal, $aXVal) {
    global $format;

    return [$format[(string) $aXVal][(string) $aYVal][0], '',
        $format[(string) $aXVal][(string) $aYVal][1], '', '', ];
};

// Setup a basic graph
$__width = 450;
$__height = 300;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('intlin');
$graph->SetMargin(40, 40, 40, 40);
$graph->SetMarginColor('wheat');
$example_title = 'Example of ballon scatter plot with X,Y callback';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->title->SetMargin(10);

// Use a lot of grace to get large scales since the ballon have
// size and we don't want them to collide with the X-axis
$graph->yaxis->scale->SetGrace(50, 10);
$graph->xaxis->scale->SetGrace(50, 10);

// Make sure X-axis as at the bottom of the graph and not at the default Y=0
$graph->xaxis->SetPos('min');

// Set X-scale to start at 0
$graph->xscale->SetAutoMin(0);

// Create the scatter plot
$sp1 = new Plot\ScatterPlot($datay, $datax);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));

// Uncomment the following two lines to display the values
$sp1->value->Show();
$sp1->value->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Specify the callback
$sp1->mark->SetCallbackYX($FCallback);

// Add the scatter plot to the graph
$graph->Add($sp1);

// ... and send to browser
$graph->Stroke();
