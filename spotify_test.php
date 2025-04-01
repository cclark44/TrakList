<?php
$client_id = "c342de741f684584b6ad262fa29dc01c";
$client_secret = "5f23009a00594988b0dc46a44cd3a69f";

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
if (isset($data["access_token"])) {
    echo "Spotify API Connection Successful!<br>";
    echo "Access Token: " . $data["access_token"];
} else {
    echo "Failed to connect to Spotify API.";
}
?>
