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
$__width = 150;
$__height = 60;
$graph = new CanvasGraph($__width, $__height);

// Setup the basic table
$data = [[1, 2, 3, 4], [5, 6, 7, 8]];
$table = new GTextTable();
$table->Set($data);

// Merge all cells in row 0
$table->MergeRow(0);

// Setup font and color
$table->SetCellFont(0, 0, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 14);
$table->SetRowFillColor(0, 'orange@0.5');
$table->SetRowColor(0, 'darkred');

// Setup the minimum width of all columns
$table->SetMinColWidth(35);

// Add table to the graph
$graph->Add($table);

// ... send it back to the client
$graph->Stroke();
