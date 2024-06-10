<?php
require './config.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dist/css/styles.min.css">
    <script src="dist/js/scripts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-image: url("assets/images/bg_unsplash.jpg");
            background-size: cover;

        }

        #sidebar {
            background-color: #ffffff;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px; /* Start offscreen */
            height: 100vh;
            overflow-x: hidden;
            transition: all 0.5s ease;
            z-index: 1000;
            padding-top: 60px;
        }

        #sidebar.active {
            left: 0; /* Slide in */
        }

        .sidebar-header {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-align: right;
        }

        .sidebar-header h3 {
            display: inline-block;
            margin: 0;
            color: white;
        }

        #closeMenu {
            background: none;
            border: none;
            font-size: 1.2em;
            color: white;
        }

        ul.components {
            padding: 20px 0;
            list-style: none;
        }

        ul li a {
            padding: 10px;
            display: block;
            font-size: 1.2em;
            color: #007bff;
            text-decoration: none;
        }

        ul li a:hover {
            background: #f8f9fa;
        }

        .content {
            margin-left: 0;
            transition: margin-left 0.5s ease;
        }

        .content.active {
            margin-left: 250px; /* Push content to the right */
        }

        .card-text {
            max-height: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (min-width: 992px) {
            .custom-modal .modal-dialog {
                max-width: 50%;
                margin: 30px auto;
            }
        }

        @media (max-width: 991.98px) {
            .custom-modal .modal-dialog {
                margin: 0;
                max-width: 100%;
                height: 100%;
                min-height: 100vh;
            }

            .custom-modal .modal-content {
                height: auto;
                min-height: 100vh;
                border: 0;
                border-radius: 0;
            }
        }

        .card_feed {
            height: 500px;
            margin-bottom: 24px;
        }

        .modal-custom {
            display: none;
            position: fixed;
            z-index: 1;
            right: 0; /* Alterado de left: 0; para right: 0; */
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;

            border: 1px solid #888;
            width: 50%;
            height: 100%; /* Adicionado para garantir que o modal tenha uma altura de 100% da tela */
            margin: auto 0 auto auto; /* Alterado para alinhar o modal à direita */
        }

        .modal-header {
            padding: 20px;
        }

        .modal-body {
            padding: 20px;
            max-height: calc(100vh - 210px);
            overflow-y: auto; /* Adicionado para garantir que o conteúdo do modal seja rolável */
        }

        .modal-header-image {

            height: 700px;
            overflow: hidden;
            object-fit: cover;
            background: no-repeat center center;
            position: relative;
        }

        .modal-header-image img {
            position: absolute;
            top: 50%;
            left: 50%;
            height: 100%;
            width: auto;
            transform: translate(-50%, -50%);
        }

        @media (min-width: 992px) {
            .modal-dialog {
                max-width: 50%;
                width: 50%;
                height: auto;
                margin: 1.75rem auto;
            }
        }

        .img_feed {
            height: 200px;
            object-fit: cover;
        }

        .no-scroll {
            overflow: hidden;
        }



    </style>
</head>
<body class="bg_dashboard">
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="bi bi-person-badge-fill"></i> Auth</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                echo menuApp();
                ?>

            </ul>


        </div>
        <div class="d-flex small">
            <?php
            echo "<p class='text-dark my-2 mx-2'>Olá, $user[name]</p>";
            ?>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="#" onclick="logout();">Sair</a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<div class="container my-4">

    <div class="card card-body border-0">
        <h5>
            <i class="bi bi-newspaper"></i>

            News
        </h5>
        <hr/>

        <div class="container my-4">

            <div class="row" id="feed">

            </div>

        </div>
    </div>

</div>

<div id="customModal" class="modal-custom">

    <div class="modal-content animate__animated">
        <div class="modal-header-image" id="cover_img"> <!-- Adicionado novo elemento div -->

        </div>
        <div class="modal-header">
            <h5 class="modal-title" id="customModalLabel">Modal Title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModal()" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Modal Content
        </div>
        <div class="modal-footer p-4">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Fechar</button>
        </div>
    </div>
</div>


<script>

    // Adicione a tabela ao elemento desejado


    $(document).ready(function () {

        $('#openMenu').click(function (event) {
            event.stopPropagation();
            $('#sidebar').addClass('active');
            $('body').addClass('active');
        });

        $('#closeMenu, body').click(function (event) {
            // Check if click was triggered on or within #sidebar, if so don't close the sidebar
            if (!$(event.target).closest('#sidebar').length) {
                $('#sidebar').removeClass('active');
                $('body').removeClass('active');
            }
        });

        getFeedAll();

        window.onclick = function(event) {
            var modal = document.getElementById("customModal");
            if (event.target == modal) {
                closeModal();
            }
        }

    });

    function logout() {
        $.ajax({
            url: 'app.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'logout'
            },
            success: function (data) {
                if (data.status) {
                    window.location.href = 'index.php';
                }
            },
            error: function () {
                alert('Erro ao tentar sair.');
            }
        });
    }

    function getFeedAll() {
        $.ajax({
            url: 'app.php?action=feed',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var feedContainer = $('#feed'); // Selecione o container onde os cards serão inseridos
                feedContainer.empty(); // Limpe o container

                // Itere sobre cada item no feed
                $.each(data.data.items, function (index, item) {
                    // Crie um card para o item

                    var card = $('<div class="card card_feed">');
                    // Adicione a imagem ao card, se disponível
                    if (item.enclosure) {
                        var cardImage = $('<img class="card-img-top img_feed">').attr('src', item.enclosure);
                        card.append(cardImage);
                    } else {
                        var cardImage = $('<img class="card-img-top img_feed">').attr('src', '/assets/images/log_app.png');
                        card.append(cardImage);
                        item.enclosure = '/assets/images/log_app.png';
                    }
                    var cardBody = $('<div class="card-body">');
                    var cardTitle = $('<h5 class="card-title">').text(item.title);
                    //var cardText = $('<p class="card-text">').text(item.description);
                    var cardLink = $('<a class="card-link">').attr('href', item.link).text('Acessar publicação na fonte');
                    var cardAuthor = $('<p class="card-text"><small class="text-muted">').text('Fonte ' + item.category);
                    var cardPubDate = $('<p class="card-text"><small class="text-muted">').text('Publicado em ' + item.pubDate);


                    // Adicione o título, o texto, o autor, a data de publicação e o link ao corpo do card
                    cardBody.append(cardTitle, cardAuthor, cardPubDate, cardLink);
                    card.append(cardBody);

                    var item_col = $('<div class="col-sm-3">');
                    item_col.append(card);

                    // Adicione o card ao container
                    feedContainer.append(item_col);

                    card.click(function () {
                        openModal(item);
                    });

                });
            },
            error: function (e) {
                console.log(e);
                alert('Erro ao tentar buscar os usuários.');
            }
        });
    }

    function openModal(item) {
        var modal = document.getElementById("customModal");
        var modalContent = modal.querySelector(".modal-content");
        modal.style.display = "block";
        modalContent.classList.remove("animate__fadeOutRight"); // Alterado para a animação de saída correspondente
        modalContent.classList.add("animate__fadeInRight"); // Alterado para a animação desejada

        // Adicione o título e o conteúdo da notícia ao modal
        var modalTitle = modal.querySelector(".modal-title");
        var modalBody = modal.querySelector(".modal-body");
        var modalImage = modal.querySelector("#modalImage"); // Seleciona a imagem do modal
        modalTitle.textContent = item.title;
        modalBody.textContent = item.description;
      //  modalImage.src = item.enclosure; // Define a imagem do modal
        //adicionar background no id cover_img com css
        $("#cover_img").css("background-image", "url(" + item.enclosure + ")");

        // Desabilitar o scroll da página
        document.body.classList.add("no-scroll");
    }

    function closeModal() {
        var modal = document.getElementById("customModal");
        var modalContent = modal.querySelector(".modal-content");
        modalContent.classList.remove("animate__fadeInRight"); // Alterado para a animação de entrada correspondente
        modalContent.classList.add("animate__fadeOutRight"); // Alterado para a animação desejada
        setTimeout(function() {
            modal.style.display = "none";
        }, 700); // Corresponds to animation duration

        // Habilitar o scroll da página
        document.body.classList.remove("no-scroll");
    }

</script>
</body>
</html>
