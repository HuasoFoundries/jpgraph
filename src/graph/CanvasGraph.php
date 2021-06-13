<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Graph;

use Amenadiel\JpGraph\Image;

/**
 * File:        JPGRAPH_CANVAS.PHP
 *  Description: Canvas drawing extension for JpGraph
 *  Created:     2001-01-08
 *  Ver:         $Id: jpgraph_canvas.php 1923 2010-01-11 13:48:49Z ljp $.
 * 
 *  Copyright (c) Asial Corporation. All rights reserved.
 */

/**
 * @class CanvasGraph
 *  Description: Creates a simple canvas graph which
 *  might be used together with the basic Image drawing
 *  primitives. Useful to auickoly produce some arbitrary
 *  graphic which benefits from all the functionality in the
 *  graph liek caching for example.
 */
final class CanvasGraph extends Graph
{
    /**
     * @var \Amenadiel\JpGraph\Graph\Scale\CanvasScale|null
     */
    public $scale;

    /**
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
    public function getScale()
    {
        return $this->scale;
    }
    /**
     * PUBLIC METHODS.
     */
    public function InitFrame(): void
    {
        $this->StrokePlotArea();
    }

    // Method description
    /**
     * @return mixed|bool|void
     */
    public function Stroke($aStrokeFileName = '')
    {
        if (null !== $this->texts) {
            for ($i = 0; Configs::safe_count($this->texts) > $i; ++$i) {
                $this->texts[$i]->Stroke($this->img);
            }
        }

        if (null !== $this->iTables) {
            for ($i = 0; Configs::safe_count($this->iTables) > $i; ++$i) {
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
        $_csim = (Configs::getConfig('_CSIM_SPECIALFILE') === $aStrokeFileName);

        // We need to know if we have stroked the plot in the
        // GetCSIMareas. Otherwise the CSIM hasn't been generated
        // and in the case of GetCSIM called before stroke to generate
        // CSIM without storing an image to disk GetCSIM must call Stroke.
        $this->iHasStroked = true;

        if (!$_csim) {
            // Should we do any final image transformation
            if ($this->iImgTrans) {
                $imgTrans = new Image\ImgTrans($this->img->img);
                $this->img->img = $imgTrans->Skew3D(
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
            if (
                Configs::getConfig('_IMG_HANDLER') === $aStrokeFileName
            ) {
                return $this->img->img;
            }
            // Finally stream the generated picture
            $this->cache->PutAndStream($this->img, $this->cache_name, $this->inline, $aStrokeFileName);

            return true;
        }
    }

    public function SetScale($aAxisType = 'canvas', $xmin = 0, $xmax = 10, $ymin = 0, $ymax = 10): self
    {
        $this->scale = new Scale\CanvasScale($this, $xmin, $xmax, $ymin, $ymax);
        $this->scale->Set($xmin, $xmax, $ymin, $ymax);
        return $this;
    }
} // @class

/* EOF */
