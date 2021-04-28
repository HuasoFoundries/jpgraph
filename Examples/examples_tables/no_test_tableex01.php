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
$data = [['', 'Jan', 'Feb', 'Mar', 'Apr'],
    ['Min', '15.2', '12.5', '9.9', '70.0'],
    ['Max', '23.9', '14.2', '18.6', '71.3'], ];

$__width = 300;
$__height = 200;
$graph = new CanvasGraph($__width, $__height);

$table = new GTextTable($cols, $rows);
$table->Init();
$table->Set($data);

$table->SetRowFont(0, Configs::getConfig('FF_FONT1'), Configs::getConfig('FS_BOLD'));
$table->SetRowColor(0, 'navy');
$table->SetRowFillColor(0, 'lightgray');

$table->SetColFont(0, Configs::getConfig('FF_FONT1'), Configs::getConfig('FS_BOLD'));
$table->SetColColor(0, 'navy');
$table->SetColFillColor(0, 'lightgray');

$graph->Add($table);
$graph->Stroke();
