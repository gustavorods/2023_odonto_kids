<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard/dashboard.css">
    <!-- <link rel="stylesheet" href="../css/servicos/servicos_responsivo.css"> -->
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>
<body>

    <?php
        session_start();

        $session_responsavel_id = $_SESSION['responsavel_id'] ?? null;
        $cookie_responsavel_id = $_COOKIE['responsavel_id'] ?? null;

        if (empty($cookie_responsavel_id) && empty($session_responsavel_id)) {
            header("Location: /2023_odonto_kids/assets/pages/login.php");
            exit;
        }

        include_once $_SERVER['DOCUMENT_ROOT'] . '/2023_odonto_kids/assets/php/metodos_dashboard.php';
        $metodos_dashboard = new metodos_dashboard();

        $responsavel_id = !empty($cookie_responsavel_id) ? $cookie_responsavel_id : $session_responsavel_id;

        if (!is_numeric($responsavel_id) || $responsavel_id <= 0) {
            header("Location: /2023_odonto_kids/assets/pages/login.php");
            exit;
        }

        $metodos_dashboard->setResponsavelId($responsavel_id);
        $consultasOrganizadas = $metodos_dashboard->listar_proximas_consultas();
    ?>

    <script>
        // Passando a variável PHP para o JavaScript (debugar)
        const responsavel_id = <?php echo json_encode($responsavel_id); ?>;
    </script>

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
    <div class="dashboard"> 

        <div id="fade"></div>

        <!-- Detalhes proxima consulta card -->
        <?php
            include './views/detalhes-card-proxima-consulta.php'
        ?>
        
        <div class="proxima-consulta"> 

            <!-- Titulo -->
            <h1 class="titulo-proxima-consulta"> 
                PRÓXIMAS CONSULTAS:
            </h1>   

            <div class="cards-proximas-consultas">
                <!-- Card -->
                <div class="card-marcar-consulta">
                    <div class="container">
                        <div class="mais">+</div>
                        <div class="texto">Marcar consulta</div>
                    </div>
                </div>

                <?php
                    include_once './views/cards-proxima-consulta.php'
                ?>

            </div>

            </div>
        </div>


        <div class="historico-consulta">
            <h1>HISTÓRICO DE CONSULTAS:</h1>
            <div class="cards-historico-consulta">
                <?php
                    include './views/cards-historico-consultas.php'
                ?>
            </div>
        </div>        

    </div>

   <!-- Footer -->
   <section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>Endereço</h3>
            <p>Endereço: 619 Albuquerque Travessa - Tucano, PI / 60960-761<br>CNPJ: n° 87.313.818/0001-42</p>
        </div>
        <div class="box">
            <h3>E-mail</h3>
            <a href="#" class="link">OdontoKids@gmail.com</a>
            <a href="#" class="link">SuporteOdontoKids@hotmail.com</a>
        </div>
        <div class="box">
            <h3>Ligue</h3>
            <p>+55 0000-0000</p>
            <p>+55 0000-0000</p>
        </div>
    </div>
    <div class="credit">Copyright © 2023 Odonto Kids LTDA</div>
    </section>

    <script src="/2023_odonto_kids/assets/js/dashboard.js"></script>
</body>
</html>