<?php

class DatabaseMigration
{
    private $conn;
    private $dbName = "stm_auth";

    public function __construct()
    {
        $servername = ""; // replace with your server name
        $username = ""; // replace with your username
        $password = ""; // replace with your password

        try {
            $this->conn = new mysqli($servername, $username, $password);
        } catch (Exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function migrate()
    {
        try {
            $this->dropDatabase();
            $this->createDatabase();
            $this->createUsersTable();
            $this->insertAdminUser();
        } catch (Exception $e) {
            echo "Error during migration: " . $e->getMessage();
        }
    }

    private function dropDatabase()
    {
        $sql = "DROP DATABASE IF EXISTS $this->dbName";
        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao deletar banco de dados: " . $this->conn->error);
        }
    }

    private function createDatabase()
    {
        $sql = "CREATE DATABASE $this->dbName";
        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao criar banco de dados: " . $this->conn->error);
        }

        $this->conn->select_db($this->dbName);
    }

    private function createUsersTable()
    {
        $sql = "CREATE TABLE users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            password_check VARCHAR(255) NOT NULL,
            password_check_response VARCHAR(255) NOT NULL
        )";

        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao criar tabela: " . $this->conn->error);
        }
    }

    private function insertAdminUser()
    {
        $password = password_hash('admin', PASSWORD_DEFAULT);
        $password_check_response = 'admin';

        $sql = "INSERT INTO users (name, email, password, password_check, password_check_response)
                VALUES ('admin', 'admin@admin.com', '$password', 'Qual seu nome de usuário?', '$password_check_response')";

        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao adicionar usuário admin: " . $this->conn->error);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}

$migration = new DatabaseMigration();
$migration->migrate();

