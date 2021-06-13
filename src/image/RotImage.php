<?php

/**
 * JPGraph v4.1.0-beta.01
 */

namespace Amenadiel\JpGraph\Image;

use Amenadiel\JpGraph\Util\JpGraphError;

use function cos;
use const M_PI;
use function round;
use function sin;

/**
 * @class RotImage
 * // Description: Exactly as Image but draws the image at
 * // a specified angle around a specified rotation point.
 */
class RotImage extends Image
{
    public $a      = 0;
    public $dx     = 0;
    public $dy     = 0;
    public $transx = 0;
    public $transy = 0;
    private $m     = [];

    public function __construct($aWidth, $aHeight, $a = 0, $aFormat = Configs::DEFAULT_GFORMAT, $aSetAutoMargin = true)
    {
        parent::__construct($aWidth, $aHeight, $aFormat, $aSetAutoMargin);
        $this->dx = $this->left_margin + $this->plotwidth / 2;
        $this->dy = $this->top_margin + $this->plotheight / 2;
        $this->SetAngle($a);
    }
    // Draw text with a box around it
    public function StrokeBoxedText(
        $x,
        $y,
        $txt,
        $dir = 0,
        $fcolor = 'white',
        $bcolor = 'black',
        $shadowcolor = false,
        $paragraph_align = 'left',
        $xmarg = 6,
        $ymarg = 4,
        $cornerradius = 0,
        $dropwidth = 3
    ) {
        $oldx = $this->lastx;
        $oldy = $this->lasty;

        if (!is_numeric($dir)) {
            if ($dir == 'h') {
                $dir = 0;
            } elseif ($dir == 'v') {
                $dir = 90;
            } else {
                throw      JpGraphError::make(25090, $dir);
            }
            //(" Unknown direction specified in call to StrokeBoxedText() [$dir]");
        }

        if ($this->font_family >= Configs::FF_FONT0 && $this->font_family <= Configs::FF_FONT2 + 1) {
            $width  = $this->GetTextWidth($txt, $dir);
            $height = $this->GetTextHeight($txt, $dir);
        } else {
            $width  = $this->GetBBoxWidth($txt, $dir);
            $height = $this->GetBBoxHeight($txt, $dir);
        }

        $height += 2 * $ymarg;
        $width += 2 * $xmarg;

        if ($this->text_halign == 'right') {
            $x -= $width;
        } elseif ($this->text_halign == 'center') {
            $x -= $width / 2;
        }

        if ($this->text_valign == 'bottom') {
            $y -= $height;
        } elseif ($this->text_valign == 'center') {
            $y -= $height / 2;
        }

        $olda = $this->SetAngle(0);

        if ($shadowcolor) {
            $this->PushColor($shadowcolor);
            $this->FilledRoundedRectangle(
                $x - $xmarg + $dropwidth,
                $y - $ymarg + $dropwidth,
                $x + $width + $dropwidth,
                $y + $height - $ymarg + $dropwidth,
                $cornerradius
            );
            $this->PopColor();
            $this->PushColor($fcolor);
            $this->FilledRoundedRectangle(
                $x - $xmarg,
                $y - $ymarg,
                $x + $width,
                $y + $height - $ymarg,
                $cornerradius
            );
            $this->PopColor();
            $this->PushColor($bcolor);
            $this->RoundedRectangle(
                $x - $xmarg,
                $y - $ymarg,
                $x + $width,
                $y + $height - $ymarg,
                $cornerradius
            );
            $this->PopColor();
        } else {
            if ($fcolor) {
                $oc = $this->current_color;
                $this->SetColor($fcolor);
                $this->FilledRoundedRectangle($x - $xmarg, $y - $ymarg, $x + $width, $y + $height - $ymarg, $cornerradius);
                $this->current_color = $oc;
            }
            if ($bcolor) {
                $oc = $this->current_color;
                $this->SetColor($bcolor);
                $this->RoundedRectangle($x - $xmarg, $y - $ymarg, $x + $width, $y + $height - $ymarg, $cornerradius);
                $this->current_color = $oc;
            }
        }

        $h = $this->text_halign;
        $v = $this->text_valign;
        $this->SetTextAlign('left', 'top');

        $debug = false;
        $this->StrokeText($x, $y, $txt, $dir, $paragraph_align, $debug);

        $bb = [
            $x - $xmarg,
            $y + $height - $ymarg,
            $x + $width,
            $y + $height - $ymarg,
            $x + $width,
            $y - $ymarg,
            $x - $xmarg,
            $y - $ymarg,
        ];
        $this->SetTextAlign($h, $v);

        $this->SetAngle($olda);
        $this->lastx = $oldx;
        $this->lasty = $oldy;

        return $bb;
    }

