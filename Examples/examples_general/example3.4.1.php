<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// A function to return the Roman Numeral, given an integer
function numberToRoman($aNum)
{
    // Make sure that we only use the integer portion of the value
    $n = (int) $aNum;
    $result = '';

    // Declare a lookup array that we will use to traverse the number:
    $lookup = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1, ];

    foreach ($lookup as $roman => $value) {
        // Determine the number of matches
        $matches = (int) ($n / $value);

        // Store that many characters
        $result .= \str_repeat($roman, $matches);

        // Substract that from the number
        $n = $n % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
}

function formatCallback($aVal)
{
    return '(' . numberToRoman($aVal) . ')';
}

// Some (random) data
$ydata = [11, 3, 8, 12, 5, 1, 9, 13, 5, 7];

// Size of the overall graph
$__width = 350;
$__height = 250;

// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('intlin');
$graph->SetShadow();

// Setup margin and titles
$graph->SetMargin(40, 20, 20, 40);
$example_title = 'Calls per operator';
$graph->title->set($example_title);
$subtitle_text = '(March 12, 2008)';
$graph->subtitle->Set($subtitle_text);
$graph->xaxis->title->Set('Operator');
$graph->yaxis->title->Set('# of calls');

$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));

$graph->yaxis->SetColor('blue');

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);
$lineplot->SetColor('blue');
$lineplot->SetWeight(2); // Two pixel wide
$lineplot->mark->SetType(Graph\Configs::getConfig('MARK_UTRIANGLE'));
$lineplot->mark->SetColor('blue');
$lineplot->mark->SetFillColor('red');

$lineplot->value->Show();
$lineplot->value->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 10);
$lineplot->value->SetColor('darkred');
$lineplot->value->SetFormatCallback('formatCallback');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
