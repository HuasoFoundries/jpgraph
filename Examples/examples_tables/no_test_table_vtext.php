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
$__width = 630;
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

// Setup a basic table
$table = new GTextTable();
$table->Set($data);
$table->SetAlign('right');
$table->SetFont(Configs::getConfig('FF_TIMES'), Configs::getConfig('FS_NORMAL'), 12);
$table->SetCellFont(0, 0, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 16);

// Rotate the entire table 90 degrees
$table->SetTextOrientation(90);
//$table->SetCellTextOrientation(0,0,0);

// Setup background color for header column
$table->SetColFillColor(0, 'lightgray');

// Set the imnimum row height
$table->SetMinRowHeight(0, 150);

// Add table to graph
$graph->Add($table);

// and send it back to the client
$graph->Stroke();
