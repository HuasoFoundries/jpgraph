<?php

class StaticbandTest extends \Codeception\Test\Unit
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
        $files = ['smallstaticbandsex1.php', 'smallstaticbandsex10.php', 'smallstaticbandsex11.php', 'smallstaticbandsex2.php', 'smallstaticbandsex3.php', 'smallstaticbandsex4.php', 'smallstaticbandsex5.php', 'smallstaticbandsex6.php', 'smallstaticbandsex7.php', 'smallstaticbandsex8.php', 'smallstaticbandsex9.php', 'staticbandbarex1.php', 'staticbandbarex2.php', 'staticbandbarex3.php', 'staticbandbarex4.php', 'staticbandbarex5.php', 'staticbandbarex6.php', 'staticbandbarex7.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
