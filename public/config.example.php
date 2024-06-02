<?php

require_once __DIR__ . '/../vendor/autoload.php';


$servername = getenv('DB_SERVERNAME'); // obtém o nome do servidor do ambiente
$username = getenv('DB_USERNAME'); // obtém o nome de usuário do ambiente
$password = getenv('DB_PASSWORD'); // obtém a senha do ambiente
$dbname = getenv('DB_DATABASE'); // obtém o nome do banco de dados do ambiente

$conn = new MysqliDb ($servername,
    $username,
    $password,
    $dbname);