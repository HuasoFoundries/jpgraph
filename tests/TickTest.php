<?php

class TickTest extends \Codeception\Test\Unit
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
        $files = ['manualtickex1.php', 'manualtickex1a.php', 'manualtickex2.php', 'manualtickex3.php', 'manualtickex4.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
