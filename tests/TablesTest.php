<?php

class TablesTest extends \Codeception\Test\Unit
{

    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';

    }

    protected function _after() {}

    // tests
    public function _fileCheck($filename)
    {
        ob_start();
        include $this->exampleRoot . $filename;
        $img  = (ob_get_clean());
        $size = getimagesizefromstring($img);
        \Codeception\Util\Debug::debug($size);
    }

    public function testFileIterator()
    {
        $files = ['table_flagex1.php',
            'table_howto1.php',
            'table_howto2.php',
            'table_howto3.php',
            'table_howto4.php',
            'table_howto5.php',
            'table_howto6.php',
            'table_howto7.1.php',
            'table_howto7.2.php',
            'table_howto7.php',
            'table_howto8.php',
            'table_howto9.php',
            'table_mex0.php',
            'table_mex00.php',
            'table_mex1.php',
            'table_mex2.php',
            'table_mex3.php',
            'table_vtext.php',
            'table_vtext_ex1.php',
            'tablebarex1.php',
            'tableex00.php',
            'tableex01.php',
            'tableex02.php',
            'tableex03.php',
            'tableex04.php',
            'tableex05.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
