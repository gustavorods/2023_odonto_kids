<?php
    // include_once '../../../php/dependente.php';
    // $dependente = new Dependente();

    session_start();

    $session_responsavel_id = $_SESSION['responsavel_id'] ?? null;
    $cookie_responsavel_id = $_COOKIE['responsavel_id'] ?? null;

    if (empty($cookie_responsavel_id) && empty($session_responsavel_id)) {
        header("Location: /2023_odonto_kids/assets/pages/login.php");
        exit;
    }

    $responsavel_id = !empty($cookie_responsavel_id) ? $cookie_responsavel_id : $session_responsavel_id;
    
    // debug
    // echo "<script>
    //     console.log('Session Responsavel ID: " . json_encode($session_responsavel_id) . "');
    //     console.log('Cookie Responsavel ID: " . json_encode($cookie_responsavel_id) . "');
    //     console.log('Responsavel ID: " . json_encode($responsavel_id) . "');
    // </script>";    
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Consulta | Odontokids</title>
    <link rel="stylesheet" href="../../../css/geral/default.css">
    <link rel="stylesheet" href="../../../css/confirmar/confirmar.css">
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5c74ac3111.js" crossorigin="anonymous"></script>
</head>
<body>

<!-- Navbar -->
<div class="collapse" id="navbarToggleExternalContent" data-bs-theme="dark">
    <div class="bg-primary p-4 itens-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="odontokids/home">Home</a>
            </li>
            <hr class="linha">

            <li class="nav-item">
                <a class="nav-link active" href="#">Serviços</a>
            </li>
            <hr class="linha">

            <li class="nav-item">
                <a class="nav-link active" href="#">Sobre nós</a>
            </li>
            <hr class="linha">

            <li class="nav-item">
                <a class="nav-link active" href="#">Contato</a>
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
            <img src="../../../img/geral/Logo.svg" alt="Odonto Kids logo">
        </div>


        <!-- Botão para abrir o pop-up -->
        <button id="openPopup">
        <img src="../../../img/geral/foto_perfil_teste.png" alt="perfil_img" height="32px" width="32px">
    </button>

    <!-- O pop-up lateral -->
    <div id="popup" class="popup">
        <div class="popup-header">
    <div class="popup-title">Meu Perfil</div>
    <div class="popup-close">✕</div>
    </div>

    <div class="popup-content">
        <ul>
        <a href="#">
            <li><span>Verificar Agenda</span></li>
        </a>
        <a href="#"> 
            <li><span>Gerenciar Dependentes</span></li>
        </a>
        <a href="#">
            <li><span>Notificações</span></li>
        </a>
        <a href="MinhaConta.html">
            <li><span>Minha Conta</span></li>
        </a>
        <hr>
        <a href="#">
            <li><span>Sair</span></li>
                </a>
            </ul>
        </div>
    </div>
    </div>
</nav>
  
<div class="container">
    <div class="card">
        <h1>Confira as informações abaixo antes de confirmar a consulta</h1>
        <span>Nome do dependente: </span>
        <input type="text" id="nome" readonly>
        <span>Tratamento: </span>
        <input type="text" id="tratamento" readonly>
        <span>Data: </span>
        <input type="date" id="data" readonly>
        <span>Hora: </span>
        <input type="time" id="hora" readonly>
        <button style="margin-top: 28px;" id="btn-confirmar">Confirmar Consulta</button>
    </div>
</div>

<script>
// Recuperar dados do sessionStorage e preencher os inputs
document.getElementById('nome').value = sessionStorage.getItem('nome');
document.getElementById('tratamento').value = sessionStorage.getItem('tratamento');
document.getElementById('data').value = sessionStorage.getItem('data');
document.getElementById('hora').value = sessionStorage.getItem('hora');
</script>


<div class="botao-voltar">
    <div class="circulo">
        <div class="seta">
            <p>&larr;</p>
        </div>
    </div>
</div>

<script src="../../../js/confirmar.js"></script>
<script src="../../../js/comum/bloquearUnload.js"></script>
</body>
</html>