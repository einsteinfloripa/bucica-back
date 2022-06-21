<?php
require_once "./src/database/connection.php";


function getPresencaByDatetimeAndAluno($datetimeStart, $datetimeEnd,$idAluno) {
    $query = "SELECT * FROM `presencas`
    WHERE Horario BETWEEN '$datetimeStart' AND '$datetimeEnd' AND Id_aluno = $idAluno";
    $result = mysqli_query(connect(), $query);

    if (mysqli_num_rows($result)) {
        return mysqli_fetch_array($result);
    } else {
        return false;
    }
}


function createPresenca($idAluno, $atrasado) {
    $query = "INSERT INTO `presencas` (`Id`, `Id_aluno`, `Horario`, `Atrasado`) VALUES (NULL, '$idAluno', CURRENT_TIMESTAMP, '$atrasado')";
    $result = mysqli_query(connect(), $query);

    return $result;
}