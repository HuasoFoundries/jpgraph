<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [0, 3, 5, 12, 15, 18, 22, 36, 37, 41];

// Setup the graph
$__width       = 320;
$__height      = 200;
$graph         = new Graph\Graph($__width, $__height);
$example_title = 'Education growth';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);
$graph->SetScale('intlin');
$graph->SetMarginColor('white');
$graph->SetBox();
//$graph->img->SetAntialiasing();

$graph->SetGridDepth(Graph\Configs::getConfig('DEPTH_FRONT'));
$graph->ygrid->SetColor('gray@0.7');
$graph->SetBackgroundImage(__DIR__ . '/../assets/classroom.jpg', Graph\Configs::getConfig('BGIMG_FILLPLOT'));

// Masking graph
$p1 = new Plot\LinePlot($datay);
$p1->SetFillColor('white');
$p1->SetFillFromYMax();
$p1->SetWeight(0);
$graph->Add($p1);

// Line plot
$p2 = new Plot\LinePlot($datay);
$p2->SetColor('black@0.4');
$p2->SetWeight(3);
$p2->mark->SetType(Graph\Configs::getConfig('MARK_SQUARE'));
$p2->mark->SetColor('orange@0.5');
$p2->mark->SetFillColor('orange@0.3');
$graph->Add($p2);

// Output line
$graph->Stroke();
