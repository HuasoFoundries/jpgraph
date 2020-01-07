<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Make a circle with a scatterplot
$steps = 16;
for ($i = 0; $i < $steps; ++$i) {
    $a         = 2 * M_PI / $steps * $i;
    $datax[$i] = cos($a);
    $datay[$i] = sin($a);
}

$__width  = 350;
$__height = 230;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
$graph->SetShadow();
$graph->SetAxisStyle(Graph\Configs::getConfig('AXSTYLE_BOXIN'));

$graph->img->SetMargin(50, 50, 60, 40);
$example_title = 'Linked scatter plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$subtitle_text = 'BOXIN Axis style)';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_NORMAL'));

// 10% top and bottom grace
$graph->yscale->SetGrace(5, 5);
$graph->xscale->SetGrace(1, 1);

$sp1 = new Plot\ScatterPlot($datay, $datax);
$sp1->mark->SetType(Graph\Configs::getConfig('MARK_FILLEDCIRCLE'));
$sp1->mark->SetFillColor('red');
$sp1->SetColor('blue');

$sp1->mark->SetWidth(4);
$sp1->link->Show();
$sp1->link->SetWeight(2);
$sp1->link->SetColor('red@0.7');

$graph->Add($sp1);
$graph->Stroke();
