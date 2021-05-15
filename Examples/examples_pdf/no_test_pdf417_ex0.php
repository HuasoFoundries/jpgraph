<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once 'jpgraph/pdf417/jpgraph_pdf417.php';

$data = 'PDF-417';
// Create a new encoder and backend to generate PNG images
$backend = PDF417BackendFactory::Create(BACKEND_IMAGE, new PDF417Barcode());
$backend->Stroke($data);
