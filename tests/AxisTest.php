<?php

class AxisTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = (dirname(__DIR__)) . '/Examples/examples_' . $className . '/';

    }

    protected function _after() {}

    private function _fileCheck($filename)
    {
        ob_start();

        include $this->exampleRoot . $filename;

        $img = (ob_get_clean());

        $size = getimagesizefromstring($img);

        $this->assertEquals($__width, $size[0], 'width should match the one declared for ' . $filename);
        $this->assertEquals($__height, $size[1], 'height should match the one declared for ' . $filename);
        //\Codeception\Util\Debug::debug($size);

    }

    public function testFileIterator()
    {
        $files = ['axislabelbkgex01.php',
            'axislabelbkgex02.php',
            'axislabelbkgex03.php',
            'axislabelbkgex04.php',
            'axislabelbkgex05.php',
            'axislabelbkgex06.php',
            'axislabelbkgex07.php',
            'dupyaxisex1.php',
            'inyaxisex1.php',
            'inyaxisex2.php',
            'inyaxisex3.php',
            'mulyaxisex1.php',
            'topxaxisex1.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
