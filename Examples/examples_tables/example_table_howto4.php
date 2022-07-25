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

// Merge all cells in row 0
$table->MergeRow(0);

// Set foreground and background color
$table->SetCellFillColor(0, 0, 'orange@0.7');
$table->SetCellColor(0, 0, 'darkred');

// Add the table to the graph
$graph->Add($table);

// and send it back to the client
$graph->Stroke();
