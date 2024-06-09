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

            overflow: auto;
            overflow-x: hidden;
            display: flex;
            width: 100vw;

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
                <div class="col-12 w-100" style="min-width:350px">
                    <a href="create_account.php" class="btn btn-light my-2">Voltar</a>
                    <h1 class="display-4">Política de Privacidade</h1>
                    <h2 class="h4">1. Coleta de Dados</h2>

                    <p>Dados Coletados: Nome completo, e-mail, senha.</p>
                    <p>Finalidade: Os dados são coletados exclusivamente para a criação e manutenção de uma conta de
                        usuário no sistema.</p>
                    <h2 class="h4">2. Uso dos Dados</h2>

                    <p>Autenticação: Os dados são usados para autenticar o usuário no sistema.</p>
                    <p>Comunicação: O e-mail pode ser usado para comunicações relacionadas ao sistema, como recuperação
                        de senha.</p>
                    <h2 class="h4">3. Segurança</h2>

                    <p>Proteção dos Dados: Todas as senhas são armazenadas de forma criptografada. Medidas de segurança
                        são aplicadas para proteger os dados de acessos não autorizados.</p>
                    <h2 class="h4">4. Acesso e Controle</h2>

                    <p>Direitos do Usuário: Os usuários podem solicitar a exclusão ou alteração de suas informações a
                        qualquer momento.</p>
                    <h2 class="h4">5. Alterações</h2>

                    <p>Atualizações da Política: Esta política pode ser atualizada periodicamente. Os usuários serão
                        notificados de quaisquer mudanças significativas.</p>
                    <h1 class="display-4">Termos de Uso</h1>
                    <h2 class="h4">1. Aceitação dos Termos</h2>

                    <p>Ao criar uma conta, o usuário concorda com estes termos.</p>
                    <h2 class="h4">2. Uso da Conta</h2>

                    <p>Responsabilidades: O usuário é responsável por manter a confidencialidade de sua senha e por
                        todas as atividades que ocorrem sob sua conta.</p>
                    <h2 class="h4">3. Proibições</h2>

                    <p>Uso Indevido: É proibido usar a conta para atividades ilegais, disseminação de malware, phishing
                        ou qualquer outra atividade prejudicial.</p>
                    <h2 class="h4">4. Limitações</h2>

                    <p>Isenção de Responsabilidade: O sistema é fornecido "como está", e o desenvolvedor não é
                        responsável por falhas de segurança ou perda de dados.</p>
                    <h2 class="h4">5. Resolução de Conflitos</h2>

                    <p>Foro: Qualquer disputa relacionada ao uso do sistema será resolvida na jurisdição local.</p>
                    <h2 class="h4">6. Modificações</h2>

                    <p>Alterações dos Termos: Os termos de uso podem ser alterados a qualquer momento. Os usuários serão
                        notificados de quaisquer mudanças significativas.</p>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
<script>

    $(document).ready(function () {

    });


</script>
</html>