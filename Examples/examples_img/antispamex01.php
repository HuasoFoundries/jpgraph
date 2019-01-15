<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Image;

// Create new anti-spam challenge creator
// Note: Neither '0' (digit) or 'O' (letter) can be used to avoid confusion
$spam = new Image\AntiSpam();

// Create a random 5 char challenge and return the string generated
$chars = $spam->Rand(5);

// Stroke random cahllenge
if ($spam->Stroke() === false) {
    die('Illegal or no data to plot');
}
