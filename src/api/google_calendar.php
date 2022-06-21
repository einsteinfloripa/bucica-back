<?php
require_once "./src/api/google_oauth.php";

function insertEvent($attendees = []) {

    $access_token = getAccessToken();

    $email_account = $_ENV['ACCOUNT_EMAIL'];

    $curl = curl_init();

    $info = [
    "end" => [
            "dateTime" => "2022-06-25T19:00:00", 
            "timeZone" => "America/Sao_Paulo" 
        ], 
    "start" => [
                "dateTime" => "2022-06-25T18:00:00", 
                "timeZone" => "America/Sao_Paulo" 
            ], 
    "summary" => "Aula EinsteinFloripa", 
    "attendees" => $attendees, 
    "conferenceData" => [
                "createRequest" => [
                "conferenceSolutionKey" => [
                        "type" => "hangoutsMeet" 
                    ], 
                "requestId" => "bucica" 
                ] 
        ] 
    ]; 

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://www.googleapis.com/calendar/v3/calendars/$email_account/events?conferenceDataVersion=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($info),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    return false;
    } else {
    return array("Meet" => json_decode($response)->conferenceData->conferenceId,"Id" => json_decode($response)->id);
    }
}

function getEvent($eventId) {

    $access_token = getAccessToken();

    $email_account = $_ENV['ACCOUNT_EMAIL'];

    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://www.googleapis.com/calendar/v3/calendars/$email_account/events/$eventId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return false;
    } else {
        return array("Attendees" => json_decode($response)->attendees);
    }
}

function patchEvent($eventId, $attendees) {

    $access_token = getAccessToken();

    $email_account = $_ENV['ACCOUNT_EMAIL'];

    $curl = curl_init();

    $info = [
        "attendees" => $attendees, 
    ]; 

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://www.googleapis.com/calendar/v3/calendars/$email_account/events/$eventId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PATCH",
    CURLOPT_POSTFIELDS => json_encode($info),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return false;
    } else {
        return array("Attendees" => json_decode($response)->attendees);
    }
}