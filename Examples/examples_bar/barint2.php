<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$datay = [3, 7, 19, 11, 4, 20];

// Create the graph and setup the basic parameters
$__width = 350;
$__height = 200;
$graph = new Graph\Graph($__width, $__height, 'auto');
$graph->img->SetMargin(40, 30, 40, 40);
$graph->SetScale('textint');
$graph->SetFrame(true, 'blue', 1);
$graph->SetColor('lightblue');
$graph->SetMarginColor('lightblue');

// Add some grace to the top so that the scale doesn't
// end exactly at the max value.
//$graph->yaxis->scale->SetGrace(20);

// Setup X-axis labels
$a = $graph->gDateLocale->GetShortMonth();
$graph->xaxis->SetTickLabels($a);
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_FONT1'));
$graph->xaxis->SetColor('darkblue', 'black');

// Stup hidden y-axis by given it the same color
// as the background
$graph->yaxis->SetColor('lightblue', 'darkblue');
$graph->ygrid->SetColor('white');

// Setup graph title ands fonts$example_title='Example of integer Y-scale'; $graph->title->set($example_title);
$subtitle_text = '(With hidden y-axis)';
$graph->subtitle->Set($subtitle_text);

$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->Set('Year 2002');
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_BOLD'));

// Create a bar pot
$bplot = new Plot\BarPlot($datay);
$bplot->SetFillColor('darkblue');
$bplot->SetColor('darkblue');
$bplot->SetWidth(0.5);
$bplot->SetShadow('darkgray');

// Setup the values that are displayed on top of each bar
$bplot->value->Show();
// Must use TTF fonts if we want text at an arbitrary angle
$bplot->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
$bplot->value->SetFormat('$%d');
// Black color for positive values and darkred for negative values
$bplot->value->SetColor('black', 'darkred');
$graph->Add($bplot);

// Finally stroke the graph
$graph->Stroke();
