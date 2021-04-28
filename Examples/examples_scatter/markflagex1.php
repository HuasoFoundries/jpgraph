<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [
    [4, 26, 15, 44],
    [20, 51, 32, 20], ];

// Setup the graph
$__width = 300;
$__height = 200;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMarginColor('white');
$graph->SetScale('textlin');
$graph->SetFrame(false);
$graph->SetMargin(30, 5, 25, 20);

// Enable X-grid as well
$graph->xgrid->Show();

// Use months as X-labels
$graph->xaxis->SetTickLabels($graph->gDateLocale->GetShortMonth());

//------------------------
// Create the plots
//------------------------
$p1 = new Plot\LinePlot($datay[0]);
$p1->SetColor('navy');

// Use a flag
$p1->mark->SetType(Graph\Configs::getConfig('MARK_FLAG1'), 197);

// Displayes value on top of marker image
$p1->value->SetFormat('%d mil');
$p1->value->Show();
$p1->value->SetColor('darkred');
$p1->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);
// Increase the margin so that the value is printed avove tje
// img marker
$p1->value->SetMargin(14);

// Incent the X-scale so the first and last point doesn't
// fall on the edges
$p1->SetCenter();

$graph->Add($p1);

//------------
// 2:nd plot
//------------
$p2 = new Plot\LinePlot($datay[1]);
$p2->SetColor('navy');

// Use a flag
$p2->mark->SetType(Graph\Configs::getConfig('MARK_FLAG1'), 'united states');

// Displayes value on top of marker image
$p2->value->SetFormat('%d mil');
$p2->value->Show();
$p2->value->SetColor('darkred');
$p2->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);
// Increase the margin so that the value is printed avove tje
// img marker
$p2->value->SetMargin(14);

// Incent the X-scale so the first and last point doesn't
// fall on the edges
$p2->SetCenter();
$graph->Add($p2);

$graph->Stroke();
