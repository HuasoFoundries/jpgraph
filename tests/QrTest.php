<?php

class QrTest extends \Codeception\Test\Unit
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
        $files = ['qr_template.php', 'qrexample0.php', 'qrexample00.php', 'qrexample01.php', 'qrexample02.php', 'qrexample03.php', 'qrexample04.php', 'qrexample05.php', 'qrexample06.php', 'qrexample07.php', 'qrexample08.php', 'qrexample09.php', 'qrexample10.php', 'qrexample11.php', 'qrexample12.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
