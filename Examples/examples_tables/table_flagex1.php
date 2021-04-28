<?php

/**
 * JPGraph - Community Edition
 */

use  Amenadiel\JpGraph\Graph;
use  Amenadiel\JpGraph\Text\Configs;
use Amenadiel\JpGraph\Graph\CanvasGraph;
use Amenadiel\JpGraph\Text\GTextTable;

require_once __DIR__ . '/../../src/config.inc.php';



// Setup a basic canvas to use as graph to add the table
$__width = 500;
$__height = 200;
$graph = new CanvasGraph($__width, $__height);

// Setup the basic table
$data = [
    ['Areas'],
    [''],
    ['', 'USA', 'UK', 'France', 'Denmark', 'Iceland', 'Canada'],
    ['Feb', 13, 17, 15, 8, 3, 9],
    ['Mar', 34, 35, 26, 20, 22, 16],
    ['Apr', 41, 43, 49, 45, 51, 47],
    ['Sum:', 88, 95, 90, 73, 76, 72],
];

$countries = ['united states', 'united kingdom', 'french republic', 'denmark', 'iceland', 'canada'];

// Create a basic table and default fonr
$table = new GTextTable();
$table->Set($data);
$table->SetFont(Configs::getConfig('FF_TIMES'), Configs::getConfig('FS_NORMAL'), 11);

// Adjust the font for row 0 and 6
$table->SetColFont(0, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 11);
$table->SetRowFont(6, Configs::getConfig('FF_TIMES'), Configs::getConfig('FS_BOLD'), 12);

// Set the minimum heigth/width
$table->SetMinRowHeight(2, 10);
$table->SetMinColWidth(70);

// Add some padding (in pixels)
$table->SetRowPadding(2, 0);
$table->SetRowGrid(6, 1, 'darkgray',   Configs::getConfig('TGRID_DOUBLE2'));

// Setup the grid
$table->SetGrid(0);
$table->SetRowGrid(6, 1, 'black', Configs::getConfig('TGRID_DOUBLE2'));

// Merge all cells in row 0
$table->MergeRow(0);

// Set aligns
$table->SetAlign(3, 0, 6, 6, 'right');
$table->SetRowAlign(1, 'center');
$table->SetRowAlign(2, 'center');

// Set background colors
$table->SetRowFillColor(0, 'lightgray@0.5');
$table->SetColFillColor(0, 'lightgray@0.5');

// Add the country flags in row 1
$n = \count($countries);

for ($i = 0; $i < $n; ++$i) {
    $table->SetCellCountryFlag(1, $i + 1, $countries[$i], 0.5);
    $table->SetCellImageConstrain(1, $i + 1, Configs::getConfig('TIMG_HEIGHT'), 20);
}

// Add the table to the graph
$graph->Add($table);

// Send back the table graph to the client
$graph->Stroke();
