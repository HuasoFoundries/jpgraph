<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Some dummy data for some activities
$data = [
    [0, 'Group 1  Johan', '2001-10-23', '2001-11-06', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 8],
    [1, '  Label 2', '2001-10-26', '2001-11-04'],
    [3, 'Group 2', '2001-11-20', '2001-11-28', Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 8],
    [4, '  Label 1', '2001-11-20', '2001-12-1'], ];

// New Gantt Graph
$graph = new Graph\GanttGraph(500);

// Setup a title
$example_title = 'Grid example';
$graph->title->set($example_title);
$subtitle_text = '(Horizontal grid)';
$graph->subtitle->Set($subtitle_text);
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_NORMAL'), 14);

// Specify what headers to show
$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HMONTH') | Graph\Configs::getConfig('GANTT_HDAY'));
$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT0'));

// Setup a horizontal grid
$graph->hgrid->Show();
$graph->hgrid->SetRowFillColor('darkblue@0.9');

for ($i = 0; \count($data) > $i; ++$i) {
    $bar = new Plot\GanttBar($data[$i][0], $data[$i][1], $data[$i][2], $data[$i][3], '[5%]', 10);

    if (\count($data[$i]) > 4) {
        $bar->title->SetFont($data[$i][4], $data[$i][5], $data[$i][6]);
    }
    $bar->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
    $bar->SetFillColor('red');
    $graph->Add($bar);
}

// Setup a vertical marker line
$vline = new Plot\GanttVLine('2001-11-01');
$vline->SetDayOffset(0.5);
$example_title = '2001-11-01';
$vline->title->set($example_title);
$vline->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'), 10);
$graph->Add($vline);

// Setup a milestone
$ms = new Plot\MileStone(6, 'M5', '2001-11-28', '28/12');
$ms->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->Add($ms);

// And to show that you can also add an icon we add "Tux"
$icon = new Plot\IconPlot(__DIR__ . '/../assets/penguin.png', 0.05, 0.95, 1, 15);
$icon->SetAnchor('left', 'bottom');
$graph->Add($icon);

// .. and finally send it back to the browser
$graph->Stroke();
