<?php

/**
 * JPGraph - Community Edition
 */

// File:    Graph\Configs::getConfig('ODOEX00').PHP
// Description: Example 0 for odometer graphs
// Created:    2002-02-22
// Version:    $Id$
//
// Comment:
// Example file for odometer graph. This examples demonstrates the simplest
// possible graph using all default values for colors, sizes etc.
//
// Copyright (C) 2002 Johan Persson. All rights reserved.
//=============================================================================
require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;

//---------------------------------------------------------------------
// Create a new odometer graph (width=250, height=200 pixels)
//---------------------------------------------------------------------
$__width = 250;
$__height = 130;
$graph = new OdoGraph($__width, $__height);
$graph->SetColor('white');
$graph->SetMarginColor('white');
$graph->SetFrame(false);

//---------------------------------------------------------------------
// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
//---------------------------------------------------------------------
$odo = new Odometer();

//---------------------------------------------------------------------
// Set display value for the odometer
//---------------------------------------------------------------------
$odo->needle->Set(40);

//---------------------------------------------------------------------
// Add the odometer to the graph
//---------------------------------------------------------------------
$graph->Add($odo);

//---------------------------------------------------------------------
// ... and finally stroke and stream the image back to the browser
//---------------------------------------------------------------------
$graph->Stroke();

// EOF
