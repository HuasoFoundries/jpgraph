<?php

/**
 * JPGraph v4.0.2
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$data = [40, 60, 21, 33];

$__width  = 300;
$__height = 250;
$graph    = new Graph\PieGraph($__width, $__height);
$graph->SetShadow();
$example_title = ' Using Arial';
$graph->title->set($example_title);
$graph->title->SetFont(
    FF_ARIAL,
    FS_NORMAL,
    14
);
$p1 = new Plot\PiePlot($data);
$graph->Add($p1);

$data2 = [60, 30, 11, 53];

$graph2 = new Graph\PieGraph($__width, $__height);
$graph2->SetShadow();
$example_title2 = 'Using Ubuntu Sans Serif';
$graph2->title->set($example_title2);
$graph2->SetUserFont1(
    '/usr/share/fonts/truetype/ubuntu/Ubuntu-M.ttf',
    '/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf',
    '/usr/share/fonts/truetype/ubuntu/Ubuntu-I.ttf'
);
$graph2->title->SetFont(
    FF_USERFONT1,
    FS_NORMAL,
    14
);

$p2 = new Plot\PiePlot($data2);
$graph2->Add($p2);

$data3 = [60, 30, 11, 53];

$graph3 = new Graph\PieGraph($__width, $__height);
$graph3->SetShadow();
$example_title3 = 'Using Lato Italic';
$graph3->title->set($example_title3);
$graph3->SetUserFont2(
    '/usr/share/fonts/truetype/lato/Lato-Regular.ttf',
    '/usr/share/fonts/truetype/lato/Lato-Bold.ttf',
    '/usr/share/fonts/truetype/lato/Lato-Italic.ttf',
    '/usr/share/fonts/truetype/lato/Lato-BoldItalic.ttf'
);
$graph3->title->SetFont(
    FF_USERFONT2,
    FS_ITALIC,
    14
);

$p3 = new Plot\PiePlot($data3);
$graph3->Add($p3);

$graph4 = new Graph\PieGraph($__width, $__height);
$graph4->SetShadow();
$example_title4 = 'Using Carlito BoldItalic';
$graph4->title->set($example_title4);
$graph4->SetUserFont3(
    '/usr/share/fonts/crosextra/lato/Carlito-Regular.ttf',
    '/usr/share/fonts/truetype/crosextra/Carlito-Bold.ttf',
    '/usr/share/fonts/truetype/crosextra/Carlito-Italic.ttf',
    '/usr/share/fonts/truetype/crosextra/Carlito-BoldItalic.ttf'
);
$graph4->title->SetFont(
    FF_USERFONT3,
    FS_BOLDITALIC,
    14
);

$p4 = new Plot\PiePlot($data);
$graph4->Add($p4);
//-----------------------
// Create a multigraph
//----------------------
$mgraph = new Graph\MGraph();
$mgraph->SetMargin(2, 2, 2, 2);
$mgraph->SetFrame(true, 'darkgray', 2);
$mgraph->SetFillColor('lightgray');
$mgraph->Add($graph);
$mgraph->Add($graph2, 300, 0);
$mgraph->Add($graph3, 0, 255);
$mgraph->Add($graph4, 300, 255);
$mgraph->Stroke();
