<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://www.googleapis.com/calendar/v3/calendars/$email_account/events?conferenceDataVersion=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n  \"end\": {\n    \"dateTime\": \"2022-06-11T09:00:00\",\n    \"timeZone\": \"America/Sao_Paulo\"\n  },\n  \"start\": {\n    \"dateTime\": \"2022-06-11T08:00:00\",\n    \"timeZone\": \"America/Sao_Paulo\"\n  },\n  \"summary\": \"TESTE\",\n  \"attendees\": [\n    {\n      \"email\": \"bucica@einsteinfloripa.com.br\"\n    }\n  ],\n  \"conferenceData\": {\n    \"createRequest\": {\n      \"conferenceSolutionKey\": {\n        \"type\": \"hangoutsMeet\"\n      },\n      \"requestId\": \"bucica\"\n    }\n  }\n}",
  CURLOPT_HTTPHEADER => [
    "Authorization: Bearer $access_token",
    "Content-Type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}