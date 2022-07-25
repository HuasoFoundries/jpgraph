<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some random data to plot
$datay = [12, 26, 9, 17, 31];

// Create the graph.
$__width = 400;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');

// Create a bar pot
$bplot = new Plot\BarPlot($datay);

// Create targets for the image maps so that the details are opened in a separate window
$fmtStr = "javascript:window.open('barcsim_details_omit.php?id=%d','_new','width=500,height=300');void(0)";
$n = \count($datay);
$targ = [];
$alts = [];

for ($i = 0; $i < $n; ++$i) {
    $targ[$i] = \sprintf($fmtStr, $i + 1);
    $alts[$i] = 'val=%d';
    // Note: The format placeholder val=%d will be replaced by the actual value in the ouput Graph\Configs::getConfig('HTML') by the
    // library so that when the user hoovers the mouse over the bar the actual numerical value of the bar
    // will be dísplayed
}
$bplot->SetCSIMTargets($targ, $alts);

// Add plot to graph
$graph->Add($bplot);

// Setup the title, also wih a Graph\Configs::getConfig('CSIM') area$example_title='CSIM with popup windows'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_BOLD'));
// Assume we can give more details on the graph
$graph->title->SetCSIMTarget(\sprintf($fmtStr, -1), 'Title for Bar');

// Send back the Graph\Configs::getConfig('HTML') page which will call this script again to retrieve the image.
$graph->StrokeCSIM();
