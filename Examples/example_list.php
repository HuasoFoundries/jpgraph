<?php

/**
 * JPGraph - Community Edition
 */

/**
 * JPGraph v4.1.0-beta.01.
 */
function GetFiles()
{
    $d = \dir(__DIR__);
    $a = [];

    while ($entry = $d->Read()) {
        if (\is_dir($entry) && ('assets' !== $entry) && '.' !== $entry && '..' !== $entry) {
            $examplefolder = \dir($entry);

            while ($file = $examplefolder->Read()) {
                if (\is_dir($file) || !\mb_strstr($file, '.php')) {
                    continue;
                }

                if (!\mb_strstr($entry, 'csim') && \mb_strstr($file, 'x') && !\mb_strstr($file, 'show') && !\mb_strstr($file, 'csim')) {
                    $a[] = $entry . '/' . $file;
                } elseif (\mb_strstr($entry, 'csim') && !\mb_strstr($entry, 'graph')) {
                    $a[] = $entry . '/' . $file;
                }
            }
        }
    }
    $d->Close();

    if (\count($a) === 0) {
        exit("PANIC: Apache/PHP does not have enough permission to read the scripts in directory: {$this->iDir}");
    }
    \sort($a);

    return $a;
}

$files = GetFiles();
echo "window.files='" . \json_encode($files) . "';";
