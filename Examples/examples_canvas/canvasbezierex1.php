<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;

// Setup canvas graph
$__width = 400;
$__height = 300;
$g = new Graph\CanvasGraph($__width, $__height);
$g->SetScale();
$shape = new Graph\Shape($g, $g->getScale());
$example_title = 'Bezier line with control points';
$g->title->set($example_title);

// Setup control point for bezier
$p = [3, 6,
    6, 9,
    5, 3,
    7, 4, ];

// Visualize control points
$shape->SetColor('blue');
$shape->Line($p[0], $p[1], $p[2], $p[3]);
$shape->FilledCircle($p[2], $p[3], -6);

$shape->SetColor('red');
$shape->Line($p[4], $p[5], $p[6], $p[7]);
$shape->FilledCircle($p[4], $p[5], -6);

// Draw bezier
$shape->SetColor('black');
$shape->Bezier($p);

// Frame it with a square
$shape->SetColor('navy');
$shape->Rectangle(0.5, 2, 9.5, 9.5);

// ... and stroke it
$g->Stroke();
