<?php

/**
 * JPGraph - Community Edition
 */

require __DIR__ . '/../vendor/autoload.php';
/**
 * JPGraph v4.1.0-beta.01.
 */

//=======================================================================
// File:    Graph\Configs::getConfig('TESTSUIT').PHP
// Description:    Run all the example script in current directory
// Created:     2002-07-11
// Ver:        $Id: testsuit.php,v 1.1.2.1 2004/03/27 12:43:07 aditus Exp $
//
// License:    This code is released under QPL 1.0
// Copyright (C) 2001,2002 Johan Persson
//========================================================================

//-------------------------------------------------------------------------
//
// Usage: testsuit.php[?type=1]    Generates all non image map scripts
//        testsuit.php?type=2      Generates client side image map scripts
//
//-------------------------------------------------------------------------
class testsuit
{
    private $iType;

    private $iDir;

    private $exampleDir;

    public function __construct($aType = 1, $folder = 'examples_axis', $aDir = __DIR__)
    {
        $this->iType = $aType;

        if ('' === $aDir) {
            $aDir = __DIR__;
        }

        if (!\chdir($aDir)) {
            exit("PANIC: Can't access directory : {$aDir}");
        }
        $this->iDir = $aDir;
        $this->exampleDir = $folder;

        //echo '$aType: ' . $aType . '<br>';
        //echo '$aDir: ' . $aDir . '<br>';
    }

    public function GetFolders()
    {
        $d = \dir($this->iDir);
        $a = [];

        while ($entry = $d->Read()) {
            //echo $entry . ':' . (is_dir($entry) ? 'folder' : 'file') . '<br>';
            if (\is_dir($entry) && ('assets' !== $entry) && '.' !== $entry && '..' !== $entry && 'examples_csim' !== $entry) {
                $a[] = $entry;
            }
        }
        $d->Close();

        if (\count($a) === 0) {
            exit("PANIC: Apache/PHP does not have enough permission to read the scripts in directory: {$this->iDir}");
        }
        \sort($a);

        foreach ($a as $folder) {
            echo '<span style="display:inline-block;padding:5px;border:1px solid #ccc;"><a href="testsuit.php?folder=' . $folder . '">' . $folder . '</a></span>';
        }
        echo '<span style="display:inline-block;padding:5px;border:1px solid #ccc;"><a href="testsuit.php?type=2">examples_csim</a></span>';

        return $a;
    }

    public function GetFiles()
    {
        $d = \dir($this->iDir);
        $a = [];

        while ($entry = $d->Read()) {
            //echo $entry . ':' . (is_dir($entry) ? 'folder' : 'file') . '<br>';
            if (\is_dir($entry) && ('assets' !== $entry) && ($entry === $this->exampleDir)) {
                $examplefolder = \dir($entry);

                while ($file = $examplefolder->Read()) {
                    if (\mb_strstr($file, '.php') && \mb_strstr($file, 'x') && !\mb_strstr($file, 'show') && !\mb_strstr($file, 'csim')) {
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

    public function GetCSIMFiles()
    {
        $d = \dir($this->iDir . '/examples_csim');
        $a = [];

        while ($entry = $d->Read()) {
            if (\mb_strstr($entry, '.php') && \mb_strstr($entry, 'csim') && !\mb_strstr($entry, 'graph')) {
                $a[] = $entry;
            }
        }
        $d->Close();

        if (\count($a) === 0) {
            exit("PANIC: Apache/PHP does not have enough permission to read the Graph\\Configs::getConfig('CSIM') scripts in directory: {$this->iDir}");
        }
        \sort($a);

        return $a;
    }

    public function Run()
    {
        switch ($this->iType) {
            case 1:
                $files = $this->GetFiles();

                break;
            case 2:
                $files = $this->GetCSIMFiles();

                break;

            default:
                exit('Panic: Unknown type of test');

                break;
        }
        $n = \count($files);
        echo '<h2>Visual test suit for JpGraph</h2>';
        echo 'Testtype: ' . (1 === $this->iType ? ' Standard images ' : ' Image map tests ');
        echo "<br>Number of tests: {$n}<p>";
        echo '<ul>';

        for ($i = 0; $i < $n; ++$i) {
            if (1 === $this->iType) {
                echo '<li style="border:1px solid #CCC;">';
                [$folder, $target] = \explode('/', $files[$i]);
                //\Kint::dump($files[$i]);
                echo '<a href="show-example.php?folder=' . \urlencode($folder) . '&target=' . \urlencode($target) . '">';
                echo '<img src="' . $files[$i] . '" border=0 align=top></a><br><strong>Filename:</strong> <i>';
                echo '<a href="' . $files[$i] . '">' . \basename($folder) . '/' . \basename($target) . "</a></i>\n";
            } else {
                echo '<li><a href="show-example.php?folder=examples_csim&target=' . \urlencode($files[$i]) . '">' . $files[$i] . "</a>\n";
            }
        }
        echo '</ol>';

        echo '<p>Done.</p>';
    }
}

if (!isset($_GET['type'])) {
    $type = 1;
} else {
    $type = $_GET['type'];
}

if (!isset($_GET['folder'])) {
    $folder = 'examples_axis';
} else {
    $folder = $_GET['folder'];
}

$driver = new TestDriver($type, $folder);
$driver->GetFolders();
$driver->Run();
