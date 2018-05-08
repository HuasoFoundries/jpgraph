<?php

class DateTest extends \Codeception\Test\Unit
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
        $files = ['dateaxisex1.php', 'dateaxisex2.php', 'dateaxisex3.php', 'dateaxisex4.php', 'datescaleticksex01.php', 'dateutilex01.php', 'dateutilex02.php', 'prepaccdata_example.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
