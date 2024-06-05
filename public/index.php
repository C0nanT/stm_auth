<?php
require './config.php';


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminário - Uniasselvi</title>

    <link rel="stylesheet" href="dist/css/styles.min.css">
    <script src="dist/js/scripts.min.js"></script>
    <style>

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            overflow: hidden;

            display: flex;
            width: 100vw;
            height: 100vh;
        }

        .pic {
            width: 50%;
            height: 100%;
            overflow: hidden;
            /* background-image: url("https://4kwallpapers.com/images/wallpapers/dark-blue-pink-2560x2560-12661.jpg");*/
            background-image: url("assets/images/bg_unsplash.jpg");
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 50%;
            height: 100%;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }


        @media only screen and (max-width: 750px) {
            .pic {
                display: none;
            }

            /* .pic2 {
                display: block;
            } */
            .container {
                width: 100%;
            }
        }

        img {
            width: 120px;
            border-radius: 10px;
            border: 1px solid #494954;
        }

        .inp {
            width: 350px;
            height: 50px;
            display: flex;
            align-items: center;
            position: relative;
        }

        a {
            text-decoration: none;
            color: #000000;
        }

        .forgot-password {
            margin-top: 10px;
            display: block;
            text-align: center;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #0d6efd;
        }

    </style>

</head>

<body>
<div class="container">

    <div class="pic2"></div>

    <div class="row">
        <div class="col-12" style="min-width: 350px">
            <lottie-player src="assets/json/logo.json" background="transparent" speed="1"
                           style="width: 100px; height: 100px;" loop autoplay></lottie-player>
            <h2>Login</h2>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="button"
                            id="btnLogin"
                            class="btn btn-dark my-2 w-100">
                        Entrar
                    </button>
                </div>
                <div id="alert-container" class="text-center small"></div>
            </form>
            <a href="forgot_password.php" class="forgot-password">Esqueci minha senha</a>
            <a href="create_account.php" class="forgot-password">Criar uma conta</a>

        </div>
    </div>


</div>
<div class="pic"></div>
</body>
<script>

    $(document).ready(function () {

        $.ajax({
            url: 'app.php?action=verificarAutomigrate',
            type: 'GET',
            dataType: 'json',
            data: {
                action: 'verificarAutomigrate'
            },
            success: function (data) {

                var alertClass = data.success ? 'alert-success' : 'alert-danger';
                var alertMessage = data.message;

                var alertElement = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                    alertMessage +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');

                //  $('#alert-container').append(alertElement);
            },
            error: function () {
                var alertElement = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    'Erro ao verificar a migração do banco de dados.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');

                $('#alert-container').append(alertElement);
            }
        });

        $('#btnLogin').on('click', function (e) {


            var btn = $(this).find('button[type="submit"]');
            btn.addClass('loading').prop('disabled', true);

            var email = $('#email').val().trim();
            var password = $('#password').val().trim();

            // Verifica se os campos estão preenchidos
            if (email === '' || password === '') {
                var messageElement = $('#alert-container');
                messageElement.text('Preencha todos os campos.');
                messageElement.addClass('animate__animated animate__fadeIn text-danger');
                setTimeout(function () {
                    messageElement.removeClass('animate__animated animate__fadeIn');
                    messageElement.text('');
                }, 2000);
                return;
            }


            $.ajax({
                url: 'app.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'login',
                    email: email,
                    password: password
                },
                success: function (data) {
                    var messageElement = $('#alert-container');
                    if (data.authenticated) {
                        messageElement.text('Login bem-sucedido!');
                        messageElement.addClass('animate__animated animate__fadeIn');
                        //enviar para a página de dashboard
                        setTimeout(function () {
                            window.location.href = 'dashboard.php?auth=true';
                        }, 2000);
                    } else {
                        messageElement.text('Email ou senha incorretos.');
                        messageElement.addClass('animate__animated animate__fadeIn text-danger');
                    }
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                },
                error: function () {
                    var messageElement = $('#alert-container');
                    messageElement.text('Erro ao fazer login.');
                    messageElement.addClass('animate__animated animate__fadeIn');
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                },
                complete: function () {
                    // Remove a classe 'loading' do botão e reativa-o
                    btn.removeClass('loading').prop('disabled', false);
                }
            });

        });
    });

</script>
</html>