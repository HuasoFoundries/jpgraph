<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [
    '10'    => [1, 1, 2.5, 4],
    '32.0'  => [3, 4, 1, 4],
    '120.5' => [2, 3, 4, 4, 3, 2, 1],
    '223.2' => [2, 4, 1, 2, 2],
    '285.7' => [2, 2, 1, 2, 4, 2, 1, 1],
];

// This file is encode din utf-8. The two Kanji characters roughly means
// 中 = Chinese
// 文 = Sentences
$ctxt = '中文';

// Specify text for direction labels
$labels = [
    '120.5' => $ctxt,
    '232.2' => "Reference\n#13 Ver:2", ];

// Range colors to be used
$rangeColors = ['khaki', 'yellow', 'orange', 'orange:0.7', 'brown', 'darkred', 'black'];

// First create a new windrose graph with a title
$__width  = 400;
$__height = 450;
$graph    = new Graph\WindroseGraph($__width, $__height);

// Setup title
$example_title = 'Using chinese charecters';
$graph->title->set($example_title);
#$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'),FS_BOLD,12);
$graph->title->SetColor('navy');
$subtitle_text = '(Free type plot)';
$graph->subtitle->Set($subtitle_text);
#$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_VERDANA'),FS_ITALIC,10);
$graph->subtitle->SetColor('navy');

// Create the windrose plot.
$wp = new Plot\WindrosePlot($data);

// Setup a free plot
$wp->SetType(Plot\Configs::getConfig('WINDROSE_TYPEFREE'));

// Setup labels
$wp->SetLabels($labels);
$wp->SetLabelPosition(Plot\Configs::getConfig('LBLPOSITION_CENTER'));
$wp->SetLabelMargin(30);

// Setup the colors for the ranges
$wp->SetRangeColors($rangeColors);

// Adjust the font and font color for scale labels
#$wp->scale->SetFont(Graph\Configs::getConfig('FF_ARIAL'),FS_NORMAL,9);

// Set the diameter and position for plot
#$wp->SetSize(240);
$wp->SetSize(200);
$wp->SetZCircleSize(30);
$wp->SetPos(0.5, 0.5);

// Adjust the font and font color for compass directions
$wp->SetFont(Graph\Configs::getConfig('FF_CHINESE'), Graph\Configs::getConfig('FS_NORMAL'), 12);
$wp->SetFontColor('darkgreen');

// Adjust grid colors
$wp->SetGridColor('darkgreen@0.7', 'blue');

// Add (m/s) text to legend
$wp->legend->SetText('(m/s)');
$wp->legend->SetTFontColor('blue');

// Set legend label font color
$wp->legend->SetLFontColor('orange:0.7');
#$wp->legend->SetLFont(Graph\Configs::getConfig('FF_ARIAL'),FS_ITALIC,8);

// Display legend values with no decimals
$wp->legend->SetFormat('%d');

// Set the circle font to use chinse character set
// Note: When Graph\Configs::getConfig('FF_CHINESE') is used the input charectr data are
// assumed to already be in utf-8 encoding
#$wp->legend->SetCFont(Graph\Configs::getConfig('FF_CHINESE'),FS_NORMAL,14);
$wp->legend->SetCircleText($ctxt);
$wp->legend->SetCFontColor('red');

// Add plot to graph and send back to client
$graph->Add($wp);
$graph->Stroke();
