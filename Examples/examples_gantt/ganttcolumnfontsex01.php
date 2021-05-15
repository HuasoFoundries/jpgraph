<?php

/**
 * JPGraph v4.1.0-beta.01
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Setup a basic Gantt graph
$graph = new Graph\GanttGraph();
$graph->SetMarginColor('gray:1.7');
$graph->SetColor('white');

// Setup the graph title and title font$example_title='Example of column fonts'; $graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 14);

// Show three headers
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HYEAR'));

// Set the column headers and font
$graph->scale->actinfo->SetColTitles(['Name', 'Start', 'End'], [100]);
$graph->scale->actinfo->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 11);

// Some "dummy" data to be dsiplayed
$data = [
    [0, 'Group 1', '2001-11-27', '2001-12-05'],
    [1, '  Activity 1', '2001-11-27', '2001-11-29'],
    [2, '  Activity 2', '2001-11-28', '2001-12-05'],
    [3, 'Group 2', '2001-11-29', '2001-12-10'],
    [4, '  Activity 1', '2001-11-29', '2001-12-03'],
    [5, '  Activity 2', '2001-12-01', '2001-12-10'],
];

// Format and add the Gantt bars to the chart
$n = count($data);
for ($i = 0; $i < $n; ++$i) {
    if ($i === 0 || $i === 3) {
        // Format the group bars
        $bar = new Plot\GanttBar($data[$i][0], [$data[$i][1], $data[$i][2], $data[$i][3]], $data[$i][2], $data[$i][3], '', 0.35);

        // For each group make the name bold but keep the dates as the default font
        $bar->title->SetColumnFonts([[Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 11]]);

        // Add group markers
        $bar->leftMark->SetType(Graph\Configs::getConfig('MARK_LEFTTRIANGLE'));
        $bar->leftMark->Show();
        $bar->rightMark->SetType(Graph\Configs::getConfig('MARK_RIGHTTRIANGLE'));
        $bar->rightMark->Show();
        $bar->SetFillColor('black');
        $bar->SetPattern(Graph\Configs::getConfig('BAND_SOLID'), 'black');
    } else {
        // Format the activity bars
        $bar = new Plot\GanttBar($data[$i][0], [$data[$i][1], $data[$i][2], $data[$i][3]], $data[$i][2], $data[$i][3], '', 0.45);
        $bar->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'black');
        $bar->SetFillColor('orange');
    }
    // Default font
    $bar->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 10);
    $graph->Add($bar);
}

// Send back the graph to the client
$graph->Stroke();
