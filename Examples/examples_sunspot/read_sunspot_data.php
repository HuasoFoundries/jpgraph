<?php

/**
 * JPGraph - Community Edition
 */

 use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util\JpGraphException;
 function readsunspotdata($aFile, &$aYears, &$aSunspots)
{
    $lines = \file($aFile, Graph\Configs::getConfig('FILE_IGNORE_NEW_LINES') | Graph\Configs::getConfig('FILE_SKIP_EMPTY_LINES'));

    if (false === $lines) {
        throw new JpGraphException('Can not read sunspot data file.');
    }

    foreach ($lines as $line => $datarow) {
        $split = \preg_split('/[\s]+/', $datarow);
        $aYears[] = \mb_substr(\trim($split[0]), 0, 4);
        $aSunspots[] = \trim($split[1]);
    }
}