<?php

/**
 * JPGraph v3.1.20
 */
$target = basename(urldecode($_GET['target']));
$folder = null;
if (isset($_GET['folder'])) {
    $folder = basename(urldecode($_GET['folder']));
}

highlight_file(($folder ? $folder . '/' : '') . $target);