    // Draw text with a box around it. This time the box will be rotated
    // with the text. The previous method will just make a larger enough non-rotated
    // box to hold the text inside.
    public function StrokeBoxedText2(
        $x,
        $y,
        $txt,
        $dir = 0,
        $fcolor = 'white',
        $bcolor = 'black',
        $shadowcolor = false,
        $paragraph_align = 'left',
        $xmarg = 6,
        $ymarg = 4,
        $cornerradius = 0,
        $dropwidth = 3
    ) {
        // This version of boxed text will stroke a rotated box round the text
        // thta will follow the angle of the text.
        // This has two implications:
        // 1) This methos will only support TTF fonts
        // 2) The only two alignment that makes sense are centered or baselined

        if ($this->font_family <= Configs::FF_FONT2 + 1) {
            throw      JpGraphError::make(25131); //StrokeBoxedText2() Only support TTF fonts and not built in bitmap fonts
        }

        $oldx = $this->lastx;
        $oldy = $this->lasty;
        $dir  = $this->NormAngle($dir);

        if (!is_numeric($dir)) {
            if ($dir == 'h') {
                $dir = 0;
            } elseif ($dir == 'v') {
                $dir = 90;
            } else {
                throw      JpGraphError::make(25090, $dir);
            }
            //(" Unknown direction specified in call to StrokeBoxedText() [$dir]");
        }

        $width       = $this->GetTextWidth($txt, 0) + 2 * $xmarg;
        $height      = $this->GetTextHeight($txt, 0) + 2 * $ymarg;
        $rect_width  = $this->GetBBoxWidth($txt, $dir);
        $rect_height = $this->GetBBoxHeight($txt, $dir);

        $baseline_offset = $this->bbox_cache[1] - 1;

        if ($this->text_halign == 'center') {
            if ($dir >= 0 && $dir <= 90) {
                $x -= $rect_width / 2;
                $x += sin($dir * M_PI / 180) * $height;
                $y += $rect_height / 2;
            } elseif ($dir >= 270 && $dir <= 360) {
                $x -= $rect_width / 2;
                $y -= $rect_height / 2;
                $y += cos($dir * M_PI / 180) * $height;
            } elseif ($dir >= 90 && $dir <= 180) {
                $x += $rect_width / 2;
                $y += $rect_height / 2;
                $y += cos($dir * M_PI / 180) * $height;
            } else {
                // $dir > 180 &&  $dir < 270
                $x += $rect_width / 2;
                $x += sin($dir * M_PI / 180) * $height;
                $y -= $rect_height / 2;
            }
        }

        // Rotate the box around this point
        $this->SetCenter($x, $y);
        $olda = $this->SetAngle(-$dir);

        // We need to use adjusted coordinats for the box to be able
        // to draw the box below the baseline. This cannot be done before since
        // the rotating point must be the original x,y since that is arounbf the
        // point where the text will rotate and we cannot change this since
        // that is where the GD/GreeType will rotate the text

        // For smaller <14pt font we need to do some additional
        // adjustments to make it look good
        if ($this->font_size < 14) {
            $x -= 2;
            $y += 2;
        }
        //  $y += $baseline_offset;

        if ($shadowcolor) {
            $this->PushColor($shadowcolor);
            $this->FilledRectangle(
                $x - $xmarg + $dropwidth,
                $y + $ymarg + $dropwidth - $height,
                $x + $width + $dropwidth,
                $y + $ymarg + $dropwidth
            );
            //$cornerradius);
            $this->PopColor();
            $this->PushColor($fcolor);
            $this->FilledRectangle(
                $x - $xmarg,
                $y + $ymarg - $height,
                $x + $width,
                $y + $ymarg
            );
            //$cornerradius);
            $this->PopColor();
            $this->PushColor($bcolor);
            $this->Rectangle(
                $x - $xmarg,
                $y + $ymarg - $height,
                $x + $width,
                $y + $ymarg
            );
            //$cornerradius);
            $this->PopColor();
        } else {
            if ($fcolor) {
                $oc = $this->current_color;
                $this->SetColor($fcolor);
                $this->FilledRectangle($x - $xmarg, $y + $ymarg - $height, $x + $width, $y + $ymarg); //,$cornerradius);
                $this->current_color = $oc;
            }
            if ($bcolor) {
                $oc = $this->current_color;
                $this->SetColor($bcolor);
                $this->Rectangle($x - $xmarg, $y + $ymarg - $height, $x + $width, $y + $ymarg); //,$cornerradius);
                $this->current_color = $oc;
            }
        }

        if ($this->font_size < 14) {
            $x += 2;
            $y -= 2;
        }

        // Restore the original y before we stroke the text
        // $y -= $baseline_offset;

        $this->SetCenter(0, 0);
        $this->SetAngle($olda);

        $h = $this->text_halign;
        $v = $this->text_valign;
        if ($this->text_halign == 'center') {
            $this->SetTextAlign('center', 'basepoint');
        } else {
            $this->SetTextAlign('basepoint', 'basepoint');
        }

        $debug = false;
        $this->StrokeText($x, $y, $txt, $dir, $paragraph_align, $debug);

        $bb = [
            $x - $xmarg,
            $y + $height - $ymarg,
            $x + $width,
            $y + $height - $ymarg,
            $x + $width,
            $y - $ymarg,
            $x - $xmarg,
            $y - $ymarg,
        ];

        $this->SetTextAlign($h, $v);
        $this->SetAngle($olda);

        $this->lastx = $oldx;
        $this->lasty = $oldy;

        return $bb;
    }

