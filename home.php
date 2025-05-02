<?php
session_start();
include 'connection.php';
include 'fetch_popular.php';

// latest reviews with album and user info
$sql = "
  SELECT r.rating, r.description,
         a.title AS album_title, a.artist, a.album_cover,
         u.username
  FROM reviews r
  JOIN albums a ON r.album_id = a.album_id
  JOIN users u ON r.user_id = u.user_id
  ORDER BY r.review_id DESC
  LIMIT 10
";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrakList - Home</title>
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
    <a href="profile.php" class="profile-link">View Profile</a>
</header>

<!-- main content -->
<div class="main-content">

    <!-- popular albums -->
    <section>
        <h2>Popular Albums</h2>
        <div class="albums">
            <?php foreach ($albums["albums"]["items"] as $album): ?>
                <div class="album">
                    <img src="<?= $album["images"][0]["url"] ?>" width="150">
                    <p><strong><?= $album["name"] ?></strong></p>
                    <p><?= $album["artists"][0]["name"] ?></p>
                    <a href="review.php?id=<?= $album['id'] ?>&name=<?=
                    urlencode($album['name']) ?>&artist=<?= urlencode($album
                    ['artists'][0]['name']) ?>&image=<?= urlencode($album
                    ['images'][0]['url']) ?>"><button>Review</button> </a>

                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- reviews -->
        <div class="review-section">
          <h2>New Reviews</h2>
          <?php while($row = $result->fetch_assoc()): ?>
            <div class="review-card">
              <img src="<?= htmlspecialchars($row['album_cover']) ?>" alt="Album Cover" width="150">
              <div>
                <p><strong><?= htmlspecialchars($row['album_title']) ?></strong> by <?= htmlspecialchars($row['artist']) ?></p>
                <p>Reviewed by <b><?= htmlspecialchars($row['username']) ?></b></p>
                <p>Rating: <?= $row['rating'] ?>/10</p>
                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
              </div>
            </div>
          <?php endwhile; ?>
        </div>


</div>

</body>
</html>
