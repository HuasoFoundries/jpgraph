<?php

class ScatterTest extends \Codeception\Test\Unit
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
        $files = ['balloonex1.php',
            'balloonex2.php',
            'bezierex1.php',
            'ccbp_ex1.php',
            'ccbp_ex2.php',
            'ccbpgraph.class.php',
            'fieldscatterex1.php',
            'footerex1.php',
            'impulsex1.php',
            'impulsex2.php',
            'impulsex3.php',
            'impulsex4.php',
            'loglogex1.php',
            'markflagex1.php',
            'pushpinex1.php',
            'pushpinex2.php',
            'scatterex1.php',
            'scatterex2.php',
            'scatterlinkex1.php',
            'scatterlinkex2.php',
            'scatterlinkex3.php',
            'scatterlinkex4.php',
            'scatterrotex1.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
