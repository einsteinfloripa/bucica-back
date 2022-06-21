<?php

function getAccessToken() {

$client_id = $_ENV['CLIENT_ID'];
$client_secret = $_ENV['CLIENT_SECRET'];
$refresh_token = $_ENV['REFRESH_TOKEN'];

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://accounts.google.com/o/oauth2/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "client_id=$client_id&client_secret=$client_secret&refresh_token=$refresh_token&grant_type=refresh_token",
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/x-www-form-urlencoded"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  return false;
} else {
  return json_decode($response)->access_token;
}

}