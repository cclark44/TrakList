<?php
$client_id = "c342de741f684584b6ad262fa29dc01c";
$client_secret = "5f23009a00594988b0dc46a44cd3a69f";

// Get Access Token
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

// Fetch new releases
$url = "https://api.spotify.com/v1/browse/new-releases?limit=10";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $access_token
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$album_response = curl_exec($ch);
curl_close($ch);

$albums = json_decode($album_response, true);
?>
