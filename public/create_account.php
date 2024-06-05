<?php
require './config.php';


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminário - Uniasselvi</title>

    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/animate/animate.min.css">
    <link rel="stylesheet" href="/assets/style.css">

    <script src="/assets/jquery/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
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

    </style>

</head>

<body>
<div class="pic"></div>
<div class="container">

    <div class="pic2"></div>

    <div class="row">
        <div class="col-12 w-100">
            <a href="index.php" class="btn btn-light my-2">Voltar</a>
            <h2>Criar conta</h2>
            <form action="#" method="POST" class="">
                <div class="form-group">
                    <label for="nome">Nome completo</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_check">Confirme a senha</label>
                    <input type="password" id="password_check" name="password_check" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nome">Pergunta para verificação da conta ?</label>
                    <input type="text" id="pergunta" name="pergunta" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nome">Resposta para verificação da conta</label>
                    <input type="text" id="resposta" name="resposta" class="form-control" required>
                </div>

                <div class="form-group my-2 small">

                    <input type="checkbox" id="concordo" name="concordo" value="concordo">
                    <label for="concordo">Concordo com os termos de uso</label>


                </div>
                <div class="form-group">
                    <button type="button"
                            id="btnCreateAccount"
                            class="btn btn-dark btn-block my-2">
                        Criar conta
                    </button>
                </div>

            </form>
            <div id="alert-container"></div>
        </div>
    </div>


</div>

</body>
<script>

    $(document).ready(function () {

        $('#btnCreateAccount').on('click', function (e) {
            var btn = $(this);
            btn.addClass('loading').prop('disabled', true);

            var nome = $('#nome').val().trim();
            var email = $('#email').val().trim();
            var password = $('#password').val().trim();
            var password_check = $('#password_check').val().trim();
            var pergunta = $('#pergunta').val().trim();
            var resposta = $('#resposta').val().trim();

            // Verifica se os campos estão preenchidos
            if (nome === '' || email === '' || password === '' || password_check === '' || pergunta === '' || resposta === '') {
                var messageElement = $('#alert-container');
                messageElement.text('Preencha todos os campos.');
                messageElement.addClass('animate__animated animate__fadeIn text-danger');
                setTimeout(function () {
                    messageElement.removeClass('animate__animated animate__fadeIn');
                    messageElement.text('');
                }, 2000);

                btn.removeClass('loading').prop('disabled', false);

                return;
            }

            // Verifica se as senhas são iguais
            if (password !== password_check) {
                var messageElement = $('#alert-container');
                messageElement.text('As senhas não são iguais.');
                messageElement.addClass('animate__animated animate__fadeIn text-danger');
                setTimeout(function () {
                    messageElement.removeClass('animate__animated animate__fadeIn');
                    messageElement.text('');
                }, 2000);
                btn.removeClass('loading').prop('disabled', false);
                return;
            }

            //colocar loading no botão colocar loading no botão
            btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Carregando...');


            $.ajax({
                url: 'app.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'create_account',
                    nome: nome,
                    email: email,
                    password: password,
                    pergunta: pergunta,
                    resposta: resposta,
                },
                success: function (data) {

                    //arrumar o html do botão
                    btn.html('Criar conta');

                    var messageElement = $('#alert-container');
                    if (data.status) {
                        messageElement.text('Conta criada com sucesso!');
                        messageElement.addClass('animate__animated animate__fadeIn');
                        setTimeout(function () {
                            //window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        messageElement.text(data.error || 'Erro ao criar conta.');
                        messageElement.addClass('animate__animated animate__fadeIn text-danger');

                    }
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                    }, 2000);

                    btn.removeClass('loading').prop('disabled', false);
                },
                error: function () {

                    //arrumar o html do botão
                    btn.html('Criar conta');

                    var messageElement = $('#alert-container');
                    messageElement.text('Erro ao criar conta.');
                    messageElement.addClass('animate__animated animate__fadeIn');
                    setTimeout(function () {
                        messageElement.removeClass('animate__animated animate__fadeIn');
                        messageElement.text('');
                        btn.removeClass('loading').prop('disabled', false);
                    }, 2000);
                },
                complete: function () {
                    //arrumar o html do botão
                    btn.html('Criar conta');
                    // Remove a classe 'loading' do botão e reativa-o
                    btn.removeClass('loading').prop('disabled', false);
                }
            });
        });
    });


</script>
</html>