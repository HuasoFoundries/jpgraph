<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Themes;

$data1y = [47, 80, 40, 116];
$__width = 400;
$__height = 300;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->SetScale('textlin');

$theme_class = new Themes\AquaTheme();
$graph->SetTheme($theme_class);

// after setting theme, you can change details as you want
$graph->SetFrame(true, 'lightgray'); // set frame visible

$graph->xaxis->SetTickLabels(['A', 'B', 'C', 'D']); // change xaxis lagels$example_title='Theme Example'; $graph->title->set($example_title); // add title

// add barplot
$bplot = new Plot\BarPlot($data1y);
$graph->Add($bplot);

// you can change properties of the plot only after calling Add()
$bplot->SetWeight(0);
$bplot->SetFillGradient('#FFAAAA:0.7', '#FFAAAA:1.2', Graph\Configs::getConfig('GRAD_VER'));

$graph->Stroke();
