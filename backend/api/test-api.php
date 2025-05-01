<?php
header('Content-Type: application/json');

$query = isset($_GET['q']) ? urlencode($_GET['q']) : '';

if ($query) {
    $url = "http://127.0.0.1:8000/search?q=" . $query;
    $response = file_get_contents($url);
    echo $response;
} else {
    echo json_encode([]);
}
?>
