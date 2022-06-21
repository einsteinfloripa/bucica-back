<?php
require_once "./src/database/connection.php";


function getAlunoByCpf($cpf) {
    $query = "SELECT * FROM `alunos` WHERE cpf = '$cpf'";
    $result = mysqli_query(connect(), $query);

    if (mysqli_num_rows($result)) {
        return mysqli_fetch_array($result);
    } else {
        return false;
    }
}