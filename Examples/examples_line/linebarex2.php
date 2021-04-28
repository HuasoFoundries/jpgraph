<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data

$steps = 100;

for ($i = 0; $i < $steps; ++$i) {
    $datay[$i] = \log($i ** ($i / 10) + 1) * \sin($i / 15) + 35;
    $datax[] = $i;

    if ($i % 10 === 0) {
        $databarx[] = $i;
        $databary[] = $datay[$i] / 2;
    }
}

// new Graph\Graph with a background image and drop shadow
$__width = 450;
$__height = 300;
$graph = new Graph\Graph($__width, $__height);
$graph->SetBackgroundImage(__DIR__ . '/../assets/tiger_bkg.png', Graph\Configs::getConfig('BGIMG_FILLFRAME'));
$graph->SetShadow();

// Use an integer X-scale
$graph->SetScale('intlin');

// Set title and subtitle
$example_title = 'Combined bar and line plot';
$graph->title->set($example_title);
$subtitle_text = 'left aligned bars';
$graph->subtitle->Set($subtitle_text);

// Use built in font
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

// Make the margin around the plot a little bit bigger
// then default
$graph->img->SetMargin(40, 120, 40, 40);

// Slightly adjust the legend from it's default position in the
// top right corner to middle right side
$graph->legend->Pos(0.05, 0.5, 'right', 'center');

// Create a red line plot
$p1 = new Plot\LinePlot($datay, $datax);
$p1->SetColor('red');
$p1->SetLegend('Status one');
$graph->Add($p1);

// Create the bar plot
$b1 = new Plot\BarPlot($databary, $databarx);
$b1->SetLegend('Status two');
$b1->SetAlign('left');
$b1->SetShadow();
$graph->Add($b1);

// Finally output the  image
$graph->Stroke();
