<?php

class WindroseTest extends \Codeception\Test\Unit
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
        $files = ['windrose_2plots_ex1.php', 'windrose_bgimg_ex1.php', 'windrose_ex0.php', 'windrose_ex1.php', 'windrose_ex1b.php', 'windrose_ex2.1.php', 'windrose_ex2.php', 'windrose_ex3.php', 'windrose_ex4.php', 'windrose_ex5.php', 'windrose_ex6.1.php', 'windrose_ex6.php', 'windrose_ex7.1.php', 'windrose_ex7.php', 'windrose_ex8.1.php', 'windrose_ex8.php', 'windrose_ex9.1.php', 'windrose_ex9.php', 'windrose_icon_ex1.php', 'windrose_layout_ex0.php', 'windrose_layout_ex1.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
