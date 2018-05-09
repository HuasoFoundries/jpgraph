<?php

class SunspotTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = UNIT_TEST_FOLDER . '/Examples/examples_' . $className . '/';
    }

    protected function _after()
    {
    }

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
        $files = GetFiles($this->exampleRoot);
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
