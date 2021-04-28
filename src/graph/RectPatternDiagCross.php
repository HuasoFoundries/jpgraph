<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

/**
 * @class RectPatternDiagCross
  *  Vert/Hor crosses
 */
class RectPatternDiagCross extends RectPattern
{
    /**
     * @var RectPatternLDiag
     */
    private $left;

    /**
     * @var RectPatternRDiag
     */
    private $right;

    public function __construct($aColor = 'black', $aWeight = 1)
    {
        parent::__construct($aColor, $aWeight);
        $this->right = new RectPatternRDiag($aColor, $aWeight);
        $this->left = new RectPatternLDiag($aColor, $aWeight);
    }

    public function SetOrder($aDepth)
    {
        $this->left->SetOrder($aDepth);
        $this->right->SetOrder($aDepth);
    }

    public function SetPos($aRect)
    {
        parent::SetPos($aRect);
        $this->left->SetPos($aRect);
        $this->right->SetPos($aRect);
    }

    public function SetDensity($aDens)
    {
        $this->left->SetDensity($aDens);
        $this->right->SetDensity($aDens);
    }

    public function DoPattern($aImg)
    {
        $this->left->DoPattern($aImg);
        $this->right->DoPattern($aImg);
    }
}
