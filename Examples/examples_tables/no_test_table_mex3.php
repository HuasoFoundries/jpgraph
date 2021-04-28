<?php

/**
 * JPGraph - Community Edition
 */
use  Amenadiel\JpGraph\Graph;
use  Amenadiel\JpGraph\Text\Configs;
use Amenadiel\JpGraph\Graph\CanvasGraph;
use Amenadiel\JpGraph\Text\GTextTable;

require_once __DIR__ . '/../../src/config.inc.php';

// Setup graph context
$__width = 430;
$__height = 150;
$graph = new CanvasGraph($__width, $__height);

// Setup the basic table
$data = [
    ['', 'w631', 'w632', 'w633', 'w634', 'w635', 'w636'],
    ['Critical (sum)', 13, 17, 15, 8, 3, 9],
    ['High (sum)', 34, 35, 26, 20, 22, 16],
    ['Low (sum)', 41, 43, 49, 45, 51, 47],
    ['Sum:', 88, 95, 90, 73, 76, 72],
];

// Setup the basic table and font
$table = new GTextTable();
$table->Set($data);
$table->SetFont(Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_NORMAL'), 11);

// Set default minimum color width
$table->SetMinColWidth(40);

// Set default table alignment
$table->SetAlign('right');

// Turn off grid
$table->setGrid(0);

// Set table border
$table->SetBorder(2);

// Setup font
$table->SetRowFont(4, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 11);
$table->SetRowFont(0, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 11);
$table->SetFont(1, 2, 1, 3, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 11);

// Setup grids
$table->SetRowGrid(4, 2, 'black', Configs::getConfig('TGRID_SINGLE'));
$table->SetColGrid(1, 1, 'black', Configs::getConfig('TGRID_SINGLE'));
$table->SetRowGrid(1, 1, 'black', Configs::getConfig('TGRID_SINGLE'));

// Setup colors
$table->SetFillColor(0, 1, 0, 6, 'black');
$table->SetRowColor(0, 'white');
$table->SetRowFillColor(4, 'lightgray@0.3');
$table->SetFillColor(2, 0, 2, 6, 'lightgray@0.6');
$table->SetFillColor(1, 2, 1, 3, 'lightred');

// Add table to graph
$graph->Add($table);

// Send back to the client
$graph->Stroke();
