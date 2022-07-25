<?php

/**
 * JPGraph - Community Edition
 */

use  Amenadiel\JpGraph\Graph;
use  Amenadiel\JpGraph\Text\Configs;
use Amenadiel\JpGraph\Graph\CanvasGraph;
use Amenadiel\JpGraph\Text\GTextTable;

require_once __DIR__ . '/../../src/config.inc.php';

// Setup a basic canvas graph context
$__width = 430;
$__height = 600;
$graph = new CanvasGraph($__width, $__height);

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
$table->SetFont(
    Configs::getConfig('FF_TIMES'),
    Configs::getConfig('FS_NORMAL'),
    11
);

// Default table alignment
$table->SetAlign('right');

// Adjust font in (0,0)
$table->SetCellFont(0, 0, Configs::getConfig('FF_TIMES'), Configs::getConfig('FS_BOLD'), 14);

// Rotate all textxs in row  0
$table->SetRowTextOrientation(0, 90);

// Adjust alignment in cell (0,0)
$table->SetCellAlign(0, 0, 'center', 'center');

// Add table to graph
$graph->Add($table);

// Send back table to client
$graph->Stroke();
