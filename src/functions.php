<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
            $checkPass = password_verify($password, $user['password']);

            if ($checkPass) {

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

        // Basic validation
        if (empty($nome) || empty($email) || empty($password) ) {
            $retorno['error'] = 'Preencha todos os campos';
            return $retorno;
        }

        $data = [
            'name' => $nome,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'password_check' => false,
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

function getUsers(): MysqliDb|array|string
{

    $db = MysqliDb::getInstance();
    $users = $db->get('users');
    return $users;

}

function recuperarConta($dados): array
{
    $retorno = [
        'success' => false,
        'data' => $dados
    ];

    try {




        $db = MysqliDb::getInstance();

        // Verificar se o e-mail existe no banco de dados
        $db->where('email', $dados['email']);
        $user = $db->getOne('users');

        if (!$user) {
            $retorno['error'] = 'E-mail não encontrado';
            return $retorno;
        }

        // Gerar um código de recuperação único
        $recoveryCode = bin2hex(random_bytes(8));

        // Salvar o código de recuperação no banco de dados associado ao usuário
        $db->where('id', $user['id']);
        $updated = $db->update('users', ['recovery_code' => $recoveryCode]);

        if (!$updated) {
            $retorno['error'] = 'Erro ao salvar o código de recuperação';
            return $retorno;
        }

        // Enviar um e-mail para o usuário com o código de recuperação
        $subject = "Código de Recuperação";
        $body = "Seu código de recuperação é: $recoveryCode";
        $altBody = "Seu código de recuperação é: $recoveryCode";

        if (!sendEmail($dados['email'], $user['name'], $subject, $body, $altBody)) {
            $retorno['error'] = 'Erro ao enviar o e-mail com o código de recuperação';
            return $retorno;
        }

        $retorno['success'] = true;
        return $retorno;
    } catch (Exception $e) {
        $retorno['error'] = $e->getMessage();
        return $retorno;
    }
}
function verificarCodeConta($dados): array
{
    $retorno = [
        'success' => false,
        'data' => $dados
    ];

    try {
        $db = MysqliDb::getInstance();

        // Verificar se o e-mail existe no banco de dados
        $db->where('email', $dados['email']);
        $user = $db->getOne('users');

        if (!$user) {
            $retorno['error'] = 'E-mail não encontrado';
            return $retorno;
        }

        // Comparar o código de recuperação fornecido com o código armazenado no banco de dados
        if ($user['recovery_code'] !== $dados['recoveryCode']) {
            $retorno['error'] = 'Código de recuperação inválido';
            return $retorno;
        }

        $retorno['success'] = true;
        return $retorno;
    } catch (Exception $e) {
        $retorno['error'] = $e->getMessage();
        return $retorno;
    }
}

function changePassword($dados): array
{
    $retorno = [
        'success' => false,
        'data' => $dados
    ];

    try {
        $db = MysqliDb::getInstance();

        // Verificar se o e-mail existe no banco de dados
        $db->where('email', $dados['email']);
        $user = $db->getOne('users');

        if (!$user) {
            $retorno['error'] = 'E-mail não encontrado';
            return $retorno;
        }

        // Atualizar a senha do usuário no banco de dados
        $newPassword = password_hash($dados['newPassword'], PASSWORD_DEFAULT);
        $db->where('id', $user['id']);
        $updated = $db->update('users', ['password' => $newPassword]);

        if (!$updated) {
            $retorno['error'] = 'Erro ao alterar a senha';
            return $retorno;
        }

        $retorno['success'] = true;
        return $retorno;
    } catch (Exception $e) {
        $retorno['error'] = $e->getMessage();
        return $retorno;
    }
}

function sendEmail($to, $toName, $subject, $body, $altBody = ''): bool
{
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();  // Usar SMTP
        $mail->Host = 'mail.cassonestudio.com.br';  // Servidor SMTP
        $mail->SMTPAuth = true;  // Habilita autenticação SMTP
        $mail->Username = 'stm@cassonestudio.com.br';  // Usuário SMTP
        $mail->Password = 'cco)?]MCjiUB';  // Senha SMTP
        $mail->SMTPSecure = 'tls';  // Ativar TLS, `ssl` também é uma opção
        $mail->Port = 587;  // Porta TCP para se conectar

        // Recipientes
        $mail->setFrom('stm@cassonestudio.com.br', 'Auth');
        $mail->addAddress($to, $toName);  // Adicionar um destinatário

        // Conteúdo
        $mail->isHTML(true);  // Definir o formato do e-mail para HTML
        $mail->Subject = mb_convert_encoding($subject, 'ISO-8859-1', 'UTF-8');
        $mail->Body = $body;
        $mail->AltBody = $altBody;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function fetchNewsFeed(): SimpleXMLElement
{
    $feedUrl = 'https://rss.tecmundo.com.br/feed';
    $news = @simplexml_load_file($feedUrl);

    if ($news === false) {
        throw new Exception('Failed to load news feed.');
    }

    return $news;
}

function parseNewsItem(SimpleXMLElement $item): array
{
    $description = (string) $item->description;
    $description = html_entity_decode($description);
    $description = strip_tags($description);

    $creator = (string) $item->children('dc', true)->creator;

    $enclosure = $item->enclosure['url'] ? (string) $item->enclosure['url'] : null;

    return [
        'title' => (string) $item->title,
        'link' => (string) $item->link,
        'description' => $description,
        'pubDate' => (string) $item->pubDate,
        'creator' => $creator,
        'enclosure' => $enclosure,
    ];
}

function getFeedAll($dados = []): array
{
    $response = [
        'success' => false,
        'data' => $dados
    ];

    try {
        $news = fetchNewsFeed();

        $feeds = [];
        foreach ($news->channel->item as $item) {
            $feeds[] = parseNewsItem($item);
        }

        $response['success'] = true;
        $response['data'] = ['items' => $feeds]; // Wrap the feeds array into an associative array
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    return $response;
}

function menuApp()
{
    $menu = '
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="dashboard-users.php">Usuários</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="dashboard-feed.php">Feed</a>
        </li>
    </ul>';

    return $menu;
}