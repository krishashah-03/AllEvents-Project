<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include('../config/db.php');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q === '') {
    echo json_encode([]);
    exit;
}

// Manual short-form/abbreviation matching
$abbr = [
    'mj' => 'Michael Jackson',
    'jt' => 'Justin Timberlake',
    'em' => 'Eminem'
];

if (isset($abbr[strtolower($q)])) {
    $q = $abbr[strtolower($q)];
}

// STEP 1: Pre-filter names from database (LIKE + LIMIT for performance)
$escaped = mysqli_real_escape_string($conn, $q);
$sql = "
    SELECT name 
    FROM artist_table 
    WHERE name LIKE '$escaped%' 
       OR name LIKE '%$escaped%' 
    LIMIT 100
";
$result = mysqli_query($conn, $sql);

$allNames = [];
while ($row = mysqli_fetch_assoc($result)) {
    $allNames[] = $row['name'];
}

// STEP 2: Apply fuzzy match (levenshtein + soundex)
$matches = [];
foreach ($allNames as $name) {
    $lev = levenshtein(strtolower($q), strtolower($name));
    $soundexMatch = soundex($q) == soundex($name);

    if ($lev <= 3 || $soundexMatch || stripos($name, $q) !== false) {
        $matches[] = [
            'name' => $name,
            'lev_score' => $lev
        ];
    }
}

// STEP 3: Sort best matches first
usort($matches, function ($a, $b) {
    return $a['lev_score'] <=> $b['lev_score'];
});

// STEP 4: Fetch full artist data for top 10 matches
$suggestions = [];
foreach (array_slice($matches, 0, 10) as $match) {
    $safeName = mysqli_real_escape_string($conn, $match['name']);
    $res = mysqli_query($conn, "SELECT name, genre, profile_picture_url, location FROM artist_table WHERE name = '$safeName' LIMIT 1");

    if ($res && $row = mysqli_fetch_assoc($res)) {
        $suggestions[] = $row;
    }
}

echo json_encode($suggestions);
?>
