<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
require_once 'jpgraph/jpgraph_canvas.php';
require_once 'jpgraph/jpgraph_table.php';

// Setup a basic canvas graph context
$__width  = 430;
$__height = 600;
$graph    = new CanvasGraph($__width, $__height);

// Setup the basic table
$data = [
    ['GROUP 1O', 'w631', 'w632', 'w633', 'w634', 'w635', 'w636'],
    ['Critical (sum)', 13, 17, 15, 8, 3, 9],
    ['High (sum)', 34, 35, 26, 20, 22, 16],
    ['Low (sum)', 41, 43, 49, 45, 51, 47],
    ['Sum:', 88, 95, 90, 73, 76, 72],
];

// Setup the basic table and default font
$table = new GTextTable();
$table->Set($data);
$table->SetFont(FF_TIMES, FS_NORMAL, 11);

// Default table alignment
$table->SetAlign('right');

// Adjust font in (0,0)
$table->SetCellFont(0, 0, FF_TIMES, FS_BOLD, 14);

// Rotate all textxs in row  0
$table->SetRowTextOrientation(0, 90);

// Adjust alignment in cell (0,0)
$table->SetCellAlign(0, 0, 'center', 'center');

// Add table to graph
$graph->Add($table);

// Send back table to client
$graph->Stroke();
