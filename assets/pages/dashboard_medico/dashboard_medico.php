<?php
    session_start();

    $session_medico_id = $_SESSION['medico_id'] ?? null;
    $cookie_medico_id = $_COOKIE['medico_id'] ?? null;

    if (empty($cookie_medico_id) && empty($session_medico_id)) {
        header("Location: /2023_odonto_kids/assets/pages/login.php");
        exit;
    }

    $medico_id = !empty($cookie_medico_id) ? $cookie_medico_id : $session_medico_id;

    echo '<script>console.log('.$medico_id.')</script>';

    if (!is_numeric($medico_id) || $medico_id <= 0) {
        header("Location: /2023_odonto_kids/assets/pages/login.php");
        exit;
    }

    include '../../php/handlers/dashboard_medico/listar_consultas.php';
    $listar_consulta = new listar_consultas();

    $listar_consulta->setMedicoId($medico_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard_medico/dashboard_medico.css">
    <!-- <link rel="stylesheet" href="../css/servicos/servicos_responsivo.css"> -->
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>
<body>

    <!-- Navbar -->
    <div class="collapse" id="navbarToggleExternalContent" data-bs-theme="dark">
            <div class="bg-primary p-4 itens-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="../../index.html">Home</a>
                    </li>
                    <hr class="linha">
    
                    <li class="nav-item">
                        <a class="nav-link active" href="./servicos.html">Serviços</a>
                    </li>
                    <hr class="linha">
    
                    <li class="nav-item">
                        <a class="nav-link active" href="./time-line.html">Sobre nós</a>
                    </li>
                    <hr class="linha">
    
                    <li class="nav-item">
                        <a class="nav-link active" href="./contato.html">Contato</a>
                    </li>
                </ul>
            </div>
    </div>
        
    <nav class="navbar navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent"
                    aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div id="div-logo">
                    <h1>Odonto kids</h1>
                    <img src="/2023_odonto_kids/assets/img/geral/Logo.svg" alt="Odonto Kids logo">
                </div>
        
                <div id="div_perfil">
                    <a href="#">
                        <img class="foto_de_perfil_responsavel" name="img_foto_perfil_responsavel"src="/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png" alt="foto de perfil">
                    </a>
                </div>
            </div>
    </nav>
    <!-- Corpo da página -->
     
    <div class="dashboard_medico"> 

        <div id="fade"></div>

        <div class="proximas-consultas">
            <?php
                include './views/detalhe_proxima_consulta.php';
            ?>

            <h1>
                PRÓXIMAS CONSULTAS:
            </h1>

            <?php
                include './views/cards_proximas_consultas.php';
            ?>
        </div>

        <div class="historico-consulta">
            <h1>
                HISTÓRICO DE CONSULTAS:
            </h1>
            <div class="cards-historico-consulta">
                <?php
                    include './views/cards-historico-consultas.php';
                ?>
            </div>
        </div>

    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/dashboard_medico.js"></script>
</body>
</html>