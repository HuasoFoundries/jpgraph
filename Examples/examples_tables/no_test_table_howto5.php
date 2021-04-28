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
$__height = 60;
$graph = new CanvasGraph($__width, $__height);

// Setup the basic table
$data = [[1, 2, 3, 4], [5, 6, 7, 8]];
$table = new GTextTable();
$table->Set($data);

// Merge all cells in row 0
$table->MergeRow(0);

// Adjust font in cell (0,0)
$table->SetCellFont(0, 0, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 14);

// Set left align for all cells in rectangle (0,0) - (0,3)
$table->SetAlign(0, 0, 0, 3, 'Left');

// Add table to graph
$graph->Add($table);

// ... send it back to the client
$graph->Stroke();
