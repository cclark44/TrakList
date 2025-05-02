<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT r.rating, r.description,
           a.title AS album_name, a.artist, a.album_cover
    FROM reviews r
    JOIN albums a ON r.album_id = a.album_id
    WHERE r.user_id = ?
    ORDER BY r.review_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrakList - Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- nav bar -->
  <header>
    <a href="home.php"><img src="Traklist header.png" alt="TrakList Logo" style= "height: 45px;"></a>
      <form action="library.php" method="GET" class="search-bar">
          <input type="text" name="query" placeholder="Enter album or artist..." required>
          <button type="submit">Search</button>
      </form>
      <a href="login.php" class="profile-link">Log Out</a>
  </header>

<!-- Display User Reviews -->
  <div class="profile-container">
        <h2>Your Reviews</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="review-card">
                    <img src="<?= htmlspecialchars($row['album_cover']) ?>" width="100" alt="Album Cover">
                    <h3><?= htmlspecialchars($row['album_name']) ?> by <?= htmlspecialchars($row['artist']) ?></h3>
                    <p><strong>Rating:</strong> <?= $row['rating'] ?>/10</p>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You haven't written any reviews yet.</p>
        <?php endif; ?>
    </div>
</body>
