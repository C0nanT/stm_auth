<?php
require './config.php';
header('Content-Type: application/json; charset=utf-8');


try {

    //Rota para receber os dados para verificar se houve migracao de dados no banco
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $action = $_GET['action'];

        if ($action == 'verificarAutomigrate') {

            //Verificar nome da action e chamar a funcao
            $retorno = verificarAutomigrate();
            echo json_encode($retorno);

        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];
        if ($action == 'login') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $authenticated = authenticate($email, $password);
            echo json_encode(['authenticated' => $authenticated]);
        }
        if ($action == 'create_account') {

            // Aqui você deve implementar a função createAccount que irá criar a conta do usuário no banco de dados
            $retorno = createAccount($_POST);
            echo json_encode($retorno);
        }
    }

} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}