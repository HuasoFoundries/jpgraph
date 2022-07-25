<?php

/**
 * JPGraph - Community Edition
 */

require_once 'jpgraph/jpgraph.php';

require_once 'jpgraph/jpgraph_flags.php';

if (empty($_GET['size'])) {
    $size = Graph\Configs::getConfig('FLAGSIZE2');
} else {
    $size = $_GET['size'];
}

if (empty($_GET['idx'])) {
    $idx = 'ecua';
} else {
    $idx = $_GET['idx'];
}

$flags = new FlagImages($size);
$img = $flags->GetImgByIdx($idx);
\header('Content-type: image/png');
\imagepng($img);
