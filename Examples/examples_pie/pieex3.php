<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [40, 21, 17, 14, 23];

// Create the Pie Graph.
$__width = 350;
$__height = 300;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

// Set A title for the plot
$example_title = 'Multiple - Pie plot';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Create plots
$size = 0.13;
$p1 = new Plot\PiePlot($data);
$p1->SetLegends(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
$p1->SetSize($size);
$p1->SetCenter(0.25, 0.32);
$p1->value->SetFont(Graph\Configs::getConfig('FF_FONT0'));
$example_title = '2001';
$p1->title->set($example_title);

$p2 = new Plot\PiePlot($data);
$p2->SetSize($size);
$p2->SetCenter(0.65, 0.32);
$p2->value->SetFont(Graph\Configs::getConfig('FF_FONT0'));
$example_title = '2002';
$p2->title->set($example_title);

$p3 = new Plot\PiePlot($data);
$p3->SetSize($size);
$p3->SetCenter(0.25, 0.75);
$p3->value->SetFont(Graph\Configs::getConfig('FF_FONT0'));
$example_title = '2003';
$p3->title->set($example_title);

$p4 = new Plot\PiePlot($data);
$p4->SetSize($size);
$p4->SetCenter(0.65, 0.75);
$p4->value->SetFont(Graph\Configs::getConfig('FF_FONT0'));
$example_title = '2004';
$p4->title->set($example_title);

$graph->Add($p1);
$graph->Add($p2);
$graph->Add($p3);
$graph->Add($p4);

$graph->Stroke();
