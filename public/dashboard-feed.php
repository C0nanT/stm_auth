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
        <h5 >
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

                    var card = $('<div class="card">');
                    // Adicione a imagem ao card, se disponível
                    if (item.enclosure) {
                        var cardImage = $('<img class="card-img-top">').attr('src', item.enclosure);
                        card.append(cardImage);
                    }
                    var cardBody = $('<div class="card-body">');
                    var cardTitle = $('<h5 class="card-title">').text(item.title);
                    var cardText = $('<p class="card-text">').text(item.description);
                    var cardLink = $('<a class="card-link">').attr('href', item.link).text('Read more');
                    var cardAuthor = $('<p class="card-text"><small class="text-muted">').text('By ' + item.creator);
                    var cardPubDate = $('<p class="card-text"><small class="text-muted">').text('Published on ' + item.pubDate);



                    // Adicione o título, o texto, o autor, a data de publicação e o link ao corpo do card
                    cardBody.append(cardTitle, cardText, cardAuthor, cardPubDate, cardLink);
                    card.append(cardBody);

                    var item_col = $('<div class="col-sm-3">');
                    item_col.append(card);

                    // Adicione o card ao container
                    feedContainer.append(item_col);
                });
            },
            error: function (e) {
                console.log(e);
                alert('Erro ao tentar buscar os usuários.');
            }
        });
    }
</script>
</body>
</html>
