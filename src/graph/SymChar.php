<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Graph;

/**
 * @class SymChar
 * // Description: Code values for some commonly used characters that
 * //              normally isn't available directly on the keyboard, for example
 * //              mathematical and greek symbols.
 */
class SymChar
{
    public static function Get($aSymb, $aCapital = false)
    {
        $iSymbols = [
            /* Greek */
            ['alpha', '03B1', '0391'],
            ['beta', '03B2', '0392'],
            ['gamma', '03B3', '0393'],
            ['delta', '03B4', '0394'],
            ['epsilon', '03B5', '0395'],
            ['zeta', '03B6', '0396'],
            ['ny', '03B7', '0397'],
            ['eta', '03B8', '0398'],
            ['theta', '03B8', '0398'],
            ['iota', '03B9', '0399'],
            ['kappa', '03BA', '039A'],
            ['lambda', '03BB', '039B'],
            ['mu', '03BC', '039C'],
            ['nu', '03BD', '039D'],
            ['xi', '03BE', '039E'],
            ['omicron', '03BF', '039F'],
            ['pi', '03C0', '03A0'],
            ['rho', '03C1', '03A1'],
            ['sigma', '03C3', '03A3'],
            ['tau', '03C4', '03A4'],
            ['upsilon', '03C5', '03A5'],
            ['phi', '03C6', '03A6'],
            ['chi', '03C7', '03A7'],
            ['psi', '03C8', '03A8'],
            ['omega', '03C9', '03A9'],
            /* Money */
            ['euro', '20AC'],
            ['yen', '00A5'],
            ['pound', '20A4'],
            /* Math */
            ['approx', '2248'],
            ['neq', '2260'],
            ['not', '2310'],
            ['def', '2261'],
            ['inf', '221E'],
            ['sqrt', '221A'],
            ['int', '222B'],
            /* Misc */
            ['copy', '00A9'],
            ['para', '00A7'],
            ['tm', '2122'], /* Trademark symbol */
            ['rtm', '00AE'], /* Registered trademark */
            ['degree', '00b0'],
            ['lte', '2264'], /* Less than or equal */
            ['gte', '2265'], /* Greater than or equal */
        ];

        $n     = safe_count($iSymbols);
        $i     = 0;
        $found = false;
        $aSymb = strtolower($aSymb);
        while ($i < $n && !$found) {
            $found = $aSymb === $iSymbols[$i++][0];
        }
        if ($found) {
            $ca = $iSymbols[--$i];
            if ($aCapital && safe_count($ca) == 3) {
                $s = $ca[2];
            } else {
                $s = $ca[1];
            }

            return sprintf('&#%04d;', hexdec($s));
        }

        return '';
    }
}
