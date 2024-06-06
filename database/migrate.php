<?php

class DatabaseMigration
{
    private mysqli $conn;
    private string|array|false $dbName;

    /**
     * Construtor da classe DatabaseMigration.
     * @throws Exception
     */
    public function __construct()
    {

        $output = [];

        $servername = getenv('DB_SERVERNAME'); // obtém o nome do servidor do ambiente
        $username = getenv('DB_USERNAME'); // obtém o nome de usuário do ambiente
        $password = getenv('DB_PASSWORD'); // obtém a senha do ambiente
        $this->dbName = getenv('DB_DATABASE'); // obtém o nome do banco de dados do ambiente

        $output [] = "Tentando conectar ao banco de dados: $servername\n";


        $this->conn = @new mysqli($servername, $username, $password);

        if ($this->conn->connect_error) {
            $output [] = ("Falha na conexão: " . $this->conn->connect_error);
            throw new Exception("Falha na conexão: " . $this->conn->connect_error);
        }


        return $output;

    }

    public function migrate(): array
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

    public function checkMigrationTable(): bool
    {

        $db = MysqliDb::getInstance();

        $sql = "SHOW TABLES LIKE 'users'";
        $result = $db->query($sql);
        if (is_array($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    private function dropDatabase(): void
    {
        $sql = "DROP DATABASE IF EXISTS $this->dbName";
        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao deletar banco de dados: " . $this->conn->error);
        }
    }

    private function createDatabase(): void
    {
        $sql = "CREATE DATABASE $this->dbName";
        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao criar banco de dados: " . $this->conn->error);
        }

        $this->conn->select_db($this->dbName);
    }

    private function createUsersTable(): void
    {
        $sql = "CREATE TABLE users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            password_check VARCHAR(255) NOT NULL,
            recovery_code VARCHAR(255)
        )";

        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao criar tabela: " . $this->conn->error);
        }
    }

    /**
     * @throws Exception
     */
    public function insertAdminUser(): array
    {
        $faker = Faker\Factory::create();

        $password = password_hash('admin', PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, password_check)
        VALUES ('admin', 'admin@admin.com', '$password', false)";

        if ($this->conn->query($sql) !== TRUE) {
            throw new Exception("Erro ao adicionar usuário admin: " . $this->conn->error);
        }

        $db = MysqliDb::getInstance();

        //Gerar 100 usuários aleatórios
        $output = []; // Array para armazenar as mensagens de sucesso
        for ($i = 0; $i < 100; $i++) {
            $name = $faker->name;
            $email = $faker->email;
            $password = password_hash($faker->password, PASSWORD_DEFAULT);

            $data = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_check' => 'Qual seu nome de usuário?'
            );

            $id = $db->insert('users', $data);
            if ($id) {
                $output[] = 'Usuário adicionado com sucesso. Id=' . $id; // Adiciona a mensagem ao array
            } else {
                throw new Exception('Erro ao adicionar usuário: ' . $db->getLastError());
            }
        }

        return $output; // Retorna o array com as mensagens de sucesso
    }

    public function __destruct()
    {
        $this->conn->close();
    }


}
