<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;

$datay = [
    ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    [12, 18, 19, 7, 17, 6],
    [3, 5, 2, 7, 5, 25],
    [6, 1.5, 2.4, 2.1, 6.9, 12.3], ];

// Some basic defines to specify the shape of the bar+table
$nbrbar = 6;
$cellwidth = 50;
$tableypos = 200;
$tablexpos = 60;
$tablewidth = $nbrbar * $cellwidth;
$rightmargin = 30;

// Overall graph size
$height = 320;
$width = $tablexpos + $tablewidth + $rightmargin;

// Create the basic graph.
$graph = new Graph\Graph($width, $height);
$graph->img->SetMargin($tablexpos, $rightmargin, 30, $height - $tableypos);
$graph->SetScale('textlin');
$graph->SetMarginColor('white');

// Setup titles and fonts$example_title='Bar and table'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 14);
$graph->yaxis->title->Set('Flow');
$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 12);
$graph->yaxis->title->SetMargin(10);

// Create the bars and the accbar plot
$bplot = new Plot\BarPlot($datay[3]);
$bplot->SetFillColor('orange');
$bplot2 = new Plot\BarPlot($datay[2]);
$bplot2->SetFillColor('red');
$bplot3 = new Plot\BarPlot($datay[1]);
$bplot3->SetFillColor('darkgreen');
$accbplot = new Plot\AccBarPlot([$bplot, $bplot2, $bplot3]);
$accbplot->value->Show();
$graph->Add($accbplot);

//Setup the table
$table = new Text\GTextTable();
$table->Set($datay);
$table->SetPos($tablexpos, $tableypos + 1);

$table->SetCellCSIMTarget(1, 1, 'tableex02.php', 'View details');

// Basic table formatting
$table->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
$table->SetAlign('right');
$table->SetMinColWidth($cellwidth);
$table->SetNumberFormat('%0.1f');

// Format table header row
$table->SetRowFillColor(0, 'teal@0.7');
$table->SetRowFont(0, Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 11);
$table->SetRowAlign(0, 'center');

// .. and add it to the graph
$graph->Add($table);

$graph->StrokeCSIM();
