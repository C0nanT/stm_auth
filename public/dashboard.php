<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
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
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1>Dashboard Content Here</h1>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
    });
</script>
</body>
</html>
