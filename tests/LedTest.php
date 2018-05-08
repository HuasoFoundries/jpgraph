<?php

class LedTest extends \Codeception\Test\Unit
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
        $files = ['ledex1.php', 'ledex10.php', 'ledex11.php', 'ledex12.php', 'ledex13.php', 'ledex14.php', 'ledex15.php', 'ledex16.php', 'ledex17.php', 'ledex2.php', 'ledex3.php', 'ledex4.1.php', 'ledex4.2.php', 'ledex4.php', 'ledex5.php', 'ledex6.php', 'ledex7.php', 'ledex8.php', 'ledex9.php', 'ledex_cyrillic.php', 'ledex_cyrillic2.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
