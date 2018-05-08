<?php

class PieTest extends \Codeception\Test\Unit
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
        $files = ['new_pie1.php',
            'new_pie2.php',
            'new_pie3.php',
            'new_pie4.php',
            'pie3dex1.php',
            'pie3dex2.php',
            'pie3dex3.php',
            'pie3dex4.php',
            'pie3dex5.php',
            'piebkgex1.php',
            'piecex1.php',
            'piecex2.php',
            'pieex1.php',
            'pieex2.php',
            'pieex3.php',
            'pieex4.php',
            'pieex5.php',
            'pieex6.php',
            'pieex7.php',
            'pieex8.php',
            'pieex9.php',
            'pielabelsex1.php',
            'pielabelsex2.php',
            'pielabelsex3.php',
            'pielabelsex4.php',
            'pielabelsex5.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
