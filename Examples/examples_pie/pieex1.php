<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [113, 5, 160, 3, 15, 10, 1];

// Create the Pie Graph.
$__width = 300;
$__height = 200;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Set A title for the plot
$example_title = 'Pie plot Example ';
$graph->title->set($example_title);
$graph->title->SetFont(
    Graph\Configs::getConfig('FF_VERDANA'),
    Graph\Configs::getConfig('FS_BOLD'),
    14
);
$graph->title->SetColor('brown');

// Create pie plot
$p1 = new Plot\PiePlot($data);
//$p1->SetSliceColors(array("red","blue","yellow","green"));
$p1->SetTheme('earth');

$p1->value->SetFont(
    Graph\Configs::getConfig('FF_ARIAL'),
    Graph\Configs::getConfig('FS_NORMAL'),
    10
);
// Set how many pixels each slice should explode
$p1->Explode([0, 15, 15, 25, 15]);

$graph->Add($p1);
$graph->Stroke();
