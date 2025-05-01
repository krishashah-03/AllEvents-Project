<?php
// Handle search logic if query is passed
$suggestions = [];

if (isset($_GET['q']) && trim($_GET['q']) !== '') {
    include('../config/db.php');
    $q = trim($_GET['q']);

    // Abbreviations
    $abbr = [
        'mj' => 'Michael Jackson',
        'jt' => 'Justin Timberlake',
        'em' => 'Eminem'
    ];

    if (isset($abbr[strtolower($q)])) {
        $q = $abbr[strtolower($q)];
    }

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

    $matches = [];
    foreach ($allNames as $name) {
        $lev = levenshtein(strtolower($q), strtolower($name));
        $soundexMatch = soundex($q) === soundex($name);

        if ($lev <= 3 || $soundexMatch || stripos($name, $q) !== false) {
            $matches[] = [
                'name' => $name,
                'lev_score' => $lev
            ];
        }
    }

    usort($matches, function ($a, $b) {
        return $a['lev_score'] <=> $b['lev_score'];
    });

    foreach (array_slice($matches, 0, 10) as $match) {
        $safeName = mysqli_real_escape_string($conn, $match['name']);
        $res = mysqli_query($conn, "SELECT name, genre, profile_picture_url, location FROM artist_table WHERE name = '$safeName' LIMIT 1");
        if ($res && $row = mysqli_fetch_assoc($res)) {
            $suggestions[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Artist Search (Single Page)</title>
  <style>
    input { padding: 8px; width: 300px; }
    ul { list-style: none; padding: 0; margin-top: 10px; }
    li { padding: 6px 0; border-bottom: 1px solid #ccc; }
  </style>
</head>
<body>

<h2>Search Artists (All-in-One Test)</h2>

<form method="GET">
  <input type="text" name="q" placeholder="Type artist name..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" />
  <button type="submit">Search</button>
</form>

<ul>
<?php if (!empty($suggestions)): ?>
  <?php foreach ($suggestions as $artist): ?>
    <li>
      <strong><?= htmlspecialchars($artist['name']) ?></strong><br>
      <small><?= htmlspecialchars($artist['genre']) ?> – <?= htmlspecialchars($artist['location']) ?></small>
    </li>
  <?php endforeach; ?>
<?php elseif (isset($_GET['q'])): ?>
  <li>No results found.</li>
<?php endif; ?>
</ul>

</body>
</html>
