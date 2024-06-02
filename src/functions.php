<?php
require_once __DIR__ . '/../database/migrate.php';


function verificarAutomigrate()
{
    try {
        $migration = new DatabaseMigration();
        $output = $migration->migrate();

        // Retorna a saída como um JSON
        return ['message' => $output, 'success' => true];
    } catch (Exception $e) {
        return ['message' => $e->getMessage(), 'success' => false];
    }
}

function authenticate($email, $password)
{
    global $db; // Use a instância do banco de dados criada em config.php

    $user = $db->where('email', $email)->getOne('users');
    if ($user) {
        return password_verify($password, $user['password']);
    } else {
        return false;
    }
}