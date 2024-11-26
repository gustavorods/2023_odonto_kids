<?php
// session_start(); se a página estiver bugada, é so descomentar esse código

// Importando e inicializando as classes necessárias
include_once '../php/metodos_principais.php';

// Inicializando as instâncias das classes
$metodos_principais = new metodos_principais();

// Pegando todos os dados do user
$_SESSION['dados_user_responsavel'] = $metodos_principais->obter_dados_do_user($_SESSION['user']['tabela'], $_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/perfil_responsavel/estilo.css">
    <link rel="stylesheet" href="../css/perfil_responsavel/perfilR.css">
</head>
<body>
    <!-- Navbar -->
    <div class="collapse" id="navbarToggleExternalContent" data-bs-theme="dark">
        <div class="bg-primary p-4 itens-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="/index.html">Home</a>
                </li>
                <hr class="linha">

                <li class="nav-item">
                    <a class="nav-link active" href="/assets/pages/servicos.html">Serviços</a>
                </li>
                <hr class="linha">

                <li class="nav-item">
                    <a class="nav-link active" href="/assets/pages/time-line.html">Sobre nós</a>
                </li>
                <hr class="linha">

                <li class="nav-item">
                    <a class="nav-link active" href="/assets/pages/contato.php">Contato</a>
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
                <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>
             <!-- Botão para abrir o pop-up -->
             <button id="openPopup">
             <?php
                if($_SESSION['dados_user_responsavel']['foto'] == null) {
                    ?>
                    <img src="../img/perfil_medico/perfil_anonimo_icon.png" alt="Imagem de Perfil" height="32px" width="32px" style="border-radius: 50%; border: 1px solid white">
                    <?php
                } else {
                    ?>
                    <img 
                    src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['dados_user_responsavel']['foto']); ?>" 
                    alt="Imagem de Perfil" 
                    height="32px" 
                    width="32px" 
                    style="border-radius: 50%; border: 1px solid white">
                    <?php
                }
             ?>
            </button>
            
             <!-- O pop-up lateral -->
            <div id="popup" class="popup">
                <div class="popup-header">
                    <div class="popup-title">
                     <?php
                     echo $_SESSION['dados_user_responsavel']['nome']
                     ?>
                    </div>
                    <button id="closePopup" class="popup-close">✕</button>
                </div>
                    <div class="popup-content">
                    <ul>
                        <li><a href="#"><span>Agendamentos</span></a></li>
                        <li><a href="#"><span>Prontuários</span></a></li>
                        <li><a href="perfilR.php"><span>Minha Conta</span></a></li>
                        <hr>
                        <li><a href="#"><span>Sair</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

<script src="../js/popupPerfil.js"></script>
</body>
</html>