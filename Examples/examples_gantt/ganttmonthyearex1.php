<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$graph = new Graph\GanttGraph();
$example_title = 'Only month & year scale';
$graph->title->set($example_title);

// Setup some "very" nonstandard colors
$graph->SetMarginColor('lightgreen@0.8');
$graph->SetBox(true, 'yellow:0.6', 2);
$graph->SetFrame(true, 'darkgreen', 4);
$graph->scale->divider->SetColor('yellow:0.6');
$graph->scale->dividerh->SetColor('yellow:0.6');

// Explicitely set the date range
// (Autoscaling will of course also work)
$graph->SetDateRange('2001-10-06', '2002-4-01');

// Display month and year scale with the gridlines
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HYEAR'));
$graph->scale->month->grid->SetColor('gray');
$graph->scale->month->grid->Show(true);
$graph->scale->year->grid->SetColor('gray');
$graph->scale->year->grid->Show(true);

// Data for our example activities
$data = [
    [0, 'Group 1  Johan', '2001-11-23', '2002-03-1', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 8],
    [1, '  Label 2', '2001-10-26', '2001-11-16'], ];

// Create the bars and add them to the gantt chart
for ($i = 0; \count($data) > $i; ++$i) {
    $bar = new Plot\GanttBar($data[$i][0], $data[$i][1], $data[$i][2], $data[$i][3], '[50%]', 10);

    if (\count($data[$i]) > 4) {
        $bar->title->SetFont($data[$i][4], $data[$i][5], $data[$i][6]);
    }
    $bar->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
    $bar->SetFillColor('red');
    $bar->progress->Set(0.5);
    $bar->progress->SetPattern(Graph\Configs::getConfig('GANTT_SOLID'), 'darkgreen');
    $graph->Add($bar);
}

// Output the chart
$graph->Stroke();
