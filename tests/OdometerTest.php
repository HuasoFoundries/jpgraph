<?php

class OdometerTest extends \Codeception\Test\Unit
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
        $files = ['odoex00.php', 'odoex01.php', 'odoex010.php', 'odoex011.php', 'odoex012.php', 'odoex02.php', 'odoex03.php', 'odoex04.php', 'odoex05.php', 'odoex06.php', 'odoex07.php', 'odoex08.php', 'odoex09.php', 'odotutex00.php', 'odotutex01.php', 'odotutex02.php', 'odotutex03.php', 'odotutex04.php', 'odotutex06.php', 'odotutex07.php', 'odotutex08.1.php', 'odotutex08.php', 'odotutex09.php', 'odotutex10.php', 'odotutex11.php', 'odotutex12.php', 'odotutex13.php', 'odotutex14.php', 'odotutex15.php', 'odotutex16.1.php', 'odotutex16.php', 'odotutex17.php', 'odotutex18.php', 'odotutex19.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
