<?php

class BackgroundTest extends \Codeception\Test\Unit
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
        $files = ['background_type_ex0.php', 'background_type_ex1.php', 'background_type_ex2.php', 'background_type_ex3.php', 'background_type_ex4.php', 'backgroundex01.php', 'backgroundex02.php', 'backgroundex03.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
