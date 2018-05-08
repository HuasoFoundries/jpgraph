<?php

class SunspotTest extends \Codeception\Test\Unit
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
        $files = ['sunspotsex1.php', 'sunspotsex2.php', 'sunspotsex3.php', 'sunspotsex4.php', 'sunspotsex5.php', 'sunspotsex6.php', 'sunspotsex7.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
