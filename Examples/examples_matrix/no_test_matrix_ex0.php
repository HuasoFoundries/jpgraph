<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;

require_once 'jpgraph/jpgraph_matrix.php';

// Some (random) matrix
$data = [
    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    [10, 9, 8, 17, 6, 5, 4, 3, 2, 1, 0],
    [0, 1, 2, 3, 4, 4, 9, 7, 8, 9, 10],
    [8, 1, 2, 3, 4, 8, 3, 7, 8, 9, 10],
    [10, 3, 5, 7, 6, 5, 4, 3, 12, 1, 0],
    [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
];

// Setup a bsic matrix graph and title
$__width  = 400;
$__height = 300;
$graph    = new MatrixGraph($__width, $__height);
$graph->title->Set('Basic matrix example');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

// Create a ,atrix plot using all default values
$mp = new MatrixPlot($data);
$graph->Add($mp);

$graph->Stroke();
