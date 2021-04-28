<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Text;

/**
 * @class GraphTabTitle
 * // Description: Draw "tab" titles on top of graphs
 */
class GraphTabTitle extends Text
{
    private $corner = 6;

    private $posx = 7;

    private $posy = 4;

    private $fillcolor = 'lightyellow';

    private $bordercolor = 'black';

    private $align = 'left';

    private $width = self::TABTITLE_WIDTHFIT;

    public function __construct()
    {
        $this->t = '';
        $this->font_style = self::FS_BOLD;
        $this->hide = true;
        $this->color = 'darkred';
    }

    public function SetColor($aTxtColor, $aFillColor = 'lightyellow', $aBorderColor = 'black')
    {
        $this->color = $aTxtColor;
        $this->fillcolor = $aFillColor;
        $this->bordercolor = $aBorderColor;
    }

    public function SetFillColor($aFillColor)
    {
        $this->fillcolor = $aFillColor;
    }

    public function SetTabAlign($aAlign)
    {
        $this->align = $aAlign;
    }

    public function SetWidth($aWidth)
    {
        $this->width = $aWidth;
    }

    public function Set($t)
    {
        $this->t = $t;
        $this->hide = false;
    }

    public function SetCorner($aD)
    {
        $this->corner = $aD;
    }

    public function Stroke($aImg, $aDummy1 = null, $aDummy2 = null)
    {
        if ($this->hide) {
            return;
        }

        $this->boxed = false;
        $w = $this->GetWidth($aImg) + 2 * $this->posx;
        $h = $this->GetTextHeight($aImg) + 2 * $this->posy;

        $x = $aImg->left_margin;
        $y = $aImg->top_margin;

        if (self::TABTITLE_WIDTHFIT === $this->width) {
            if ('left' === $this->align) {
                $p = [
                    $x,
                    $y,
                    $x,
                    $y - $h + $this->corner,
                    $x + $this->corner,
                    $y - $h,
                    $x + $w - $this->corner,
                    $y - $h,
                    $x + $w,
                    $y - $h + $this->corner,
                    $x + $w,
                    $y,
                ];
            } elseif ('center' === $this->align) {
                $x += \round($aImg->plotwidth / 2) - \round($w / 2);
                $p = [
                    $x,
                    $y,
                    $x,
                    $y - $h + $this->corner,
                    $x + $this->corner,
                    $y - $h,
                    $x + $w - $this->corner,
                    $y - $h,
                    $x + $w,
                    $y - $h + $this->corner,
                    $x + $w,
                    $y,
                ];
            } else {
                $x += $aImg->plotwidth - $w;
                $p = [
                    $x,
                    $y,
                    $x,
                    $y - $h + $this->corner,
                    $x + $this->corner,
                    $y - $h,
                    $x + $w - $this->corner,
                    $y - $h,
                    $x + $w,
                    $y - $h + $this->corner,
                    $x + $w,
                    $y,
                ];
            }
        } else {
            if (self::TABTITLE_WIDTHFULL === $this->width) {
                $w = $aImg->plotwidth;
            } else {
                $w = $this->width;
            }

            // Make the tab fit the width of the plot area
            $p = [
                $x,
                $y,
                $x,
                $y - $h + $this->corner,
                $x + $this->corner,
                $y - $h,
                $x + $w - $this->corner,
                $y - $h,
                $x + $w,
                $y - $h + $this->corner,
                $x + $w,
                $y,
            ];
        }

        if ('left' === $this->halign) {
            $aImg->SetTextAlign('left', 'bottom');
            $x += $this->posx;
            $y -= $this->posy;
        } elseif ('center' === $this->halign) {
            $aImg->SetTextAlign('center', 'bottom');
            $x += $w / 2;
            $y -= $this->posy;
        } else {
            $aImg->SetTextAlign('right', 'bottom');
            $x += $w - $this->posx;
            $y -= $this->posy;
        }

        $aImg->SetColor($this->fillcolor);
        $aImg->FilledPolygon($p);

        $aImg->SetColor($this->bordercolor);
        $aImg->Polygon($p, true);

        $aImg->SetColor($this->color);
        $aImg->SetFont($this->font_family, $this->font_style, $this->font_size);
        $aImg->StrokeText($x, $y, $this->t, 0, 'center');
    }
}
