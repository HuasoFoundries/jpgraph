<?php

/**
 * JPGraph - Community Edition
 */

// (Note: Normally there would be no need to ever use manually specified encodation)

// Include the library
require_once 'jpgraph/QR/qrencoder.inc.php';

// Data to be encoded
$data = [
    [QREncoder::MODE_ALPHANUM, '01234567'],
    [QREncoder::MODE_NUMERIC, '89012345'],
];

// Create a new instance of the encoder (automatically determined QR version and
// error correction level)
$encoder = new QREncoder();

// Use the image backend
$backend = QRCodeBackendFactory::Create($encoder, Graph\Configs::getConfig('BACKEND_IMAGE'));

// Set the module size
$backend->SetModuleWidth(4);

// Store the barcode in the specifed file
$backend->Stroke($data);
