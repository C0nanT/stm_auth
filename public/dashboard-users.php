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
                <ul class="navbar-nav">
                    <?php
                    echo menuApp();
                    ?>

                </ul>

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
            <i class="bi bi-bar-chart-steps"></i>
            Usuários</h5>
        <hr/>

        <div class="container my-4">
            <div id="table"></div>
        </div>
    </div>


</div>
<script>

    // Adicione a tabela ao elemento desejado
    $('#table').append(table);

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

        getUsers();
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

    function getUsers() {
        $.ajax({
            url: 'app.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'getusers'
            },
            success: function (data) {
                var table = $('<table></table>').addClass('table table-hover small text-muted' );

                // Cabeçalho da tabela
                var thead = $('<thead></thead>');
                var headerRow = $('<tr></tr>');
                headerRow.append('<th>Nome</th>');
                headerRow.append('<th>Email</th>');
                // Adicione mais colunas conforme necessário
                thead.append(headerRow);
                table.append(thead);

                // Corpo da tabela
                var tbody = $('<tbody></tbody>');
                data.forEach(user => {
                    var row = $('<tr class="text-muted"></tr>');
                    row.append('<td><i class="bi bi-person"></i> ' + user.name + '</td>');
                    row.append('<td>' + user.email + '</td>');
                    // Adicione mais colunas conforme necessário
                    tbody.append(row);
                });
                table.append(tbody);

                // Adicione a tabela ao elemento desejado
                $('#table').append(table);
            },
            error: function () {
                alert('Erro ao tentar buscar os usuários.');
            }
        });
    }
</script>
</body>
</html>
