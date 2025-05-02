<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];
$album_id = $_POST['album_id'];
$album_name = $_POST['album_name'];
$artist = $_POST['artist'];
$album_cover = $_POST['album_cover'];
$description = $_POST['description'];
$rating = $_POST['rating'];

// Check if album exists
$check_album = $conn->prepare("SELECT album_id FROM albums WHERE album_id = ?");
$check_album->bind_param("s", $album_id);
$check_album->execute();
$check_album->store_result();

if ($check_album->num_rows === 0) {
    // Insert album if not found
    $insert_album = $conn->prepare("INSERT INTO albums (album_id, title, artist, album_cover) VALUES (?, ?, ?, ?)");
    $insert_album->bind_param("ssss", $album_id, $album_name, $artist, $album_cover);
    $insert_album->execute();
}

// Insert review
$insert_review = $conn->prepare("INSERT INTO reviews (album_id, user_id, rating, description) VALUES (?, ?, ?, ?)");
$insert_review->bind_param("sids", $album_id, $user_id, $rating, $description);
$insert_review->execute();

header("Location: home.php");
exit;
?>
