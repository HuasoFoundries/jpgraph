<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_canvas.php';
require_once 'jpgraph/jpgraph_table.php';

$cols = 4;
$rows = 3;
$data = [['', 'Jan', 'Feb', 'Mar', 'Apr'],
    ['Min', '15.2', '12.5', '9.9', '70.0'],
    ['Max', '23.9', '14.2', '18.6', '71.3'], ];

// Setup basic graph canvas
$__width  = 300;
$__height = 200;
$graph    = new CanvasGraph($__width, $__height);

// Create a basic table
$table = new GTextTable($cols, $rows);
$table->Set($data);

$table->SetCellCSIMTarget(1, 1, 'tableex02.php', 'View details');

$table->SetRowFont(0, FF_FONT1, FS_BOLD);
$table->SetRowColor(0, 'navy');
$table->SetRowFillColor(0, 'lightgray');

$table->SetColFont(0, FF_FONT1, FS_BOLD);
$table->SetColColor(0, 'navy');
$table->SetColFillColor(0, 'lightgray');

$graph->Add($table);

$graph->StrokeCSIM();
