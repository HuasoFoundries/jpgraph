<?php

/**
 * JPGraph v4.0.3
 */

require_once 'jpgraph/pdf417/jpgraph_pdf417.php';

$data = 'PDF-417';

try {
    // Create a new encoder and backend to generate PNG images
    $backend = Graph\Configs::getConfig('PDF417B')ackendFactory::Create(Graph\Configs::getConfig('BACKEND_IMAGE'), new Graph\Configs::getConfig('PDF417B')arcode());
    $backend->Stroke($data);
} catch (JpGraphException $e) {
    echo 'PDF417 Error: ' . $e->GetMessage();
}
