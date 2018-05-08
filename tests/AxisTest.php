<?php

class AxisTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';

    }

    protected function _after() {}

    private function _fileCheck($filename)
    {
        ob_start();

        include $this->exampleRoot . $filename;

        $img = (ob_get_clean());

        $size = getimagesizefromstring($img);

        \Codeception\Util\Debug::debug($size);

    }

}
