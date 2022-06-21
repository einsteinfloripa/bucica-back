<?php 
require_once "controller/Presenca.php";
require_once "utils.php";

switch ($URL[2]) {
    case "join":
        return registrarPresenca($INPUT);
        break;
    default:
       return array(404, "Página não encontrada");
}