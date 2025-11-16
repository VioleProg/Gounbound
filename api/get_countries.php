<?php
header('Content-Type: application/json');

$countries_dir = '../Assets/pais/';
$countries = [];

if (is_dir($countries_dir)) {
    $files = scandir($countries_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'png') {
            $country_name = pathinfo($file, PATHINFO_FILENAME);
            $countries[] = [
                'name' => $country_name,
                'flag' => 'Assets/pais/' . $file
            ];
        }
    }
    // Ordenar alfabeticamente
    usort($countries, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
}

echo json_encode(['success' => true, 'countries' => $countries]);

