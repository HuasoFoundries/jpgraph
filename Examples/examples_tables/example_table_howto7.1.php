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
$__height = 90;
$graph = new CanvasGraph($__width, $__height);

// Setup the basic table
$data = [[1, 2, 3, 4], [5, 6, 7, 8], [6, 8, 10, 12]];
$table = new GTextTable();
$table->Set($data);

// Set default font in entire table
$table->SetFont(
    Configs::getConfig('FF_ARIAL'),
    Configs::getConfig('FS_NORMAL'),
    11
);

// Setup font and color for row = 2
$table->SetRowFont(2, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 11);
$table->SetRowFillColor(2, 'orange@0.5');

// Setup minimum color width
$table->SetMinColWidth(35);

// Setup grid on row 2
$table->SetRowGrid(2, 1, 'black', Configs::getConfig('TGRID_DOUBLE'));

// Add table to the graph
$graph->Add($table);

// and send it back to the client
$graph->Stroke();
