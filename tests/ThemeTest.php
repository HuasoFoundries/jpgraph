<?php

class ThemeTest extends \Codeception\Test\Unit
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
        $files = ['aqua_example.php', 'fusion_example.php', 'green_example.php', 'ocean_example.php', 'orange_example.php', 'pastel_example.php', 'rose_example.php', 'softy_example.php', 'theme_example.php', 'universal_example.php', 'vivid_example.pp'];foreach ($files as $file) {$this->_fileCheck($file);}
    }
}
