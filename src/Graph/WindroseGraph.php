<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Text;
use Amenadiel\JpGraph\Util;

/**
 * @class WindroseGraph
 */
class WindroseGraph extends Graph
{
    public $plots = [];

    private $posx;

    private $posy;

    public function __construct($width = 300, $height = 200, $cachedName = '', $timeout = 0, $inline = 1)
    {
        parent::__construct($width, $height, $cachedName, $timeout, $inline);
        $this->posx = $width / 2;
        $this->posy = $height / 2;
        $this->SetColor('white');
        $this->title->SetFont(
            Configs::getConfig('FF_VERDANA'),
            Configs::getConfig('FS_NORMAL'),
            12
        );
        $this->title->SetMargin(8);
        $this->subtitle->SetFont(
            Configs::getConfig('FF_VERDANA'),
            Configs::getConfig('FS_NORMAL'),
            10
        );
        $this->subtitle->SetMargin(0);
        $this->subsubtitle->SetFont(
            Configs::getConfig('FF_VERDANA'),
            Configs::getConfig('FS_NORMAL'),
            8
        );
        $this->subsubtitle->SetMargin(0);
    }

    public function StrokeTexts()
    {
        if (null === $this->texts) {
            return;
        }

        $n = Configs::safe_count($this->texts);

        for ($i = 0; $i < $n; ++$i) {
            $this->texts[$i]->Stroke($this->img);
        }
    }

    public function StrokeIcons()
    {
        if (null === $this->iIcons) {
            return;
        }

        $n = Configs::safe_count($this->iIcons);

        for ($i = 0; $i < $n; ++$i) {
            // Since Windrose graphs doesn't have any linear scale the position of
            // each icon has to be given as absolute coordinates
            $this->iIcons[$i]->_Stroke($this->img);
        }
    }

    /**
     * PUBLIC METHODS.
     *
     * @param mixed $aPlot
     */
    public function Add($aPlot): self
    {
        if (\is_array($aPlot) && Configs::safe_count($aPlot) > 0) {
            $cl = $aPlot[0];
        } else {
            $cl = $aPlot;
        }

        if ($cl instanceof Text\Text) {
            $this->AddText($aPlot);
        } elseif ($cl instanceof Plot\IconPlot) {
            $this->AddIcon($aPlot);
        } elseif (($cl instanceof Plot\WindrosePlot)) {
            $this->plots[] = $aPlot;
        } else {
            throw      Util\JpGraphError::make(22021);
        }
        return $this;
    }

    public function AddText($aTxt, $aToY2 = false)
    {
        parent::AddText($aTxt);
    }

    /**
     * @param string $aColor
     */
    public function SetColor($aColor)
    {
        $this->SetMarginColor($aColor);
    }

    // Method description
    public function Stroke($aStrokeFileName = '')
    {
        // If the filename is the predefined value = '_csim_special_'
        // we assume that the call to stroke only needs to do enough
        // to correctly generate the CSIM maps.
        // We use this variable to skip things we don't strictly need
        // to do to generate the image map to improve performance
        // as best we can. Therefore you will see a lot of tests !$_csim in the
        // code below.
        $_csim = (Configs::getConfig('_CSIM_SPECIALFILE') === $aStrokeFileName);

        // We need to know if we have stroked the plot in the
        // GetCSIMareas. Otherwise the CSIM hasn't been generated
        // and in the case of GetCSIM called before stroke to generate
        // CSIM without storing an image to disk GetCSIM must call Stroke.
        $this->iHasStroked = true;

        if ('' !== $this->background_image || '' !== $this->background_cflag) {
            $this->StrokeFrameBackground();
        } else {
            $this->StrokeFrame();
        }

        // n holds number of plots
        $n = Configs::safe_count($this->plots);

        for ($i = 0; $i < $n; ++$i) {
            $this->plots[$i]->Stroke($this);
        }

        $this->footer->Stroke($this->img);
        $this->StrokeIcons();
        $this->StrokeTexts();
        $this->StrokeTitles();

        // If the filename is given as the special "__handle"
        // then the image handler is returned and the image is NOT
        // streamed back
        if (Configs::getConfig('_IMG_HANDLER') === $aStrokeFileName
        ) {
            return $this->img->img;
        }
        // Finally stream the generated picture
        $this->cache->PutAndStream(
            $this->img,
            $this->cache_name,
            $this->inline,
            $aStrokeFileName
        );
    }
}
// @class
