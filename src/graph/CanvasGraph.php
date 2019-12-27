<?php

/**
 * JPGraph v4.0.0
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Image;

/**
 * File:        JPGRAPH_CANVAS.PHP
 * // Description: Canvas drawing extension for JpGraph
 * // Created:     2001-01-08
 * // Ver:         $Id: jpgraph_canvas.php 1923 2010-01-11 13:48:49Z ljp $
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */

/**
 * @class CanvasGraph
 * // Description: Creates a simple canvas graph which
 * // might be used together with the basic Image drawing
 * // primitives. Useful to auickoly produce some arbitrary
 * // graphic which benefits from all the functionality in the
 * // graph liek caching for example.
 */
class CanvasGraph extends Graph
{
    public $scale;
    /**
     * CONSTRUCTOR.
     *
     * @param mixed $aWidth
     * @param mixed $aHeight
     * @param mixed $aCachedName
     * @param mixed $timeout
     * @param mixed $inline
     */
    public function __construct($aWidth = 300, $aHeight = 200, $aCachedName = '', $timeout = 0, $inline = 1)
    {
        parent::__construct($aWidth, $aHeight, $aCachedName, $timeout, $inline);
    }

    /**
     * PUBLIC METHODS.
     */
    public function InitFrame()
    {
        $this->StrokePlotArea();
    }

    // Method description
    public function Stroke($aStrokeFileName = '')
    {
        if ($this->texts != null) {
            for ($i = 0; $i < safe_count($this->texts); ++$i) {
                $this->texts[$i]->Stroke($this->img);
            }
        }
        if ($this->iTables !== null) {
            for ($i = 0; $i < safe_count($this->iTables); ++$i) {
                $this->iTables[$i]->Stroke($this->img);
            }
        }
        $this->StrokeTitles();

        // If the filename is the predefined value = '_csim_special_'
        // we assume that the call to stroke only needs to do enough
        // to correctly generate the CSIM maps.
        // We use this variable to skip things we don't strictly need
        // to do to generate the image map to improve performance
        // a best we can. Therefor you will see a lot of tests !$_csim in the
        // code below.
        $_csim = ($aStrokeFileName === Configs::getConfig('_CSIM_SPECIALFILE'));

        // We need to know if we have stroked the plot in the
        // GetCSIMareas. Otherwise the CSIM hasn't been generated
        // and in the case of GetCSIM called before stroke to generate
        // CSIM without storing an image to disk GetCSIM must call Stroke.
        $this->iHasStroked = true;

        if (!$_csim) {
            // Should we do any final image transformation
            if ($this->iImgTrans) {
                $tform          = new Image\ImgTrans($this->img->img);
                $this->img->img = $tform->Skew3D(
                    $this->iImgTransHorizon,
                    $this->iImgTransSkewDist,
                    $this->iImgTransDirection,
                    $this->iImgTransHighQ,
                    $this->iImgTransMinSize,
                    $this->iImgTransFillColor,
                    $this->iImgTransBorder
                );
            }

            // If the filename is given as the special Configs::getConfig('_IMG_HANDLER')
            // then the image handler is returned and the image is NOT
            // streamed back
            if ($aStrokeFileName == Configs::getConfig('_IMG_HANDLER')) {
                return $this->img->img;
            }
            // Finally stream the generated picture
            $this->cache->PutAndStream($this->img, $this->cache_name, $this->inline, $aStrokeFileName);

            return true;
        }
    }

    public function SetScale($aAxisType = 'canvas', $xmin = 0, $xmax = 10, $ymin = 0, $ymax = 10)
    {
        $this->scale = new Scale\CanvasScale($this, $xmin, $xmax, $ymin, $ymax);
        $this->scale->Set($xmin, $xmax, $ymin, $ymax);
    }
} // @class

/* EOF */
