<?php

class MatrixTest extends \Codeception\Test\Unit
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
        $files = ['matrix_edgeex01.php',
            'matrix_edgeex02.php',
            'matrix_ex0.php',
            'matrix_ex01.php',
            'matrix_ex02.php',
            'matrix_ex03.php',
            'matrix_ex04.1.php',
            'matrix_ex04.2.php',
            'matrix_ex04.php',
            'matrix_ex05.php',
            'matrix_ex06.php',
            'matrix_introex.php',
            'matrix_layout_ex1.php',
            'matrixex00.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
