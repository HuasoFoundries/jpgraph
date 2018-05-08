<?php

class PolarTest extends \Codeception\Test\Unit
{

    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';

    }

    protected function _after() {}

    // tests
    public function _fileCheck($filename)
    {
        ob_start();
        include $this->exampleRoot . $filename;
        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);
        \Codeception\Util\Debug::debug($size);
    }

    public function testFileIterator()
    {
        $files = ['polarclockex1.php',
            'polarclockex2.php',
            'polarex0-180.php',
            'polarex0.php',
            'polarex1.php',
            'polarex10.php',
            'polarex2.php',
            'polarex3-lin.php',
            'polarex3.php',
            'polarex4.php',
            'polarex5.php',
            'polarex6.php',
            'polarex7-1.php',
            'polarex7-2.php',
            'polarex7.php',
            'polarex8.php',
            'polarex9.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
