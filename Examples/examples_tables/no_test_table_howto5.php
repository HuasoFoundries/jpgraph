<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
require_once 'jpgraph/jpgraph_canvas.php';
require_once 'jpgraph/jpgraph_table.php';

// Create a canvas graph where the table can be added
$__width  = 70;
$__height = 60;
$graph    = new CanvasGraph($__width, $__height);

// Setup the basic table
$data  = [[1, 2, 3, 4], [5, 6, 7, 8]];
$table = new GTextTable();
$table->Set($data);

// Merge all cells in row 0
$table->MergeRow(0);

// Adjust font in cell (0,0)
$table->SetCellFont(0, 0, Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 14);

// Set left align for all cells in rectangle (0,0) - (0,3)
$table->SetAlign(0, 0, 0, 3, 'Left');

// Add table to graph
$graph->Add($table);

// ... send it back to the client
$graph->Stroke();
