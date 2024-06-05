<?php
require_once __DIR__ . '/../database/migrate.php';


function verificarAutomigrate(): array
{
    try {
        $migration = new DatabaseMigration();

        //Checar se a tabela de migração existe
        if (!$migration->checkMigrationTable()) {
            $output = $migration->migrate();
        } else {
            $output = ['message' => 'Migração já realizada', 'success' => true];
        }


        // Retorna a saída como um JSON
        return ['message' => $output, 'success' => true];
    } catch (Exception $e) {
        return ['message' => $e->getMessage(), 'success' => false];
    }
}

function authenticate($email, $password): bool
{
    $db = MysqliDb::getInstance();

    try {
        $db->where('email', $email);
        $user = $db->getOne('users');

        if ($user) {
            $checkPass =  password_verify($password, $user['password']);

            if($checkPass) {

                //Iniciar sessão com o usuário
                session_start();
                $_SESSION['user'] = $user;


                return true;
            }
        } else {
            return false;
        }

    } catch (Exception $e) {
        return false;
    }
}

function createAccount($dados): array
{
    $retorno = [
        'status' => false
    ];
    $db = MysqliDb::getInstance();
    try {
        $nome = trim($dados['nome']);
        $email = trim($dados['email']);
        $password = trim($dados['password']);
        $pergunta = trim($dados['pergunta']);
        $resposta = trim($dados['resposta']);

        // Basic validation
        if (empty($nome) || empty($email) || empty($password) || empty($pergunta) || empty($resposta)) {
            $retorno['error'] = 'Preencha todos os campos';
            return $retorno;
        }

        $data = [
            'name' => $nome,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'password_check' => $pergunta,
            'password_check_response' => $resposta,
        ];

        $insert = $db->insert('users', $data);

        $retorno['status'] = $insert;

        return $retorno;

    } catch (Exception $e) {

        //verificar se o erro contem Duplicate entry
        if (str_contains($e->getMessage(), 'Duplicate entry')) {
            $retorno['error'] = 'Email já cadastrado';
            return $retorno;
        }

        $retorno ['error'] = $e->getMessage();
        return $retorno;
    }
}

function  getUsers()
{

    $db = MysqliDb::getInstance();
    $users = $db->get('users');
    return $users;

}