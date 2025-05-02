<!DOCTYPE html>
<html>
<head>
    <title>Traklist Library</title>
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

  <?php
  // Spotify API credentials
  $client_id = "c342de741f684584b6ad262fa29dc01c";
  $client_secret = "5f23009a00594988b0dc46a44cd3a69f";

  // Get access token
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Authorization: Basic " . base64_encode("$client_id:$client_secret"),
      "Content-Type: application/x-www-form-urlencoded"
  ]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($response, true);
  $access_token = $data["access_token"] ?? null;

  if (!$access_token) {
      die("Failed to retrieve access token.");
  }

  // Get search query from user input
  if (!isset($_GET["query"])) {
      die("No search term provided.");
  }
  $search_query = urlencode($_GET["query"]);

  // Send request to Spotify Search API
  $search_url = "https://api.spotify.com/v1/search?q={$search_query}&type=album&limit=20";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $search_url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Authorization: Bearer " . $access_token
  ]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $search_response = curl_exec($ch);
  curl_close($ch);

  $search_results = json_decode($search_response, true);

  /* Display results */
  foreach ($search_results["albums"]["items"] as $album): ?>
  <div class="album-card">
    <img src="<?= htmlspecialchars($album['images'][0]['url']) ?>" width="100">
    <p><strong><?= htmlspecialchars($album['name']) ?></strong></p>
    <p>Artist: <?= htmlspecialchars($album['artists'][0]['name']) ?></p>

    <!-- Review Button: send data via GET -->
    <form action="review.php" method="GET">
      <input type="hidden" name="album_id" value="<?= htmlspecialchars($album['id']) ?>">
      <input type="hidden" name="album_name" value="<?= htmlspecialchars($album['name']) ?>">
      <input type="hidden" name="artist" value="<?= htmlspecialchars($album['artists'][0]['name']) ?>">
      <input type="hidden" name="album_cover" value="<?= htmlspecialchars($album['images'][0]['url']) ?>">
      <button type="submit">Review</button>
    </form>
  </div>
<?php endforeach; ?>
  }
  ?>

</body>
