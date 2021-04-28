<?php

/**
 * JPGraph - Community Edition
 */

// $Id: piecex2.php,v 1.3.2.1 2003/08/19 20:40:12 aditus Exp $
// Example of pie with center circle
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some data
$data = [50, 28, 25, 27, 31, 20];

// A new pie graph
$__width = 400;
$__height = 400;
$graph = new Graph\PieGraph($__width, $__height, 'auto');

// Don't display the border
$graph->SetFrame(false);

// Uncomment this line to add a drop shadow to the border
// $graph->SetShadow();

// Setup title
$example_title = 'Plot\\PiePlotC';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 18);
$graph->title->SetMargin(8); // Add a little bit more margin from the top

// Create the pie plot
$p1 = new Plot\PiePlotC($data);

// Set size of pie
$p1->SetSize(0.35);

// Label font and color setup
$p1->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$p1->value->SetColor('white');

$p1->value->Show();

// Setup the title on the center circle
$p1->midtitle->Set("Test mid\nRow 1\nRow 2");
$p1->midtitle->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 14);

// Set color for mid circle
$p1->SetMidColor('yellow');

// Use percentage values in the legends values (This is also the default)
$p1->SetLabelType(Graph\Configs::getConfig('PIE_VALUE_PER'));

// The label array values may have printf() formatting in them. The argument to the
// form,at string will be the value of the slice (either the percetage or absolute
// depending on what was specified in the SetLabelType() above.
$lbl = ["adam\n%.1f%%", "bertil\n%.1f%%", "johan\n%.1f%%",
    "peter\n%.1f%%", "daniel\n%.1f%%", "erik\n%.1f%%", ];
$p1->SetLabels($lbl);

// Uncomment this line to remove the borders around the slices
// $p1->ShowBorder(false);

// Add drop shadow to slices
$p1->SetShadow();

// Explode all slices 15 pixels
$p1->ExplodeAll(15);

// Add plot to pie graph
$graph->Add($p1);

// .. and send the image on it's marry way to the browser
$graph->Stroke();
