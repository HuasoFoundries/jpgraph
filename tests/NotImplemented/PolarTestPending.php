<?php

namespace Tests\NotImplemented;

use Tests\BaseTestCase;

class PolarTestPending extends BaseTestCase
{
    protected function _before()
    {
        $className = strtolower(str_replace('Test', '', str_replace(__NAMESPACE__ . '\\', '', get_class($this))));

        $this->exampleRoot = dirname(BaseTestCase::TEST_FOLDER) . '/Examples/examples_' . $className . '/';
    }



    public function testFileIterator()
    {
        $files = self::getFiles($this->exampleRoot);
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
