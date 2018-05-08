<?php

class ImgTest extends \Codeception\Test\Unit
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
        $files = ['bkgimgflagex1.php',
            'bkgimgflagex2.php',
            'bkgimgflagex3.php',
            'bkgimgflagex4.php',
            'bkgimgflagex5.php',
            'imgmarkerex1.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
