<?php

/**
 * JPGraph v4.0.3
 */

namespace Amenadiel\JpGraph\Util;

/**
 * @class ReadFileData
 */
class ReadFileData
{
    /**
     * Desciption:
     * // Read numeric data from a file.
     * // Each value should be separated by either a new line or by a specified
     * // separator character (default is ',').
     * // Before returning the data each value is converted to a proper float
     * // value. The routine is robust in the sense that non numeric data in the
     * // file will be discarded.
     * //
     * // Returns:
     * // The number of data values read on success, FALSE on failure.
     *
     * @param mixed $aFile
     * @param mixed $aSepChar
     * @param mixed $aMaxLineLength
     * @param mixed $aData
     */
    public static function FromCSV($aFile, &$aData, $aSepChar = ',', $aMaxLineLength = 1024)
    {
        $rh = @fopen($aFile, 'r');
        if ($rh === false) {
            return false;
        }
        $tmp        = [];
        $lineofdata = fgetcsv($rh, 1000, ',');
        while ($lineofdata !== false) {
            $tmp        = array_merge($tmp, $lineofdata);
            $lineofdata = fgetcsv($rh, $aMaxLineLength, $aSepChar);
        }
        fclose($rh);

        // Now make sure that all data is numeric. By default
        // all data is read as strings
        $n     = safe_count($tmp);
        $aData = [];
        $cnt   = 0;
        for ($i = 0; $i < $n; ++$i) {
            if ($tmp[$i] !== '') {
                $aData[$cnt++] = (float) ($tmp[$i]);
            }
        }

        return $cnt;
    }

    /**
     * Desciption:
     * // Read numeric data from a file.
     * // Each value should be separated by either a new line or by a specified
     * // separator character (default is ',').
     * // Before returning the data each value is converted to a proper float
     * // value. The routine is robust in the sense that non numeric data in the
     * // file will be discarded.
     * //
     * // Options:
     * // 'separator'     => ',',
     * // 'enclosure'     => '"',
     * // 'readlength'    => 1024,
     * // 'ignore_first'  => false,
     * // 'first_as_key'  => false
     * // 'escape'        => '\',   # PHP >= 5.3 only
     * //
     * // Returns:
     * // The number of lines read on success, FALSE on failure.
     *
     * @param mixed $aFile
     * @param mixed $aOptions
     * @param mixed $aData
     */
    public static function FromCSV2($aFile, &$aData, $aOptions = [])
    {
        $aDefaults = [
            'separator'    => ',',
            'enclosure'    => chr(34),
            'escape'       => chr(92),
            'readlength'   => 1024,
            'ignore_first' => false,
            'first_as_key' => false,
        ];

        $aOptions = array_merge(
            $aDefaults,
            is_array($aOptions) ? $aOptions : []
        );

        if ($aOptions['first_as_key']) {
            $aOptions['ignore_first'] = true;
        }

        $rh = @fopen($aFile, 'r');

        if ($rh === false) {
            return false;
        }

        $aData = [];
        $aLine = fgetcsv(
            $rh,
            $aOptions['readlength'],
            $aOptions['separator'],
            $aOptions['enclosure']
            /*, $aOptions['escape']     # PHP >= 5.3 only */
        );

        // Use numeric array keys for the columns by default
        // If specified use first lines values as assoc keys instead
        $keys = array_keys($aLine);
        if ($aOptions['first_as_key']) {
            $keys = array_values($aLine);
        }

        $num_lines = 0;
        $num_cols  = safe_count($aLine);

        while ($aLine !== false) {
            if (is_array($aLine) && safe_count($aLine) != $num_cols) {
                JpGraphError::RaiseL(24004);
                // 'ReadCSV2: Column count mismatch in %s line %d'
            }

            // fgetcsv returns NULL for empty lines
            if (!is_null($aLine)) {
                ++$num_lines;

                if (!($aOptions['ignore_first'] && $num_lines == 1) && is_numeric($aLine[0])) {
                    for ($i = 0; $i < $num_cols; ++$i) {
                        $aData[$keys[$i]][] = (float) ($aLine[$i]);
                    }
                }
            }

            $aLine = fgetcsv(
                $rh,
                $aOptions['readlength'],
                $aOptions['separator'],
                $aOptions['enclosure']
                /*, $aOptions['escape']     # PHP >= 5.3 only*/
            );
        }

        fclose($rh);

        if ($aOptions['ignore_first']) {
            --$num_lines;
        }

        return $num_lines;
    }

    // Read data from two columns in a plain text file
    public static function From2Col($aFile, $aCol1, $aCol2, $aSepChar = ' ')
    {
        $lines = @file($aFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return false;
        }
        $s = '/[\s]+/';
        if ($aSepChar == ',') {
            $s = '/[\s]*,[\s]*/';
        } elseif ($aSepChar == ';') {
            $s = '/[\s]*;[\s]*/';
        }
        foreach ($lines as $line => $datarow) {
            $split   = preg_split($s, $datarow);
            $aCol1[] = (float) (trim($split[0]));
            $aCol2[] = (float) (trim($split[1]));
        }

        return safe_count($lines);
    }

    // Read data from one columns in a plain text file
    public static function From1Col($aFile, $aCol1)
    {
        $lines = @file($aFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return false;
        }
        foreach ($lines as $line => $datarow) {
            $aCol1[] = (float) (trim($datarow));
        }

        return safe_count($lines);
    }

    public static function FromMatrix($aFile, $aSepChar = ' ')
    {
        $lines = @file($aFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return false;
        }
        $mat = [];
        $reg = '/' . $aSepChar . '/';
        foreach ($lines as $line => $datarow) {
            $row = preg_split($reg, trim($datarow));
            foreach ($row as $key => $cell) {
                $row[$key] = (float) (trim($cell));
            }
            $mat[] = $row;
        }

        return $mat;
    }
}
