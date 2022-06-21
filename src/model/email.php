<?php
require_once "./src/database/connection.php";

function getEmailsByIdAluno($idAluno) {
    $query = "SELECT Email FROM `emails` WHERE Id_aluno = '$idAluno'";
    $result = mysqli_query(connect(), $query);


    if (mysqli_num_rows($result)) {
        $arr = array();
        while($row = mysqli_fetch_array($result)) {
            $obj = new stdClass();
            $obj->email = $row['Email'];
            array_push($arr, $obj);
        }
        return $arr;
    } else {
        return false;
    }
}