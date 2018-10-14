<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// A new Graph\Graph with automatic size
$graph = new Graph\GanttGraph();

//  A new activity on row '0'
$activity = new Plot\GanttBar(0, 'Activity 1', '2001-12-21', '2002-01-19');
$graph->Add($activity);

// Display the Gantt chart
$graph->Stroke();
