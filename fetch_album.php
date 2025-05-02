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

// Fetch album details
$album_id = $_GET["id"] ?? "default_album_id";
$album_url = "https://api.spotify.com/v1/albums/" . $album_id;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $album_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $access_token
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$album_response = curl_exec($ch);
curl_close($ch);

$album_data = json_decode($album_response, true);

// Display album details
if (isset($album_data["name"])) {
    echo "<h1>Album: " . $album_data["name"] . "</h1>";
    echo "<p>Artist: " . $album_data["artists"][0]["name"] . "</p>";
    echo "<p>Release Date: " . $album_data["release_date"] . "</p>";
    echo "<img src='" . $album_data["images"][0]["url"] . "' width='300'>";
} else {
    echo "Failed to fetch album data.";
}
?>