    public function SetCenter($dx, $dy)
    {
        $old_dx   = $this->dx;
        $old_dy   = $this->dy;
        $this->dx = $dx;
        $this->dy = $dy;
        $this->SetAngle($this->a);

        return [$old_dx, $old_dy];
    }

    public function SetTranslation($dx, $dy)
    {
        $old          = [$this->transx, $this->transy];
        $this->transx = $dx;
        $this->transy = $dy;

        return $old;
    }

    public function UpdateRotMatrice()
    {
        $a = $this->a;
        $a *= M_PI / 180;
        $sa = sin($a);
        $ca = cos($a);
        // Create the rotation matrix
        $this->m[0][0] = $ca;
        $this->m[0][1] = -$sa;
        $this->m[0][2] = $this->dx * (1 - $ca) + $sa * $this->dy;
        $this->m[1][0] = $sa;
        $this->m[1][1] = $ca;
        $this->m[1][2] = $this->dy * (1 - $ca) - $sa * $this->dx;
    }

    public function SetAngle($a)
    {
        $tmp     = $this->a;
        $this->a = $a;
        $this->UpdateRotMatrice();

        return $tmp;
    }

    public function Circle($xc, $yc, $r)
    {
        list($xc, $yc) = $this->Rotate($xc, $yc);
        parent::Circle($xc, $yc, $r);
    }

    public function FilledCircle($xc, $yc, $r)
    {
        list($xc, $yc) = $this->Rotate($xc, $yc);
        parent::FilledCircle($xc, $yc, $r);
    }

    public function Arc($xc, $yc, $w, $h, $s, $e)
    {
        list($xc, $yc) = $this->Rotate($xc, $yc);
        $s += $this->a;
        $e += $this->a;
        parent::Arc($xc, $yc, $w, $h, $s, $e);
    }

