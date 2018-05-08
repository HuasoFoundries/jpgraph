<?php

class GanttTest extends \Codeception\Test\Unit
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
        $files = ['gantt_samerowex1.php',
            'gantt_samerowex2.php',
            'gantt_textex1.php',
            'ganttcolumnfontsex01.php',
            'ganttconstrainex0.php',
            'ganttconstrainex1.php',
            'ganttconstrainex2.php',
            'ganttex00.php',
            'ganttex01.php',
            'ganttex02.php',
            'ganttex03.php',
            'ganttex04.php',
            'ganttex05.php',
            'ganttex06.php',
            'ganttex07.php',
            'ganttex08.php',
            'ganttex09.php',
            'ganttex10.php',
            'ganttex11.php',
            'ganttex12.php',
            'ganttex13-zoom1.php',
            'ganttex13-zoom2.php',
            'ganttex13.php',
            'ganttex14.php',
            'ganttex15.php',
            'ganttex16.php',
            'ganttex17-flag.php',
            'ganttex17.php',
            'ganttex18.php',
            'ganttex19.php',
            'ganttex30.php',
            'ganttex_slice.php',
            'gantthgridex1.php',
            'gantthourex1.php',
            'gantthourminex1.php',
            'gantticonex1.php',
            'ganttmonthyearex1.php',
            'ganttmonthyearex2.php',
            'ganttmonthyearex3.php',
            'ganttmonthyearex4.php',
            'ganttsimpleex1.php',
            'multconstganttex01.php'];
        foreach ($files as $file) {
            $this->_fileCheck($file);
        }
    }
}
