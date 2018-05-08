<?php

class BarTest extends \Codeception\Test\Unit
{
    public $filename = '';

    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';
    }

    protected function _after()
    {
    }

    // tests
    private function _fileCheck($filename)
    {
        ob_start();

        include $this->exampleRoot . $filename;

        $img = (ob_get_clean());

        $size             = getimagesizefromstring($img);
        $size['filename'] = $filename;
        if ($__width != $size[0] || $__height != $size[1]) {
            rename($this->exampleRoot . $filename, $this->exampleRoot . 'no_dim_' . $filename);
        }
        $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
        $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
    }

    public function testFileIterator()
    {
        $files = GetFiles($this->exampleRoot);
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
