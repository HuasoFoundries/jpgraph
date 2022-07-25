<?php

/**
 * JPGraph - Community Edition
 */

// File:    Graph\Configs::getConfig('ODOEX012').PHP
// Description: Example 0 for odometer graphs
// Created:    2002-02-22
// Version:    $Id$
//
// Comment:
// Example file for odometer graph. Extends odoex11.php to add two more
// odometers to the image and showing more layout possibilities
//
// Copyright (C) 2002 Johan Persson. All rights reserved.
//=============================================================================
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_odo.php';

//---------------------------------------------------------------------
// Create a new odometer graph (width=400, height=400 pixels)
//---------------------------------------------------------------------
$__width = 400;
$__height = 370;
$graph = new OdoGraph($__width, $__height);
$graph->SetShadow();

//---------------------------------------------------------------------
// Specify title and subtitle using default fonts
// * Note each title may be multilines by using a '\n' as a line
// divider.
//---------------------------------------------------------------------$example_title='Result from 2002'; $graph->title->set($example_title);
$graph->title->SetColor('white');
$subtitle_text = 'O1 - W-Site';
$graph->subtitle->Set($subtitle_text);
$graph->subtitle->SetColor('white');

//---------------------------------------------------------------------
// Specify caption.
// * (This is the text at the bottom of the graph.) The margins will
// automatically adjust to fit the height of the text. A caption
// may have multiple lines by including a '\n' character in the
// string.
//---------------------------------------------------------------------
$graph->caption->Set("Fig1. Values within 85%\nconfidence intervall");
$graph->caption->SetColor('white');

//---------------------------------------------------------------------
// We will display two columns where the first column has
// three odometers (same as in example 11) and the second column
// has two odoemters
// The first thing to do is to create them
//---------------------------------------------------------------------
$odo1 = new Odometer();
$odo2 = new Odometer();
$odo3 = new Odometer();
$odo4 = new Odometer();
$odo5 = new Odometer();

//---------------------------------------------------------------------
// Set caption for each odometer
//---------------------------------------------------------------------
$odo1->caption->Set('April');
$odo1->caption->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'));
$odo2->caption->Set('May');
$odo2->caption->SetFont(Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_BOLD'));
$odo3->caption->Set('June');
$odo3->caption->SetFont(Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_BOLD'));
$odo4->caption->Set('Daily low average');
$odo4->caption->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$odo5->caption->Set('Daily high average');
$odo5->caption->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

//---------------------------------------------------------------------
// Set Indicator bands for the odometers
//---------------------------------------------------------------------
$odo1->AddIndication(80, 100, 'red');
$odo2->AddIndication(20, 30, 'green');
$odo2->AddIndication(65, 100, 'red');
$odo3->AddIndication(60, 90, 'yellow');
$odo3->AddIndication(90, 100, 'red');

//---------------------------------------------------------------------
// Set display values for the odometers
//---------------------------------------------------------------------
$odo1->needle->Set(17);
$odo2->needle->Set(47);
$odo3->needle->Set(86);
$odo4->needle->Set(22);
$odo5->needle->Set(77);

$odo1->needle->SetFillColor('blue');
$odo2->needle->SetFillColor('yellow:0.7');
$odo3->needle->SetFillColor('black');
$odo3->needle->SetColor('black');

//---------------------------------------------------------------------
// Set scale label properties
//---------------------------------------------------------------------
$odo1->scale->label->SetColor('navy');
$odo2->scale->label->SetColor('blue');
$odo3->scale->label->SetColor('darkred');

$odo1->scale->label->SetFont(Graph\Configs::getConfig('FF_FONT1'));
$odo2->scale->label->SetFont(Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_BOLD'));
$odo3->scale->label->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);

//---------------------------------------------------------------------
// Add the odometers to the graph using a vertical layout
//---------------------------------------------------------------------
$l1 = new LayoutVert([$odo1, $odo2, $odo3]);
$l2 = new LayoutVert([$odo4, $odo5]);
$l3 = new LayoutHor([$l1, $l2]);
$graph->Add($l3);

//---------------------------------------------------------------------
// ... and finally stroke and stream the image back to the browser
//---------------------------------------------------------------------
$graph->Stroke();

// EOF
