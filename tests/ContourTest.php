<?php

class ContourTest extends \Codeception\Test\Unit
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
        $files = ['basic_contourex01.php', 'basic_contourex02.php', 'basic_contourex03-1.php', 'basic_contourex03-2.php', 'basic_contourex03-3.php', 'basic_contourex04.php', 'basic_contourex05.php', 'contour2_ex1.php', 'contour2_ex2.php', 'contour2_ex3.php', 'contour2_ex4.php', 'contour2_ex5.php', 'contour2_ex6.php', 'contour2_ex7.php', 'contourex01.php', 'contourex02.php', 'contourex03.php', 'contourex04.php', 'contourex05.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
