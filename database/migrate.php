<?php

class DatabaseMigration
{
    private $conn;
    private $dbName;

    /**
     * Construtor da classe DatabaseMigration.
     */
    public function __construct()
    {

        $output = [];

        $servername = getenv('DB_SERVERNAME'); // obtém o nome do servidor do ambiente
        $username = getenv('DB_USERNAME'); // obtém o nome de usuário do ambiente
        $password = getenv('DB_PASSWORD'); // obtém a senha do ambiente
        $this->dbName = getenv('DB_DATABASE'); // obtém o nome do banco de dados do ambiente

        $output [] = "Tentando conectar ao banco de dados: $servername\n";

        try {
            $this->conn = new mysqli($servername, $username, $password);
            if ($this->conn->connect_error) {
                $output [] = ("Falha na conexão: " . $this->conn->connect_error);
            }
            $output [] =  "Conexão estabelecida com sucesso\n";
        } catch (Exception $e) {
            $output[] =  ("Connection failed: " . $e->getMessage());
        }


        return $output;

    }

    public function migrate()
    {
        $output = [];

        try {
            $output[] = "Iniciando migração...\n";
            $this->dropDatabase();
            $this->createDatabase();
            $this->createUsersTable();
            $this->insertAdminUser();
            $output[] = "Migração concluída com sucesso\n";
        } catch (Exception $e) {
            $output[] = "Erro durante a migração: " . $e->getMessage();
        }

        // Retorna a saída como uma string
        return $output;
    }

    public function checkMigrationTable()
    {
        $sql = "SHOW TABLES LIKE 'users'";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;

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
