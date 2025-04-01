<?php include 'fetch_popular.php'; ?>
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
    <h1>TrakList</h1>
    <form action="fetch_album.php" method="GET" class="search-bar">
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
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- reviews -->
        <h2>New Reviews</h2>


</div>

</body>
</html>
