<?php

class DatamatrixTest extends \Codeception\Test\Unit
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
        $files = ['datamatrix_ex0.php', 'datamatrix_ex00.php', 'datamatrix_ex1.php', 'datamatrix_ex2.php', 'datamatrix_ex3.php', 'datamatrix_ex4.php', 'datamatrix_ex5.php', 'datamatrix_ex6.php', 'datamatrix_ex7.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
