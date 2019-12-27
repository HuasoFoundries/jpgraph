<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';
// By default each "LED" circle has a radius of 3 pixels. Change to 5 and slghtly smaller margin
use Amenadiel\JpGraph\Image;

$led = new Image\DigitalLED74(3);
$led->SetSupersampling(2);
$text = 'Р' .
    'С' .
    'Т' .
    'У' .
    'Ф' .
    'Х' .
    'Ц' .
    'Ч' .
    'Ш' .
    'Щ' .
    'Ъ' .
    'Ы' .
    'Ь' .
    'Э' .
    'Ю' .
    'Я';
$led->StrokeNumber($text, Image\Configs::getConfig('LEDC_RED'));