    public function FilledArc($xc, $yc, $w, $h, $s, $e, $style = '')
    {
        list($xc, $yc) = $this->Rotate($xc, $yc);
        $s += $this->a;
        $e += $this->a;
        parent::FilledArc($xc, $yc, $w, $h, $s, $e);
    }

    public function SetMargin($lm, $rm, $tm, $bm)
    {
        parent::SetMargin($lm, $rm, $tm, $bm);
        $this->dx = $this->left_margin + $this->plotwidth / 2;
        $this->dy = $this->top_margin + $this->plotheight / 2;
        $this->UpdateRotMatrice();
    }

    public function Rotate($x, $y)
    {
        // Optimization. Ignore rotation if Angle==0 || Angle==360
        if ($this->a == 0 || $this->a == 360) {
            return [$x + $this->transx, $y + $this->transy];
        }
        $x1 = round($this->m[0][0] * $x + $this->m[0][1] * $y, 1) + $this->m[0][2] + $this->transx;
        $y1 = round($this->m[1][0] * $x + $this->m[1][1] * $y, 1) + $this->m[1][2] + $this->transy;

        return [$x1, $y1];
    }

    public function CopyMerge($fromImg, $toX, $toY, $fromX, $fromY, $toWidth, $toHeight, $fromWidth = -1, $fromHeight = -1, $aMix = 100)
    {
        list($toX, $toY) = $this->Rotate($toX, $toY);
        parent::CopyMerge($fromImg, $toX, $toY, $fromX, $fromY, $toWidth, $toHeight, $fromWidth, $fromHeight, $aMix);
    }

    public function ArrRotate($pnts)
    {
        $n = Configs::safe_count($pnts) - 1;
        for ($i = 0; $i < $n; $i += 2) {
            list($x, $y)  = $this->Rotate($pnts[$i], $pnts[$i + 1]);
            $pnts[$i]     = $x;
            $pnts[$i + 1] = $y;
        }

        return $pnts;
    }

    public function DashedLine($x1, $y1, $x2, $y2, $dash_length = 1, $dash_space = 4)
    {
        list($x1, $y1) = $this->Rotate($x1, $y1);
        list($x2, $y2) = $this->Rotate($x2, $y2);
        parent::DashedLine($x1, $y1, $x2, $y2, $dash_length, $dash_space);
    }

    public function Line($x1, $y1, $x2, $y2)
    {
        list($x1, $y1) = $this->Rotate($x1, $y1);
        list($x2, $y2) = $this->Rotate($x2, $y2);
        parent::Line($x1, $y1, $x2, $y2);
    }

    public function Rectangle($x1, $y1, $x2, $y2)
    {
        // Rectangle uses Line() so it will be rotated through that call
        parent::Rectangle($x1, $y1, $x2, $y2);
    }

    public function FilledRectangle($x1, $y1, $x2, $y2)
    {
        if ($y1 == $y2 || $x1 == $x2) {
            $this->Line($x1, $y1, $x2, $y2);
        } else {
            $this->FilledPolygon([$x1, $y1, $x2, $y1, $x2, $y2, $x1, $y2]);
        }
    }

    public function Polygon($pnts, $closed = false, $fast = false)
    {
        // Polygon uses Line() so it will be rotated through that call unless
        // fast drawing routines are used in which case a rotate is needed
        if ($fast) {
            parent::Polygon($this->ArrRotate($pnts));
        } else {
            parent::Polygon($pnts, $closed, $fast);
        }
    }

    public function FilledPolygon($pnts)
    {
        parent::FilledPolygon($this->ArrRotate($pnts));
    }

    public function Point($x, $y)
    {
        list($xp, $yp) = $this->Rotate($x, $y);
        parent::Point($xp, $yp);
    }

    public function StrokeText($x, $y, $txt, $dir = 0, $paragraph_align = 'left', $debug = false)
    {
        list($xp, $yp) = $this->Rotate($x, $y);

        return parent::StrokeText($xp, $yp, $txt, $dir, $paragraph_align, $debug);
    }
}
