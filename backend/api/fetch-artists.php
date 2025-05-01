<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include('../config/db.php');

$genres = isset($_GET['genres']) ? explode(',', $_GET['genres']) : [];

if (empty($genres)) {
    echo json_encode([]);
    exit;
}

$escapedGenres = array_map(function($genre) use ($conn) {
    return mysqli_real_escape_string($conn, trim($genre));
}, $genres);

$whereClause = implode(" OR ", array_map(fn($g) => "genre LIKE '%$g%'", $escapedGenres));

$query = "SELECT name, genre, profile_picture_url, location FROM artist_table WHERE $whereClause LIMIT 60000";
$result = mysqli_query($conn, $query);

$artists = [];
while ($row = mysqli_fetch_assoc($result)) {
    if (!empty($row['profile_picture_url'])) {
        $artists[] = $row;
    }
}

echo json_encode($artists);
?>
