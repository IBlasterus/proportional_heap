<?php
/**
 * Visualization
 */

require_once 'ProportionalHeap.php';

$nodes = array(
    'first' => 15,
    'second' => 6,
    'third' => 4
);

echo 'Initial nodes array:<br>';
echo '<pre>';
print_r($nodes);
echo '</pre>';

echo '------------- Processing with default source (100) ---------------';
$ph = new ProportionalHeap();
$ph->setNodes($nodes);
$myNodes = $ph->getNodes();

echo '<pre>';
print_r($myNodes);
echo '</pre>';
echo 'sum = ' . array_sum($myNodes) . '<br>';
echo 'max = ' . max($myNodes) . '<br>';
echo 'max_key = ' . array_keys($myNodes, max($myNodes))[0];

echo '<br><br>------------- Processing with source 200 ---------------';
$ph->setSource(200);
$myNodes = $ph->getNodes();

echo '<pre>';
print_r($myNodes);
echo '</pre>';
echo 'sum = ' . array_sum($myNodes) . '<br>';
echo 'max = ' . max($myNodes) . '<br>';
echo 'max_key = ' . array_keys($myNodes, max($myNodes))[0];