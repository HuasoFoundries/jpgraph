<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$labels   = ['Oct 2000', 'Nov 2000', 'Dec 2000', 'Jan 2001', 'Feb 2001', 'Mar 2001', 'Apr 2001', 'May 2001'];
$datay    = [1.23, 1.9, 1.6, 3.1, 3.4, 2.8, 2.1, 1.9];
$__width  = 300;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->img->SetMargin(40, 40, 40, 80);
$graph->img->SetAntiAliasing();
$graph->SetScale('textlin');
$graph->SetShadow();
$example_title = 'Example slanted X-labels';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 14);

$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 11);
$graph->xaxis->SetTickLabels($labels);
$graph->xaxis->SetLabelAngle(45);

$p1 = new Plot\LinePlot($datay);
$p1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$p1->mark->SetFillColor('red');
$p1->mark->SetWidth(4);
$p1->SetColor('blue');
$p1->SetCenter();
$graph->Add($p1);

$graph->Stroke();
