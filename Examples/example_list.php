<?php

/**
 * JPGraph v3.6.21
 */
function GetFiles()
{
    $d = dir(__DIR__);
    $a = [];
    while ($entry = $d->Read()) {
        if (is_dir($entry) && ($entry != 'assets') && $entry !== '.' && $entry !== '..') {
            $examplefolder = dir($entry);
            while ($file = $examplefolder->Read()) {
                if (is_dir($file) || !strstr($file, '.php')) {
                    continue;
                }
                if (!strstr($entry, 'csim') && strstr($file, 'x') && !strstr($file, 'show') && !strstr($file, 'csim')) {
                    $a[] = $entry . '/' . $file;
                } elseif (strstr($entry, 'csim') && !strstr($entry, 'graph')) {
                    $a[] = $entry . '/' . $file;
                }
            }
        }
    }
    $d->Close();
    if (count($a) == 0) {
        die("PANIC: Apache/PHP does not have enough permission to read the scripts in directory: {$this->iDir}");
    }
    sort($a);

    return $a;
}

$files = GetFiles();
echo "window.files='" . json_encode($files) . "';";
