<?php

class LineTest extends \Codeception\Test\Unit
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
        $files = ['builtinplotmarksex1.php',
            'centeredlineex01.php',
            'centeredlineex02.php',
            'centeredlineex03.php',
            'centerlinebarex1.php',
            'clipping_ex1.php',
            'clipping_ex2.php',
            'filledgridex1.php',
            'filledline01.php',
            'filledlineex01.1.php',
            'filledlineex01.php',
            'filledlineex02.php',
            'filledlineex03.php',
            'filledstepstyleex1.php',
            'funcex1.php',
            'funcex2.php',
            'funcex3.php',
            'funcex4.php',
            'gradlinefillex1.php',
            'gradlinefillex2.php',
            'gradlinefillex3.php',
            'gradlinefillex4.php',
            'interpolation-growth-log.php',
            'interpolation-growth.php',
            'linebarcentex1.php',
            'linebarex1.php',
            'linebarex2.php',
            'linebarex3.php',
            'linegraceex.php',
            'lineiconex1.php',
            'lineiconex2.php',
            'lineimagefillex1.php',
            'manscaleex1.php',
            'manscaleex2.php',
            'manscaleex3.php',
            'manscaleex4.php',
            'new_line1.php',
            'new_line2.php',
            'new_line3.php',
            'new_line4.php',
            'new_line5.php',
            'new_step1.php',
            'nullvalueex01.php',
            'partiallyfilledlineex1.php',
            'plotlineex1.php',
            'splineex1.php',
            'staticlinebarex1.php',
            'tabtitleex1.php',
            'timestampex01.php',
            'titleex1.php',
            'y2synch.php',
            'y2synch2.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
