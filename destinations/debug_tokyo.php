<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$_GET['slug'] = 'tokyo';
$slug = 'tokyo';
$dataFile = __DIR__ . '/data/' . $slug . '.php';
$d = include $dataFile;
$isNewFormat = isset($d['overview']) && !isset($d['overview_title']);
echo "<pre>";
echo "isNewFormat: " . ($isNewFormat ? 'true' : 'false') . "\n";
echo "Keys: " . implode(', ', array_keys($d)) . "\n";
echo "Itinerary keys: " . implode(', ', array_keys($d['itineraries'])) . "\n";
echo "Experiences keys: " . implode(', ', array_keys($d['experiences'])) . "\n";
echo "</pre>";