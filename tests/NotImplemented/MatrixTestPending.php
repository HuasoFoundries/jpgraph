<?php

/**
 * JPGraph - Community Edition
 */

namespace Tests\NotImplemented;

use Tests\BaseTestCase;

/**
 * @internal
 * @coversNothing
 */
class MatrixTestPending extends BaseTestCase
{
    public function testFileIterator()
    {
        $files = self::getFiles($this->exampleRoot);

        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }

    protected function set()
    {
        $className = \mb_strtolower(\str_replace('Test', '', \str_replace(__NAMESPACE__ . '\\', '', \get_class($this))));

        $this->exampleRoot = \dirname(BaseTestCase::TEST_FOLDER) . '/Examples/examples_' . $className . '/';
    }
}
