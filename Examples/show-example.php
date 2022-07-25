<?php

/**
 * JPGraph - Community Edition
 */

$target = \basename(\urldecode($_GET['target'] ?? 'axislabelbkgex01.php'));
$folder = \basename(\urldecode($_GET['folder'] ?? 'examples_axis'));

echo '<html>';
echo '<head>';
echo '<title> Image ' . $target . '</title>';

if (!\mb_strstr($target, 'csim')) {
    $highlighted = \highlight_file(($folder ? $folder . '/' : '') . $target, true);

    echo '</head>';
    echo '<body>';
    echo '<div style="float:right;"><img src="' . ($folder ? $folder . '/' : '') . ($target) . '" border=0 alt="' . $target . '" align="left"></div>';
    echo $highlighted;
    echo '</body>';
} else {
    echo '<script type="text/javascript" language="javascript">';
    echo '<!--';
    echo 'function resize() {';
    echo 'return true;';
    echo '}';
    echo '//';
    echo '-->';
    echo '</script>';
    echo '</head>';
    echo '<frameset rows="*" onLoad="resize()">';
    echo '<frame src="' . ($folder) . '/' . ($target) . '" name="image">';
    echo '</frameset>';
}
echo '</html>';
