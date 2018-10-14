<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
require_once 'jpgraph/jpgraph_canvas.php';
require_once 'jpgraph/jpgraph_canvtools.php';

$width  = 700;
$height = 800;
$g      = new CanvasGraph($width, $height);
$scale  = new CanvasScale($g);
$scale->Set(0, 27, 0, 85);
$g->SetMargin(5, 6, 5, 6);
$g->SetColor('white');
$g->SetMarginColor('teal');
$g->InitFrame();

$t = new CanvasRectangleText();
$t->SetFont(FF_ARIAL, FS_NORMAL, 16);
$t->SetFillColor('lemonchiffon2');
$t->SetFontColor('black');
$t->Set("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nTTF Fonts (11pt)", 0.5, 19.5, 26, 64.5);
$t->Stroke($g->img, $scale);

$t->SetFillColor('lemonchiffon3');
$t->Set("\n\n\n\nBitmap Fonts", 0.5, 5, 26, 13.5);
$t->Stroke($g->img, $scale);

$t = new CanvasRectangleText();
$t->SetFillColor('');
$t->SetFontColor('black');
$t->SetColor('');
$t->SetShadow('');

$t->SetFont(FF_ARIAL, FS_BOLD, 18);
$t->Set('Normal', 1, 1, 8);
$t->Stroke($g->img, $scale);

$t->Set('Italic style', 9, 1, 8);
$t->Stroke($g->img, $scale);

$t->Set('Bold style', 17.5, 1, 8);
$t->Stroke($g->img, $scale);

$t->SetFillColor('yellow');
$t->SetFontColor('black');
$t->SetColor('black');
$t->SetShadow('gray');

$r = 6;
$c = 1;
$w = 7.5;
$h = 3.5;

$fonts = [
    ['Font 0', FF_FONT0, FS_NORMAL],
    ['', FF_FONT0, FS_ITALIC],
    ['', FF_FONT0, FS_BOLD],

    ['Font 1', FF_FONT1, FS_NORMAL],
    ['', FF_FONT1, FS_ITALIC],
    ['Font 1 bold', FF_FONT1, FS_BOLD],

    ['Font 2', FF_FONT2, FS_NORMAL],
    ['', FF_FONT2, FS_ITALIC],
    ['Font 2 bold', FF_FONT2, FS_BOLD],

    ['Arial', FF_ARIAL, FS_NORMAL],
    ['Arial italic', FF_ARIAL, FS_ITALIC],
    ['Arial bold', FF_ARIAL, FS_BOLD],

    ['Verdana', FF_VERDANA, FS_NORMAL],
    ['Verdana italic', FF_VERDANA, FS_ITALIC],
    ['Verdana bold', FF_VERDANA, FS_BOLD],

    ['Trebuche', FF_TREBUCHE, FS_NORMAL],
    ['Trebuche italic', FF_TREBUCHE, FS_ITALIC],
    ['Trebuche bold', FF_TREBUCHE, FS_BOLD],

    ['Georgia', FF_GEORGIA, FS_NORMAL],
    ['Georgia italic', FF_GEORGIA, FS_ITALIC],
    ['Georgia bold', FF_GEORGIA, FS_BOLD],

    ['Comic', FF_COMIC, FS_NORMAL],
    ['', FF_COMIC, FS_ITALIC],
    ['Comic bold', FF_COMIC, FS_BOLD],

    ['Courier', FF_COURIER, FS_NORMAL],
    ['Courier italic', FF_COURIER, FS_ITALIC],
    ['Courier bold', FF_COURIER, FS_BOLD],

    ['Times normal', FF_TIMES, FS_NORMAL],
    ['Times italic', FF_TIMES, FS_ITALIC],
    ['Times bold', FF_TIMES, FS_BOLD],

    ['Vera normal', FF_VERA, FS_NORMAL],
    ['Vera italic', FF_VERA, FS_ITALIC],
    ['Vera bold', FF_VERA, FS_BOLD],

    ['Vera mono normal', FF_VERAMONO, FS_NORMAL],
    ['Vera mono italic', FF_VERAMONO, FS_ITALIC],
    ['Vera mono bold', FF_VERAMONO, FS_BOLD],

    ['Vera serif normal', FF_VERASERIF, FS_NORMAL],
    ['', FF_VERASERIF, FS_ITALIC],
    ['Vera serif bold', FF_VERASERIF, FS_BOLD],

    ['DejaVu sans serif', FF_DV_SANSSERIF, FS_NORMAL],
    ['DejaVu sans serif', FF_DV_SANSSERIF, FS_ITALIC],
    ['DejaVu sans serif', FF_DV_SANSSERIF, FS_BOLD],

    ['DejaVu serif', FF_DV_SERIF, FS_NORMAL],
    ['DejaVu serif', FF_DV_SERIF, FS_ITALIC],
    ['DejaVu serif', FF_DV_SERIF, FS_BOLD],

    ['DejaVuMono sans serif', FF_DV_SANSSERIFMONO, FS_NORMAL],
    ['DejaVuMono sans serif', FF_DV_SANSSERIFMONO, FS_ITALIC],
    ['DejaVuMono sans serif', FF_DV_SANSSERIFMONO, FS_BOLD],

    ['DejaVuCond serif', FF_DV_SERIFCOND, FS_NORMAL],
    ['DejaVuCond serif', FF_DV_SERIFCOND, FS_ITALIC],
    ['DejaVuCond serif', FF_DV_SERIFCOND, FS_BOLD],

    ['DejaVuCond sans serif', FF_DV_SANSSERIFCOND, FS_NORMAL],
    ['DejaVuCond sans serif', FF_DV_SANSSERIFCOND, FS_ITALIC],
    ['DejaVuCond sans serif', FF_DV_SANSSERIFCOND, FS_BOLD],
];

$n = count($fonts);

for ($i = 0; $i < $n; ++$i) {
    if ($i == 9) {
        $r += 3;
    }

    if ($fonts[$i][0]) {
        $t->SetTxt($fonts[$i][0]);
        $t->SetPos($c, $r, $w, $h);
        $t->SetFont($fonts[$i][1], $fonts[$i][2], 11);
        $t->Stroke($g->img, $scale);
    }

    $c += $w + 1;
    if ($c > 30 - $w - 2) {
        $c = 1;
        $r += 4;
    }
}

$g->Stroke();
