<?php

require_once '../vendor/autoload.php';

/**
 * JPGraph v3.6.15
 */

//=======================================================================
// File:    TESTSUIT.PHP
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
class TestDriver
{
    private $iType;
    private $iDir;
    private $exampleDir;

    public function __construct($aType = 1, $folder = 'examples_axis', $aDir = '')
    {
        $this->iType = $aType;
        if ($aDir == '') {
            $aDir = getcwd();
        }
        if (!chdir($aDir)) {
            die("PANIC: Can't access directory : ${aDir}");
        }
        $this->iDir       = $aDir;
        $this->exampleDir = $folder;

        //echo '$aType: ' . $aType . '<br>';
        //echo '$aDir: ' . $aDir . '<br>';
    }

    public function GetFiles()
    {
        $d = @dir($this->iDir);
        $a = [];
        while ($entry = $d->Read()) {
            //echo $entry . ':' . (is_dir($entry) ? 'folder' : 'file') . '<br>';
            if (is_dir($entry) && ($entry != 'assets') && ($entry == $this->exampleDir)) {
                $examplefolder = @dir($entry);
                while ($file = $examplefolder->Read()) {
                    if (strstr($file, '.php') && strstr($file, 'x') && !strstr($file, 'show') && !strstr($file, 'csim')) {
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

    public function GetCSIMFiles()
    {
        $d = @dir($this->iDir . '/examples_csim');
        $a = [];
        while ($entry = $d->Read()) {
            if (strstr($entry, '.php') && strstr($entry, 'csim') && !strstr($entry, 'graph')) {
                $a[] = $entry;
            }
        }
        $d->Close();
        if (count($a) == 0) {
            die("PANIC: Apache/PHP does not have enough permission to read the CSIM scripts in directory: {$this->iDir}");
        }
        sort($a);

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
                die('Panic: Unknown type of test');

                break;
        }
        $n = count($files);

        for ($i = 0; $i < $n; ++$i) {
            $x = include $files[$i];
            var_dump($x);
        }
    }
}

$driver = new TestDriver(1, 'examples_axis');

$driver->Run();
