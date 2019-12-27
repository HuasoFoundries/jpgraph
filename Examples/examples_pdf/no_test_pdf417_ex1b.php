<?php

/**
 * JPGraph v4.0.0
 */

require_once 'jpgraph/pdf417/jpgraph_pdf417.php';

$data = 'PDF-417';

// Setup some symbolic names for barcode specification

$columns  = 8;   // Use 8 data (payload) columns
$errlevel = 2;  // Use error level 2 (minimum recommended)

// Create a new encoder and backend to generate PNG images
try {
    $encoder = new Graph\Configs::getConfig('PDF417B')arcode($columns, $errlevel);
    $backend = Graph\Configs::getConfig('PDF417B')ackendFactory::Create(Graph\Configs::getConfig('BACKEND_IMAGE'), $encoder);
    $backend->Stroke($data);
} catch (JpGraphException $e) {
    echo 'PDF417 Error: ' . $e->GetMessage();
}
