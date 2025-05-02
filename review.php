<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$album_id = $_GET['album_id'] ?? '';
$album_name = $_GET['album_name'] ?? '';
$artist = $_GET['artist'] ?? '';
$album_cover = $_GET['album_cover'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Review Album</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="review-form">
      <h2>Write a Review for <?= htmlspecialchars($album_name) ?></h2>
<img src="<?= htmlspecialchars($album_cover) ?>" width="150"><br>
<p><strong><?= htmlspecialchars($artist) ?></strong></p>

<form action="submit_review.php" method="POST">
<input type="hidden" name="album_id" value="<?= htmlspecialchars($album_id) ?>">
<input type="hidden" name="album_name" value="<?= htmlspecialchars($album_name) ?>">
<input type="hidden" name="artist" value="<?= htmlspecialchars($artist) ?>">
<input type="hidden" name="album_cover" value="<?= htmlspecialchars($album_cover) ?>">

<label>Rating:</label>
<select name="rating" required>
  <option value="">--</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
</select><br>

<label>Description:</label><br>
<textarea name="description" rows="4" cols="50" required></textarea><br>

<button type="submit">Submit Review</button>
</form>
    </div>
</body>
</html>
