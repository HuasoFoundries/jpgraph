<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

require_once 'jpgraph/jpgraph_canvas.php';

// Caption below the image
$txt = "The day was rapidly becoming more and\nmore strange.\n\nNot only had he managed to\nget by the first pass without so much as\na hint of questions but now when he\ncould feel that the second pass wouldn't\nlong be noone had yet seen him.";

$w = 950;
$h = 250;
$xm = 20;
$ym = 20;
$tw = 300;

$g = new CanvasGraph($w, $h);
$img = $g->img;

// Alignment for anchor points to use
$palign = ['left', 'center', 'right'];

$n = \count($palign);
$t = new Text($txt);

$y = $ym;

for ($i = 0; $i < $n; ++$i) {
    $x = $xm + $i * $tw;

    $t->SetColor('black');
    $t->SetAlign('left', 'top');
    $t->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 11);
    $t->SetBox();
    $t->SetParagraphAlign($palign[$i]);
    $t->Stroke($img, $x, $y);

    $img->SetColor('black');
    $img->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
    $img->SetTextAlign('center', 'top');
    $img->StrokeText($x + 140, $y + 160, '"' . $palign[$i] . '"' . ' pargraph align');
}

// .. and send back to browser
$g->Stroke();
