<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay1 = [4, 26, 15, 44];

// Setup the graph
$__width = 300;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetMarginColor('white');
$graph->SetScale('textlin');
$graph->SetFrame(false);
$graph->SetMargin(30, 5, 25, 50);

// Setup the tab
$graph->tabtitle->Set(' Year 2003 ');
$graph->tabtitle->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 13);
$graph->tabtitle->SetColor('darkred', '#E1E1FF');

// Enable X-grid as well
$graph->xgrid->Show();

// Use months as X-labels
$graph->xaxis->SetTickLabels($graph->gDateLocale->GetShortMonth());

$graph->footer->left->Set('L. footer');
$graph->footer->left->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 12);
$graph->footer->left->SetColor('darkred');
$graph->footer->center->Set('C. footer');
$graph->footer->center->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$graph->footer->center->SetColor('darkred');
$graph->footer->right->Set('R. footer');
$graph->footer->right->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 12);
$graph->footer->right->SetColor('darkred');

// Create the plot
$p1 = new Plot\LinePlot($datay1);
$p1->SetColor('navy');

// Use an image of favourite car as marker
$p1->mark->SetType(Graph\Configs::getConfig('MARK_IMG'), __DIR__ . '/../assets/saab_95.jpg', 0.5);

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

$graph->Stroke();
