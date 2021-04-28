<?php

/**
 * JPGraph - Community Edition
 */

namespace Amenadiel\JpGraph\Util;

/**
 * @class JpgTimer
 * // Description: General timing utility class to handle
 * // time measurement of generating graphs. Multiple
 * // timers can be started.
 */
class JpgTimer
{
    private $start;

    private $idx;

    public function __construct()
    {
        $this->idx = 0;
    }

    // Push a new timer start on stack
    public function Push()
    {
        [$ms, $s] = \explode(' ', \microtime());
        $this->start[$this->idx++] = \floor($ms * 1000) + 1000 * $s;
    }

    // Pop the latest timer start and return the diff with the
    // current time
    public function Pop()
    {
        \assert(0 < $this->idx);
        [$ms, $s] = \explode(' ', \microtime());
        $etime = \floor($ms * 1000) + (1000 * $s);
        --$this->idx;

        return $etime - $this->start[$this->idx];
    }
} // @class
