<?php

/**
 * JPGraph v3.6.21
 */
if (!isset($_GET['target'])) {
    $_GET['target'] = 'axislabelbkgex01.php';
}
if (!isset($_GET['folder'])) {
    $_GET['folder'] = 'examples_axis';
}
$target = basename(urldecode($_GET['target']));
$folder = basename(urldecode($_GET['folder']));

highlight_file(($folder ? $folder . '/' : '') . $target);
