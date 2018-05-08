<?php

class PdfTest extends \Codeception\Test\Unit
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
        $files = ['pdf417_ex0.php', 'pdf417_ex1.php', 'pdf417_ex1b.php', 'pdf417_ex1c.php', 'pdf417_ex2.php', 'pdf417_ex3.php', 'pdf417_ex4.php', 'pdf417_ex5.php', 'pdf417_ex6.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
