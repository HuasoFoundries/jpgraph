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

    public function SetColor($aColor, $aFillColor = 'lightyellow', $aBorderColor = 'black')
    {
        $this->color = $aColor;
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

    public function Set($aTxt)
    {
        $this->t = $aTxt;
        $this->hide = false;
    }

    public function SetCorner($aD)
    {
        $this->corner = $aD;
    }

    public function Stroke($aImg, $x = null, $y = null)
    {
        if ($this->hide) {
            return;
        }

        $this->boxed = false;
        $w = $this->GetWidth($aImg) + 2 * $this->posx;
        $h = $this->GetTextHeight($aImg) + 2 * $this->posy;

        $x_new = $aImg->left_margin;
        $y_new = $aImg->top_margin;

        if (self::TABTITLE_WIDTHFIT === $this->width) {
            if ('left' === $this->align) {
                $p = [
                    $x_new,
                    $y_new,
                    $x_new,
                    $y_new - $h + $this->corner,
                    $x_new + $this->corner,
                    $y_new - $h,
                    $x_new + $w - $this->corner,
                    $y_new - $h,
                    $x_new + $w,
                    $y_new - $h + $this->corner,
                    $x_new + $w,
                    $y_new,
                ];
            } elseif ('center' === $this->align) {
                $x_new += \round($aImg->plotwidth / 2) - \round($w / 2);
                $p = [
                    $x_new,
                    $y_new,
                    $x_new,
                    $y_new - $h + $this->corner,
                    $x_new + $this->corner,
                    $y_new - $h,
                    $x_new + $w - $this->corner,
                    $y_new - $h,
                    $x_new + $w,
                    $y_new - $h + $this->corner,
                    $x_new + $w,
                    $y_new,
                ];
            } else {
                $x_new += $aImg->plotwidth - $w;
                $p = [
                    $x_new,
                    $y_new,
                    $x_new,
                    $y_new - $h + $this->corner,
                    $x_new + $this->corner,
                    $y_new - $h,
                    $x_new + $w - $this->corner,
                    $y_new - $h,
                    $x_new + $w,
                    $y_new - $h + $this->corner,
                    $x_new + $w,
                    $y_new,
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
                $x_new,
                $y_new,
                $x_new,
                $y_new - $h + $this->corner,
                $x_new + $this->corner,
                $y_new - $h,
                $x_new + $w - $this->corner,
                $y_new - $h,
                $x_new + $w,
                $y_new - $h + $this->corner,
                $x_new + $w,
                $y_new,
            ];
        }

        if ('left' === $this->halign) {
            $aImg->SetTextAlign('left', 'bottom');
            $x_new += $this->posx;
            $y_new -= $this->posy;
        } elseif ('center' === $this->halign) {
            $aImg->SetTextAlign('center', 'bottom');
            $x_new += $w / 2;
            $y_new -= $this->posy;
        } else {
            $aImg->SetTextAlign('right', 'bottom');
            $x_new += $w - $this->posx;
            $y_new -= $this->posy;
        }

        $aImg->SetColor($this->fillcolor);
        $aImg->FilledPolygon($p);

        $aImg->SetColor($this->bordercolor);
        $aImg->Polygon($p, true);

        $aImg->SetColor($this->color);
        $aImg->SetFont($this->font_family, $this->font_style, $this->font_size);
        $aImg->StrokeText($x_new, $y_new, $this->t, 0, 'center');
    }
}
