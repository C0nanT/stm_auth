<?php
require './config.php';


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminário - Uniasselvi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/style.css">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
<div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Logar</button>
    </form>
    <a href="forgot_password.php" class="forgot-password">Esqueci minha senha</a>
    <a href="create_account.php" class="forgot-password">Criar uma conta</a>


    <div id="alert-container"></div>
</div>
</body>
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'app.php?action=verificarAutomigrate',
            type: 'GET',
            dataType: 'json',
            data: {
                action: 'verificarAutomigrate'
            },
            success: function(data) {

                var alertClass = data.success ? 'alert-success' : 'alert-danger';
                var alertMessage = data.message;

                var alertElement = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                    alertMessage +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');

              //  $('#alert-container').append(alertElement);
            },
            error: function() {
                var alertElement = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    'Erro ao verificar a migração do banco de dados.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');

                $('#alert-container').append(alertElement);
            }
        });


        $('form').on('submit', function(e) {
            e.preventDefault();

            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                url: 'app.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'login',
                    email: email,
                    password: password
                },
                success: function(data) {
                    if (data.authenticated) {
                        alert('Login bem-sucedido!');
                        //enviar para a página de dashboard
                        window.location.href = 'dashboard.php?auth=true';
                    } else {
                        alert('Email ou senha incorretos.');
                    }
                },
                error: function() {
                    alert('Erro ao fazer login.');
                }
            });
        });
    });



</script>
</html>