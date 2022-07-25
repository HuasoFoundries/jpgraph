<?php

/**
 * JPGraph - Community Edition
 */
use  Amenadiel\JpGraph\Graph;
use  Amenadiel\JpGraph\Text\Configs;
use Amenadiel\JpGraph\Graph\CanvasGraph;
use Amenadiel\JpGraph\Text\GTextTable;

require_once __DIR__ . '/../../src/config.inc.php';

$cols = 4;
$rows = 3;
$data = [['2007'],
    ['', 'Q1', '', '', 'Q2'],
    ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    ['Min', '15.2', '12.5', '9.9', '70.0', '22.4', '21.5'],
    ['Max', '23.9', '14.2', '18.6', '71.3', '66.8', '42.6'], ];

$q = 1;

$__width = 350;
$__height = 200;
$graph = new CanvasGraph($__width, $__height);

$table = new GTextTable($cols, $rows);
$table->Init();
$table->Set($data);
$table->SetBorder(2, 'black');

// Setup top row with the year title
$table->MergeCells(0, 0, 0, 6);
$table->SetRowFont(0, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 16);
$table->SetRowColor(0, 'navy');
$table->SetRowAlign(0, 'center');

// Setup quarter header
$table->MergeCells(1, 1, 1, 3);
$table->MergeCells(1, 4, 1, 6);
$table->SetRowAlign(1, 'center');
$table->SetRowFont(1, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_BOLD'), 10);
$table->SetRowColor(1, 'navy');
$table->SetRowFillColor(1, 'lightgray');
$table->SetRowGrid(2, '', 0); // Turn off the gridline just under the top row

// Setup row and column headers
$table->SetRowFont(2, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_NORMAL'), 11);
$table->SetRowColor(2, 'navy');
$table->SetRowFillColor(2, 'lightgray');

$table->SetColFont(0, Configs::getConfig('FF_ARIAL'), Configs::getConfig('FS_NORMAL'), 11);
$table->SetColColor(0, 'navy');
$table->SetColFillColor(0, 'lightgray');

$table->SetCellFillColor(0, 0, 'lightgreen');
$table->SetCellFillColor(1, 0, 'lightgreen');
$table->SetCellFillColor(2, 0, 'lightgreen');

// Highlight cell 2,3
$table->SetCellFillColor(4, 3, 'yellow');

$graph->Add($table);
$graph->Stroke();
