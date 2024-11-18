<?php
session_start();

// Importando e inicializando as classes necessárias
include_once '../php/dependente.php';
$dependente = new Dependente();

// Puxando os dados do dependente
$_SESSION['dados_dependente'] = $dependente->infoById($_SESSION['id_dependente']);

var_dump($_SESSION['dados_dependente']);
var_dump($_SESSION['id_dependente']);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil do dependente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/perfil_dependente/estilo.css">
  <link rel="stylesheet" href="../css/perfil_dependente/perfilD.css">
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

<!-- Contêiner principal da página -->
<div class="container">
        <!-- Cabeçalho da página -->
        <div class="header">
          <div class="user-info">
              <form id="foto-perfil" method="post" enctype="multipart/form-data">
              <?php
                  if($_SESSION['dados_dependente']['foto'] == null) {
                      ?>
                      <img src="../img/perfil_medico/perfil_anonimo_icon.png" alt="Imagem de Perfil" style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid gray">
                      <?php
                  } else {
                      ?>
                      <img 
                      src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['dados_dependente']['foto']); ?>" 
                      alt="Imagem de Perfil" 
                      height="32px" 
                      width="32px" 
                      style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid gray">
                      <?php
                  }
              ?>                
              <br>
              <h2><?php echo $_SESSION['dados_dependente']['nome']; ?></h2>
              <br>
                <button type="submit" class="btn3" name="btnAtualizarFoto">
                    <i class="fas fa-upload"></i> Atualizar Foto
                </button>
                <button type="submit" class="btn2" name="btnRemoverFoto">
                    <i class="fas fa-trash-alt"></i> Remover Foto
                </button>
            </form>
          </div>
      </div>
          <!-- Seção de abas de navegação -->
          <div class="nav-tabs">
            <div class="nav-tab active" data-tab="exames">Informações pessoais</div>
            <div class="nav-tab" data-tab="diagnosticos">Exames</div>
            <div class="nav-tab" data-tab="prognostico">Prontuários</div>
          </div>

          <!-- Aba de informações -->
          <div class="content" id="exames">
            <div class="content-header">
              <div class="title">Informações do dependente:</div>
            </div>
            <div class="content-list">
              <div class="content-item-details">
              <label for="nome">Nome completo:</label>
                      <input type="text" id="nomeDP" name="nomeDP" class="input" disabled value="" required>
                      <br><br>

                      <label for="email">Email do responsável:</label>
                      <input type="text" id="email" name="email" class="input" disabled value="" required>
                      <br><br>

                      <label for="Telefone">Telefone de Emergência:</label>
                      <input type="text" id="Telefone" name="Telefone" class="input" disabled value="" required>
                      <br><br>

                      <label for="Telefone">Endereço:</label>
                      <input type="text" id="endereco" name="endereco" class="input" disabled value="" required>
                      <br><br>

                      <label for="nasc">Data de Nascimento:</label>
                      <input type="text" id="nasc" name="nasc" class="input" disabled value="" required>
                      <br><br>

                      <label for="nasc">Sexo:</label>
                      <input type="text" id="sexo" name="sexo" class="input" disabled value="" required>
              </div>
            </div>
            <br><br>
            <button type="button" class="btn3">Alterar Informações</button>
          </div>
          <hr>
          <!-- Pop-up para alterar informações -->
          <div class="editar-tela"  style="display: none;">
          <br>
              <div class="editar-content">
                <form action="perfil.php" method="post">                     
                    <label for="TelefoneEm">Telefone de Emergência:</label>
                    <input type="text" id="Telefone" name="Telefone" class="input" value="" required>
                    
                    <br><br>

                    <label for="Endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" class="input" value="" required>
                  
                    <br><br>

                    <button type="submit" class="btn3" name="btnalterar">Salvar Alterações</button> 
                    <button type="button" class="btn3" >Cancelar</button>
                  </form>
              </div>
          </div>

          <!-- Aba de exame -->
          <div class="content" id="diagnosticos">
            <div class="content-header">
              <div class="title">Exames:</div>
            </div>
            <div class="content-list">
              <div class="content-item">
                <div class="content-item-icon">+</div>
                <div class="content-item-details">
                  Exame Diagnóstico.
                  <br>
                  23/05/2023
                </div>
                <div class="content-item-actions">
                  <button class="download-button">Baixar PDF</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Aba de Prontuários -->
          <div class="content" id="prognostico">
            <div class="content-header">
              <div class="title">Prontuários:</div>
            </div>
            <div class="content-list">
              <div class="content-item-details">
                <p>Não há arquivos</p>
              </div>
            </div>
          </div>

</div>

<script src="../js/popupPerfil.js"></script>
<script src="../js/perfilAbas.js"></script>
</body>
</html>