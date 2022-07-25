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
$__width = 500;
$__height = 300;
$graph = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();

$theme_class = new UniversalTheme();
//$graph->SetTheme($theme_class);

// Set A title for the plot
$example_title = 'Multiple - Pie plot';
$graph->title->set($example_title);

// Create plots
$size = 0.13;
$p1 = new Plot\PiePlot($data);
$graph->Add($p1);

$p1->SetSize($size);
$p1->SetCenter(0.25, 0.32);
$p1->SetSliceColors(['#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3']);
$example_title = '2005';
$p1->title->set($example_title);

$p2 = new Plot\PiePlot($data);
$graph->Add($p2);

$p2->SetSize($size);
$p2->SetCenter(0.65, 0.32);
$p2->SetSliceColors(['#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3']);
$example_title = '2006';
$p2->title->set($example_title);

$p3 = new Plot\PiePlot($data);
$graph->Add($p3);

$p3->SetSize($size);
$p3->SetCenter(0.25, 0.75);
$p3->SetSliceColors(['#6495ED', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3']);
$example_title = '2007';
$p3->title->set($example_title);

$p4 = new Plot\PiePlot($data);
$graph->Add($p4);

$p4->SetSize($size);
$p4->SetCenter(0.65, 0.75);
$p4->SetSliceColors(['#6495ED', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3']);
$example_title = '2008';
$p4->title->set($example_title);

$graph->Stroke();
