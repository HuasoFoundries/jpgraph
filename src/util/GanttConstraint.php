<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Util;

/**
 * @class GanttConstraint
 * // Just a structure to store all the values for a constraint
 */
class GanttConstraint
{
    public $iConstrainRow;
    public $iConstrainType;
    public $iConstrainColor;
    public $iConstrainArrowSize;
    public $iConstrainArrowType;

    /**
     * CONSTRUCTOR.
     *
     * @param mixed $aRow
     * @param mixed $aType
     * @param mixed $aColor
     * @param mixed $aArrowSize
     * @param mixed $aArrowType
     */
    public function __construct($aRow, $aType, $aColor, $aArrowSize, $aArrowType)
    {
        $this->iConstrainType      = $aType;
        $this->iConstrainRow       = $aRow;
        $this->iConstrainColor     = $aColor;
        $this->iConstrainArrowSize = $aArrowSize;
        $this->iConstrainArrowType = $aArrowType;
    }
}
