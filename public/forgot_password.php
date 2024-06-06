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
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
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
            width: 100%;
            height: 100%;
            overflow: hidden;
            /* background-image: url("https://4kwallpapers.com/images/wallpapers/dark-blue-pink-2560x2560-12661.jpg");*/
            background-image: url("assets/images/bg_unsplash.jpg");
            background-size: cover;
            background-position: center;
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

        .container {
            margin-top: 100px;
        }

    </style>

</head>

<body>
<div class="pic">
    <div class="container ">
        <div class="card card-body border-0">
            <div class="pic2"></div>
            <div class="row">
                <div class="col-6 col-6 ">
                    <a href="index.php" class="btn btn-light my-2">Voltar</a>
                    <h2>Recuperar conta</h2>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group" id="recoveryCodeInput" style="display: none;">
                        <label for="recoveryCode">Código de recuperação</label>
                        <input type="text" id="recoveryCode" name="recoveryCode" class="form-control">
                    </div>
                    <div class="form-group" id="newPasswordInput" style="display: none;">
                        <label for="newPassword">Nova senha</label>
                        <input type="password" id="newPassword" name="newPassword" class="form-control">
                    </div>
                    <div class="form-group" id="confirmNewPasswordInput" style="display: none;">
                        <label for="confirmNewPassword">Confirmar nova senha</label>
                        <input type="password" id="confirmNewPassword" name="confirmNewPassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="button" id="btnRequestCode" class="btn btn-dark btn-block my-2">
                            Solicitar código de recuperação
                        </button>
                        <button type="button" id="btnVerifyCode" class="btn btn-dark btn-block my-2" style="display: none;">
                            Verificar código
                        </button>
                        <button type="button" id="btnChangePassword" class="btn btn-dark btn-block my-2" style="display: none;">
                            Alterar senha
                        </button>
                    </div>

                    <div id="message" class="text-center"></div>
                </div>

                <div id="alert-container"></div>
            </div>
        </div>
    </div>
</div>
</body>
<script>

    $(document).ready(function () {
        $('#btnRequestCode').on('click', function (e) {
            var email = $('#email').val().trim();
            $.ajax({
                url: 'app.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'request_recovery_code',
                    email: email
                },
                success: function (data) {
                    var messageElement = $('#message');
                    if (data.success) {
                        messageElement.text('Código de recuperação enviado para o seu e-mail.');
                        messageElement.addClass('animate__animated animate__fadeIn');
                        // Exibir o campo de entrada do código de recuperação e o botão "Verificar código"
                        $('#recoveryCodeInput').show();
                        $('#btnVerifyCode').show();
                        $('#btnRequestCode').hide();

                    } else {
                        messageElement.text('Erro ao solicitar o código de recuperação.');
                        messageElement.addClass('animate__animated animate__fadeIn text-danger');
                    }
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                },
                error: function () {
                    var messageElement = $('#message');
                    messageElement.text('Erro ao fazer a solicitação.');
                    messageElement.addClass('animate__animated animate__fadeIn text-danger');
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                }
            });
        });

        $('#btnVerifyCode').on('click', function (e) {
            var email = $('#email').val().trim();
            var recoveryCode = $('#recoveryCode').val().trim();
            $.ajax({
                url: 'app.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'verify_recovery_code',
                    email: email,
                    recoveryCode: recoveryCode
                },
                success: function (data) {
                    var messageElement = $('#message');
                    if (data.success) {
                        messageElement.text('Código de recuperação verificado com sucesso.');
                        messageElement.addClass('animate__animated animate__fadeIn');
                        // Exibir os campos de entrada da nova senha e o botão "Alterar senha"
                        $('#newPasswordInput').show();
                        $('#confirmNewPasswordInput').show();
                        $('#btnChangePassword').show();
                        $('#btnVerifyCode').hide();

                    } else {
                        messageElement.text('Erro ao verificar o código de recuperação.');
                        messageElement.addClass('animate__animated animate__fadeIn text-danger');
                    }
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                },
                error: function () {
                    var messageElement = $('#message');
                    messageElement.text('Erro ao verificar o código de recuperação.');
                    messageElement.addClass('animate__animated animate__fadeIn text-danger');
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                }
            });
        });

        $('#btnChangePassword').on('click', function (e) {
            var email = $('#email').val().trim();
            var newPassword = $('#newPassword').val().trim();
            var confirmNewPassword = $('#confirmNewPassword').val().trim();
            if (newPassword !== confirmNewPassword) {
                var messageElement = $('#message');
                messageElement.text('As senhas não correspondem.');
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
                    action: 'change_password',
                    email: email,
                    newPassword: newPassword
                },
                success: function (data) {
                    var messageElement = $('#message');
                    if (data.success) {
                        $('#btnChangePassword').hide();

                        messageElement.text('Senha alterada com sucesso.');
                        messageElement.addClass('animate__animated animate__fadeIn');
                        // Redirecionar para a página de login após 2 segundos
                        setTimeout(function () {
                            window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        messageElement.text('Erro ao alterar a senha.');
                        messageElement.addClass('animate__animated animate__fadeIn text-danger');
                    }
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                },
                error: function () {
                    var messageElement = $('#message');
                    messageElement.text('Erro ao alterar a senha.');
                    messageElement.addClass('animate__animated animate__fadeIn text-danger');
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);
                }
            });
        });
    });


</script>
</html>