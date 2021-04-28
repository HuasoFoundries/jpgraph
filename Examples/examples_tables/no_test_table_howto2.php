<?php

/**
 * JPGraph - Community Edition
 */
use  Amenadiel\JpGraph\Graph;
use  Amenadiel\JpGraph\Text\Configs;
use Amenadiel\JpGraph\Graph\CanvasGraph;
use Amenadiel\JpGraph\Text\GTextTable;

require_once __DIR__ . '/../../src/config.inc.php';

// Create a canvas graph where the table can be added
$__width = 70;
$__height = 50;
$graph = new CanvasGraph($__width, $__height);

// Setup the basic table
$data = [[1, 2, 3, 4], [5, 6, 7, 8]];
$table = new GTextTable();
$table->Set($data);

// Merge all cellsn in the rectangle with
// top left corner = (0,2) and bottom right = (1,3)
$table->MergeCells(0, 2, 1, 3);

// Add the table to the graph
$graph->Add($table);

// ... and send back the table to the client
$graph->Stroke();
