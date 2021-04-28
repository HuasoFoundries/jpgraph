<?php

/**
 * JPGraph - Community Edition
 */

// $Id: balloonex1.php,v 1.5 2002/12/15 16:08:51 aditus Exp $
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$datax = [1, 2, 3, 4, 5, 6, 7, 8];
$datay = [12, 23, 95, 18, 65, 28, 86, 44];
// Callback for markers
// Must return array(width,color,fill_color)
// If any of the returned values are "" then the
// default value for that parameter will be used.
$FCallback = function ($aVal) {
    // This callback will adjust the fill color and size of
    // the datapoint according to the data value according to
    if (30 > $aVal) {
        $c = 'blue';
    } elseif (70 > $aVal) {
        $c = 'green';
    } else {
        $c = 'red';
    }

    return [\floor($aVal / 3), '', $c];
};

// Setup a basic graph
$__width = 400;
$__height = 300;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('linlin');
$graph->img->SetMargin(40, 100, 40, 40);
$graph->SetShadow();
$example_title = 'Example of ballon scatter plot';
$graph->title->set($example_title);
// Use a lot of grace to get large scales
$graph->yaxis->scale->SetGrace(50, 10);

// Make sure X-axis as at the bottom of the graph
$graph->xaxis->SetPos('min');

// Create the scatter plot
$sp1 = new Plot\ScatterPlot($datay, $datax);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));

// Uncomment the following two lines to display the values
$sp1->value->Show();
$sp1->value->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Specify the callback
$sp1->mark->SetCallback($FCallback);

// Setup the legend for plot
$sp1->SetLegend('Year 2002');

// Add the scatter plot to the graph
$graph->Add($sp1);

// ... and send to browser
$graph->Stroke();
