<?php

function connect() {
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

return $conn = new mysqli($servername, $username, $password, $dbname);
}