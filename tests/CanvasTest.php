<?php

class CanvasTest extends \Codeception\Test\Unit
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
        $files = ['canvas_jpgarchex.php', 'canvasbezierex1.php', 'canvasex01.php', 'canvasex02.php', 'canvasex03.php', 'canvasex04.php', 'canvasex05.php', 'canvasex06.php', 'canvaspiralex1.php', 'colormaps.php', 'listfontsex1.php', 'mkgrad.php', 'text-example1.php', 'text-example2.php', 'textalignex1.php', 'textpalignex1.php'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
