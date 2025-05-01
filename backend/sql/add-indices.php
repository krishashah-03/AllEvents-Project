<?php


include('../config/db.php');

$sql = "
ALTER TABLE artist_table
ADD INDEX idx_name (name),
ADD INDEX idx_genre (genre),
ADD INDEX idx_location (location);
";

if (mysqli_query($conn, $sql)) {
    echo "✅ Indexes added successfully.";
} else {
    echo "❌ Error adding indexes: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
