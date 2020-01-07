<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Image;

/**
 * // File:        JPGRAPH_ANTISPAM.PHP
 * // Description: Genarate anti-spam challenge
 * // Created:     2004-10-07
 * // Ver:         $Id: jpgraph_antispam.php 1106 2009-02-22 20:16:35Z ljp $
 * //
 * // Copyright (c) Asial Corporation. All rights reserved.
 */
class AntiSpam
{
    private $iData = '';
    private $iDD;

    public function __construct($aData = '')
    {
        $this->iData = $aData;
        $this->iDD   = new HandDigits();
    }

    public function Set($aData)
    {
        $this->iData = $aData;
    }

    public function Rand($aLen)
    {
        $d = '';
        for ($i = 0; $i < $aLen; ++$i) {
            if (rand(0, 9) < 6) {
                // Digits
                $d .= chr(ord('1') + rand(0, 8));
            } else {
                // Letters
                do {
                    $offset = rand(0, 25);
                } while ($offset == 14);
                $d .= chr(ord('a') + $offset);
            }
        }
        $this->iData = $d;

        return $d;
    }

    public function Stroke()
    {
        $n = strlen($this->iData);
        if ($n == 0) {
            return false;
        }

        for ($i = 0; $i < $n; ++$i) {
            if ($this->iData[$i] === '0' || strtolower($this->iData[$i]) === 'o') {
                return false;
            }
        }

        $img = @imagecreatetruecolor($n * $this->iDD->iWidth, $this->iDD->iHeight);
        if ($img < 1) {
            return false;
        }

        $start = 0;
        for ($i = 0; $i < $n; ++$i) {
            $dimg = imagecreatefromstring(base64_decode($this->iDD->chars[strtolower($this->iData[$i])][1], true));
            imagecopy($img, $dimg, $start, 0, 0, 0, imagesx($dimg), $this->iDD->iHeight);
            $start += imagesx($dimg);
        }
        $resimg = @imagecreatetruecolor($start + 4, $this->iDD->iHeight + 4);
        if ($resimg < 1) {
            return false;
        }

        imagecopy($resimg, $img, 2, 2, 0, 0, $start, $this->iDD->iHeight);
        header('Content-type: image/jpeg');
        imagejpeg($resimg);

        return true;
    }
}
