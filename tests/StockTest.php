<?php

class StockTest extends \Codeception\Test\Unit
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
        $files = ['boxstockex1.php', 'boxstockex2.php', 'stockex1.php', 'stockex2.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
