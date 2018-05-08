<?php

class GeneralTest extends \Codeception\Test\Unit
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
        $files = ['example0-0.php', 'example0.php', 'example1.1.php', 'example1.2.php', 'example1.php', 'example10.php', 'example11.php', 'example13.php', 'example14.php', 'example15.php', 'example16.1.php', 'example16.2.php', 'example16.3.php', 'example16.4.php', 'example16.5.php', 'example16.6.php', 'example16.php', 'example17.php', 'example18.php', 'example19.1.php', 'example19.php', 'example2.1.php', 'example2.5.php', 'example2.6.php', 'example2.php', 'example20.1.php', 'example20.2.php', 'example20.3.php', 'example20.4.php', 'example20.5.php', 'example20.php', 'example21.php', 'example22.php', 'example23.php', 'example24.php', 'example25.1.php', 'example25.2.php', 'example25.php', 'example26.1.php', 'example26.php', 'example27.1.php', 'example27.2.php', 'example27.3.php', 'example27.php', 'example28.1.php', 'example28.2.php', 'example28.3.php', 'example28.php', 'example3.0.1.php', 'example3.0.2.php', 'example3.0.3.php', 'example3.1.1.php', 'example3.1.php', 'example3.2.1.php', 'example3.2.2.php', 'example3.2.php', 'example3.3.php', 'example3.4.1.php', 'example3.4.php', 'example3.php', 'example4.php', 'example5.1.php', 'example5.php', 'example6.1.php', 'example6.2.php', 'example6.php', 'example7.php', 'example8.1.php', 'example8.php', 'example9.1.php', 'example9.2.php', 'example9.php', 'exampleex9.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
