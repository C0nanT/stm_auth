<?php

@include_once './public/config.php';

$sql = "DROP DATABASE IF EXISTS stm_auth";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados deletado". "\n";
} else {
    echo "Erro ao deletar banco de dados: " . $conn->error . "\n";
}

$sql = "CREATE DATABASE stm_auth";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados criado com sucesso". "\n";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error . "\n";
}

$conn->select_db("stm_auth");

$sql = "CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    password_check VARCHAR(255) NOT NULL,
    password_check_response VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela usuario criada com sucesso\n";
} else {
    echo "Erro ao criar tabela: " . $conn->error . "\n";
}

$conn->close();
?>