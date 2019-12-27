<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Text;

$__width  = 700;
$__height = 800;
$g        = new Graph\CanvasGraph($__width, $__height);

$g->SetScale('canvas', 0, 27, 0, 85);
$g->SetMargin(5, 6, 5, 6);
$g->SetColor('white');
$g->SetMarginColor('teal');
$g->InitFrame();
$example_title = 'Font demonstration on canvas';

$t = new Text\CanvasRectangleText();
$t->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 16);
$t->SetFillColor('lemonchiffon2');
$t->SetFontColor('black');
$t->Set("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nTTF Fonts (11pt)", 0.5, 19.5, 26, 64.5);
$t->Stroke($g->img, $g->scale);

$t->SetFillColor('lemonchiffon3');
$t->Set("\n\n\n\nBitmap Fonts", 0.5, 5, 26, 13.5);
$t->Stroke($g->img, $g->scale);

$t = new Text\CanvasRectangleText();
$t->SetFillColor('');
$t->SetFontColor('black');
$t->SetColor('');
$t->SetShadow('');

$t->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 18);
$t->Set('Normal', 1, 1, 8);
$t->Stroke($g->img, $g->scale);

$t->Set('Italic style', 9, 1, 8);
$t->Stroke($g->img, $g->scale);

$t->Set('Bold style', 17.5, 1, 8);
$t->Stroke($g->img, $g->scale);

$t->SetFillColor('yellow');
$t->SetFontColor('black');
$t->SetColor('black');
$t->SetShadow('gray');

$r = 6;
$c = 1;
$w = 7.5;
$h = 3.5;

$fonts = [
    ['Font 0', Graph\Configs::getConfig('FF_FONT0'), Graph\Configs::getConfig('FS_NORMAL')],
    ['', Graph\Configs::getConfig('FF_FONT0'), Graph\Configs::getConfig('FS_ITALIC')],
    ['', Graph\Configs::getConfig('FF_FONT0'), Graph\Configs::getConfig('FS_BOLD')],

    ['Font 1', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_NORMAL')],
    ['', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Font 1 bold', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD')],

    ['Font 2', Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_NORMAL')],
    ['', Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Font 2 bold', Graph\Configs::getConfig('FF_FONT2'), Graph\Configs::getConfig('FS_BOLD')],

    ['Arial', Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Arial italic', Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Arial bold', Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD')],

    ['Verdana', Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Verdana italic', Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Verdana bold', Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD')],

    ['Trebuche', Graph\Configs::getConfig('FF_TREBUCHE'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Trebuche italic', Graph\Configs::getConfig('FF_TREBUCHE'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Trebuche bold', Graph\Configs::getConfig('FF_TREBUCHE'), Graph\Configs::getConfig('FS_BOLD')],

    ['Georgia', Graph\Configs::getConfig('FF_GEORGIA'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Georgia italic', Graph\Configs::getConfig('FF_GEORGIA'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Georgia bold', Graph\Configs::getConfig('FF_GEORGIA'), Graph\Configs::getConfig('FS_BOLD')],

    ['Comic', Graph\Configs::getConfig('FF_COMIC'), Graph\Configs::getConfig('FS_NORMAL')],
    ['', Graph\Configs::getConfig('FF_COMIC'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Comic bold', Graph\Configs::getConfig('FF_COMIC'), Graph\Configs::getConfig('FS_BOLD')],

    ['Courier', Graph\Configs::getConfig('FF_COURIER'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Courier italic', Graph\Configs::getConfig('FF_COURIER'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Courier bold', Graph\Configs::getConfig('FF_COURIER'), Graph\Configs::getConfig('FS_BOLD')],

    ['Times normal', Graph\Configs::getConfig('FF_TIMES'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Times italic', Graph\Configs::getConfig('FF_TIMES'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Times bold', Graph\Configs::getConfig('FF_TIMES'), Graph\Configs::getConfig('FS_BOLD')],

    ['Vera normal', Graph\Configs::getConfig('FF_VERA'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Vera italic', Graph\Configs::getConfig('FF_VERA'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Vera bold', Graph\Configs::getConfig('FF_VERA'), Graph\Configs::getConfig('FS_BOLD')],

    ['Vera mono normal', Graph\Configs::getConfig('FF_VERAMONO'), Graph\Configs::getConfig('FS_NORMAL')],
    ['Vera mono italic', Graph\Configs::getConfig('FF_VERAMONO'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Vera mono bold', Graph\Configs::getConfig('FF_VERAMONO'), Graph\Configs::getConfig('FS_BOLD')],

    ['Vera serif normal', Graph\Configs::getConfig('FF_VERASERIF'), Graph\Configs::getConfig('FS_NORMAL')],
    ['', Graph\Configs::getConfig('FF_VERASERIF'), Graph\Configs::getConfig('FS_ITALIC')],
    ['Vera serif bold', Graph\Configs::getConfig('FF_VERASERIF'), Graph\Configs::getConfig('FS_BOLD')],

    ['DejaVu sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIF'), Graph\Configs::getConfig('FS_NORMAL')],
    ['DejaVu sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIF'), Graph\Configs::getConfig('FS_ITALIC')],
    ['DejaVu sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIF'), Graph\Configs::getConfig('FS_BOLD')],

    ['DejaVu serif', Graph\Configs::getConfig('FF_DV_SERIF'), Graph\Configs::getConfig('FS_NORMAL')],
    ['DejaVu serif', Graph\Configs::getConfig('FF_DV_SERIF'), Graph\Configs::getConfig('FS_ITALIC')],
    ['DejaVu serif', Graph\Configs::getConfig('FF_DV_SERIF'), Graph\Configs::getConfig('FS_BOLD')],

    ['DejaVuMono sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIFMONO'), Graph\Configs::getConfig('FS_NORMAL')],
    ['DejaVuMono sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIFMONO'), Graph\Configs::getConfig('FS_ITALIC')],
    ['DejaVuMono sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIFMONO'), Graph\Configs::getConfig('FS_BOLD')],

    ['DejaVuCond serif', Graph\Configs::getConfig('FF_DV_SERIFCOND'), Graph\Configs::getConfig('FS_NORMAL')],
    ['DejaVuCond serif', Graph\Configs::getConfig('FF_DV_SERIFCOND'), Graph\Configs::getConfig('FS_ITALIC')],
    ['DejaVuCond serif', Graph\Configs::getConfig('FF_DV_SERIFCOND'), Graph\Configs::getConfig('FS_BOLD')],

    ['DejaVuCond sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIFCOND'), Graph\Configs::getConfig('FS_NORMAL')],
    ['DejaVuCond sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIFCOND'), Graph\Configs::getConfig('FS_ITALIC')],
    ['DejaVuCond sans serif', Graph\Configs::getConfig('FF_DV_SANSSERIFCOND'), Graph\Configs::getConfig('FS_BOLD')],
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
        $t->Stroke($g->img, $g->scale);
    }

    $c += $w + 1;
    if ($c > 30 - $w - 2) {
        $c = 1;
        $r += 4;
    }
}

$g->Stroke();
