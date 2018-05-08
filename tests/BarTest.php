<?php

class BarTest extends \Codeception\Test\Unit
{
    public $filename = '';

    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';

    }

    protected function _after() {}

    // tests
    public function testAccbarex1()
    {
        $this->filename = 'accbarex1';

        ob_start();

        include $this->exampleRoot . $this->filename . '.php';

        $img = (ob_get_clean());

        $size = getimagesizefromstring($img);

        \Codeception\Util\Debug::debug($size);

    }

    public function testFileIterator()
    {
        $files = ['accbarex1.php', 'accbarframeex01.php', 'accbarframeex02.php', 'accbarframeex03.php', 'alphabarex1.php', 'bar2scalesex1.php', 'barformatcallbackex1.php', 'bargradex1.php', 'bargradex2.php', 'bargradex3.php', 'bargradex4.php', 'bargradex5.php', 'bargradex6.php', 'bargradsmallex1.php', 'bargradsmallex2.php', 'bargradsmallex3.php', 'bargradsmallex4.php', 'bargradsmallex5.php', 'bargradsmallex6.php', 'bargradsmallex7.php', 'bargradsmallex8.php', 'barimgex1.php', 'barintex1.php', 'barintex2.php', 'barlinealphaex1.php', 'barlinefreqex1.php', 'barpatternex1.php', 'barscalecallbackex1.php', 'bartutex1.php', 'bartutex12.php', 'bartutex2.php', 'bartutex3.php', 'bartutex4.php', 'bartutex5.php', 'bartutex6.php', 'grace_ex0.php', 'grace_ex1.php', 'grace_ex2.php', 'grace_ex3.php', 'groupbarex1.php', 'horizbarex1.php', 'horizbarex2.php', 'horizbarex3.php', 'horizbarex4.php', 'horizbarex6.php', 'logbarex1.php', 'manual_textscale_ex1.php', 'manual_textscale_ex2.php', 'manual_textscale_ex3.php', 'manual_textscale_ex4.php', 'negbarvalueex01.php', 'new_bar1.php', 'new_bar3.php', 'new_bar4.php', 'new_bar6.php', 'plotbanddensity_ex0.php', 'plotbanddensity_ex1.php', 'plotbanddensity_ex2.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
