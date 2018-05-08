<?php

class BarTest extends \Codeception\Test\Unit
{
    public $filename = '';
    protected function _before()
    {
        $className         = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));
        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';
    }

    protected function _after()
    {
    }

    // tests
    public function testAccbarex1()
    {
        $this->filename = 'accbarex1';
        ob_start();
        include $this->exampleRoot . $this->filename . '.php';
        $img = (ob_get_clean());

        $size = getimagesizefromstring($img);
        \Codeception\Util\Debug::debug($size);
    }
}
