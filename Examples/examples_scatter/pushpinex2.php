<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

\defined('WORLDMAP') || \define('WORLDMAP', __DIR__ . '/../assets/worldmap1.jpg');

$markCallback = function ($y, $x) {
    // Return array width
    // width,color,fill color, marker filename, imgscale
    // any value can be false, in that case the default value will
    // be used.
    // We only make one pushpin another color
    if (54 === $x) {
        return [false, false, false, 'red', 0.8];
    }

    return [false, false, false, 'green', 0.8];
};

// Data arrays
$datax = [10, 20, 30, 40, 54, 60, 70, 80];
$datay = [12, 23, 65, 18, 84, 28, 86, 44];

// Setup the graph
$__width = 400;
$__height = 270;
$graph = new Graph\Graph($__width, $__height);

// We add a small 1pixel left,right,bottom margin so the plot area
// doesn't cover the frame around the graph.
$graph->img->SetMargin(1, 1, 1, 1);
$graph->SetScale('linlin', 0, 100, 0, 100);

// We don't want any axis to be shown
$graph->xaxis->Hide();
$graph->yaxis->Hide();

// Use a worldmap as the background and let it fill the plot area
$graph->SetBackgroundImage(Graph\Configs::getConfig('WORLDMAP'), Graph\Configs::getConfig('BGIMG_FILLPLOT'));

// Setup a nice title with a striped bevel background$example_title='Pushpin graph'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 16);
$graph->title->SetColor('white');
$graph->SetTitleBackground('darkgreen', Graph\Configs::getConfig('TITLEBKG_STYLE1'), Graph\Configs::getConfig('TITLEBKG_FRAME_BEVEL'));
$graph->SetTitleBackgroundFillStyle(Graph\Configs::getConfig('TITLEBKG_FILLSTYLE_HSTRIPED'), 'blue', 'darkgreen');

// Finally create the lineplot
$lp = new Plot\LinePlot($datay, $datax);
$lp->SetColor('lightgray');

// We want the markers to be an image
$lp->mark->SetType(Graph\Configs::getConfig('MARK_IMG_PUSHPIN'), 'blue', 0.6);

// Install the Y-X callback for the markers
$lp->mark->SetCallbackYX($markCallback);

// ...  and add it to the graph
$graph->Add($lp);

// .. and output to browser
$graph->Stroke();
