<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$datay  = [28, 19, 18, 23, 12, 11];
$data2y = [14, 18, 33, 29, 39, 55];

// A nice graph with anti-aliasing
$__width  = 400;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(40, 180, 40, 40);
$graph->SetBackgroundImage(__DIR__ . '/../assets/tiger_bkg.png', BGIMG_FILLPLOT);

$graph->img->SetAntiAliasing('white');
$graph->SetScale('textlin');
$graph->SetShadow();
$graph->title->Set('Background image');

// Use built in font
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Slightly adjust the legend from it's default position in the
// top right corner.
$graph->legend->Pos(0.05, 0.5, 'right', 'center');

// Create the first line
$p1 = new Plot\LinePlot($datay);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor('red');
$p1->mark->SetWidth(4);
$p1->SetColor('blue');
$p1->SetCenter();
$p1->SetLegend('Triumph Tiger -98');
$graph->Add($p1);

// ... and the second
$p2 = new Plot\LinePlot($data2y);
$p2->mark->SetType(MARK_STAR);
$p2->mark->SetFillColor('red');
$p2->mark->SetWidth(4);
$p2->SetColor('red');
$p2->SetCenter();
$p2->SetLegend('New tiger -99');
$graph->Add($p2);

// Output line
$graph->Stroke();
