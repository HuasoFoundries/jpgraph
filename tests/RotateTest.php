<?php

class RotateTest extends \Codeception\Test\Unit
{

    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';

    }

    protected function _after() {}

    // tests
    public function testSomeFeature() {}

    public function testFileIterator()
    {
        $files = ['rotateex1.php', 'rotex0.php', 'rotex1.php', 'rotex2.php', 'rotex3.php', 'rotex4.php', 'rotex5.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
