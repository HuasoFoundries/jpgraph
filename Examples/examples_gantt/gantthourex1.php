<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$graph = new Graph\GanttGraph();
$graph->SetMarginColor('blue:1.7');
$graph->SetColor('white');

$graph->SetBackgroundGradient('navy', 'white', Graph\Configs::getConfig('GRAD_HOR'), Graph\Configs::getConfig('BGRAD_MARGIN'));
$graph->scale->hour->SetBackgroundColor('lightyellow:1.5');
$graph->scale->hour->SetFont(Graph\Configs::getConfig('FF_FONT1'));
$graph->scale->day->SetBackgroundColor('lightyellow:1.5');
$graph->scale->day->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$example_title = 'Example of hours in scale';
$graph->title->set($example_title);
$graph->title->SetColor('white');
$graph->title->SetFont(Graph\Configs::getConfig('FF_VERDANA'), Graph\Configs::getConfig('FS_BOLD'), 14);

$graph->ShowHeaders(Graph\Configs::getConfig('GANTT_HDAY') | Graph\Configs::getConfig('GANTT_HHOUR'));

$graph->scale->week->SetStyle(Graph\Configs::getConfig('WEEKSTYLE_FIRSTDAY'));
$graph->scale->week->SetFont(Graph\Configs::getConfig('FF_FONT1'));
$graph->scale->hour->SetIntervall(4);

$graph->scale->hour->SetStyle(Graph\Configs::getConfig('HOURSTYLE_HM24'));
$graph->scale->day->SetStyle(Graph\Configs::getConfig('DAYSTYLE_SHORTDAYDATE3'));

$data = [
    [0, '  Label 1', '2001-01-26 04:00', '2001-01-26 14:00'],
    [1, '  Label 2', '2001-01-26 10:00', '2001-01-26 18:00'],
    [2, '  Label 3', '2001-01-26', '2001-01-27 10:00'],
];

for ($i = 0; \count($data) > $i; ++$i) {
    $bar = new Plot\GanttBar($data[$i][0], $data[$i][1], $data[$i][2], $data[$i][3], '[5%]', 10);

    if (\count($data[$i]) > 4) {
        $bar->title->SetFont($data[$i][4], $data[$i][5], $data[$i][6]);
    }
    $bar->SetPattern(Graph\Configs::getConfig('BAND_RDIAG'), 'yellow');
    $bar->SetFillColor('red');
    $graph->Add($bar);
}

$graph->Stroke();
