<?php

class RadarTest extends \Codeception\Test\Unit
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
        $files = ['fixscale_radarex1.php',
            'radarex1.php',
            'radarex2.php',
            'radarex3.php',
            'radarex4.php',
            'radarex5.php',
            'radarex6.1.php',
            'radarex6.php',
            'radarex7.php',
            'radarex8.1.php',
            'radarex8.php',
            'radarex9.php',
            'radarlogex1-aa.php',
            'radarlogex1.php',
            'radarlogex2.php',
            'radarmarkex1.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
