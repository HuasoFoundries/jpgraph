<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Text;

// Setup a basic canvas we can work
$__width  = 400;
$__height = 300;
$g        = new Graph\CanvasGraph($__width, $__height, 'auto');
$g->SetMargin(5, 11, 6, 11);
$g->SetShadow();
$g->SetMarginColor('teal');

// We need to stroke the plotarea and margin before we add the
// text since we otherwise would overwrite the text.
$g->InitFrame();

// Draw a text box in the middle
$txt = "This\nis\na TEXT!!!";
$t   = new Text\Text($txt, 200, 10);
$t->SetFont(FF_ARIAL, FS_BOLD, 40);

// How should the text box interpret the coordinates?
$t->Align('center', 'top');

// How should the paragraph be aligned?
$t->ParagraphAlign('center');

// Add a box around the text, white fill, black border and gray shadow
$t->SetBox('white', 'black', 'gray');

// Stroke the text
$t->Stroke($g->img);

// Stroke the graph
$g->Stroke();
