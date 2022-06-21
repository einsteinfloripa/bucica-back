<?php
require_once "./src/database/connection.php";

function getSalaByDiaAndBlocoAndTurma($dia, $bloco, $turma) {
    $query = "SELECT Meet, Google_id FROM `salas` WHERE Horario LIKE '$dia%' AND Bloco = $bloco AND Turma = '$turma'";
    $result = mysqli_query(connect(), $query);

    if (mysqli_num_rows($result)) {
        return mysqli_fetch_array($result);
    } else {
        return false;
    }
}

function createSala($meet, $googleId, $bloco, $turma) {
    $query = "INSERT INTO `salas` (`Meet`,`Google_id`, `Turma`, `Horario`, `Bloco`) VALUES ('$meet', '$googleId', '$turma', CURRENT_TIMESTAMP, '$bloco')";
    $result = mysqli_query(connect(), $query);

    if (mysqli_num_rows($result)) {
        return mysqli_fetch_array($result);
    } else {
        return false;
    }
}