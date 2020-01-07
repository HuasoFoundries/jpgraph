<?php

/**
 * JPGraph v4.0.2
 */

require_once 'jpgraph/pdf417/jpgraph_pdf417.php';

$data1 = '12345';
$data2 = 'Abcdef';
$data3 = '6789';

// Manually specify several encodation schema
$data = [
    [USE_NC, $data1],
    [USE_TC, $data2],
    [USE_NC, $data3], ];

//$data = "12345Abcdef6789";

// Setup some symbolic names for barcode specification

$columns  = 8;   // Use 8 data (payload) columns
$modwidth = 2;  // Use 2 pixel module width
$errlevel = 2;  // Use error level 2
$showtext = true;  // Show human readable string

try {
    // Create a new encoder and backend to generate PNG images
    $encoder = new Graph\Configs::getConfig('PDF417B')arcode($columns, $errlevel);
    $backend = Graph\Configs::getConfig('PDF417B')ackendFactory::Create(Graph\Configs::getConfig('BACKEND_IMAGE'), $encoder);

    $backend->SetModuleWidth($modwidth);
    $backend->NoText(!$showtext);
    $backend->Stroke($data);
} catch (JpGraphException $e) {
    echo 'PDF417 Error: ' . $e->GetMessage();
}
