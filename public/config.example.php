<?php

// Inclui o arquivo de autoload gerado pelo Composer. Isso permitirá que o PHP carregue automaticamente todas as bibliotecas instaladas pelo Composer.
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/functions.php';
// Obtém as informações de conexão do banco de dados do ambiente. Isso é uma boa prática, pois mantém informações sensíveis fora do código.
$servername = getenv('DB_SERVERNAME');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_DATABASE');

// Cria uma nova conexão com o banco de dados usando a biblioteca MysqliDb.
$db = new MysqliDb ($servername, $username, $password, $dbname);