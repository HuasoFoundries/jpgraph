<?php

/**
 * JPGraph - Community Edition
 */

/**
 * JPGraph v4.1.0-beta.01.
 */
class Rectangle
{
    public $x;

    public $y;

    public $w;

    public $h;

    public $xe;

    public $ye;

    public function __construct($aX, $aY, $aWidth, $aHeight)
    {
        $this->x = $aX;
        $this->y = $aY;
        $this->w = $aWidth;
        $this->h = $aHeight;
        $this->xe = $aX + $aWidth - 1;
        $this->ye = $aY + $aHeight - 1;
    }
}
