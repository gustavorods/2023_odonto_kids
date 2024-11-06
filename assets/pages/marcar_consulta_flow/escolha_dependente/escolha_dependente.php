<?php
    include_once '../../../php/dependente.php';
    $dependente = new Dependente();

    session_start();

    $session_responsavel_id = $_SESSION['responsavel_id'] ?? null;
    $cookie_responsavel_id = $_COOKIE['responsavel_id'] ?? null;

    if (empty($cookie_responsavel_id) && empty($session_responsavel_id)) {
        header("Location: /2023_odonto_kids/assets/pages/login.php");
        exit;
    }

    $responsavel_id = !empty($cookie_responsavel_id) ? $cookie_responsavel_id : $session_responsavel_id;

    if (!is_numeric($responsavel_id) || $responsavel_id <= 0) {
        header("Location: /2023_odonto_kids/assets/pages/login.php");
        exit;
    }

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
    <title>Agendamento</title>
    <link rel="stylesheet" href="../../../css/escolha_dependente/escolha_dependente.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
  
  <div class="main-container">
    <div class="header">
    <!-- Fazer a verificação se existem pacientes 
    <div class="no-patients">
        <p>Nenhum paciente cadastrado. Clique no botão abaixo para adicionar um novo paciente.</p>
        <div class="btn"> 
            <button type="submit" id="btncadastrarDp" name="btncadastrar" value="btncadastrarDp">
                <i class="fa-solid fa-user-plus" ></i>
                Cadastrar Dependente
            </button>
        </div>
    </div>-->

        <div class="titulo">
            <h2>Qual pequeno será atendido?</h2>
        </div>   

            <button type="submit" id="btncadastrarDp" name="btncadastrarDp" value="btncadastrar">
                <i class="fa-solid fa-user-plus" ></i>
                Cadastrar Dependente
            </button>
    </div>


    <div class="caixa">
        <div class="cards">
            <?php
                include './views/cards-dependentes.php'
            ?>
        </div>
    </div>
    

    <div id="form-container" class="modal">    
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <?php
            // Verifica se o formulário foi enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Recebe os dados do formulário
                $responsavel_id = $_POST['responsavel_id'];  // Assume que este valor vem oculto no formulário
                $nome = $_POST['nome'];
                $nasc = $_POST['data'];
                $cpf = $_POST['cpf'];
                $id_sexo = ($_POST['genero'] === 'Masculino') ? 1 : 2;  // Supondo que 1 é Masculino e 2 é Feminino
                $tel_emergencia = $_POST['telEmerg'];
                $endereco = $_POST['endereco'];

                // Limpa os campos de CPF e telefone para remover caracteres não numéricos
                $cpf = preg_replace('/\D/', '', $cpf);  // Remove tudo que não for número
                $tel_emergencia = preg_replace('/\D/', '', $tel_emergencia);  // Remove tudo que não for número

                // Cria uma instância da classe Dependente
                $dependente = new Dependente($responsavel_id, $nome, $nasc, $cpf, $id_sexo, $tel_emergencia, $endereco);

                // Chama o método para logar os dados
                $dependente->cadastrarDependente();
            }
            ?>          
            <form action="" method="post">
                <h1 class="titulo">Cadastrar Dependente</h1>
                <input type="text" hidden name="responsavel_id" value="<?php echo $responsavel_id; ?>">
                <img src="../../../img/escolha_dependente/form.png" alt="Formulario" style="display: block; margin: 0 auto; width: 80px; height: 80px;">
                <p>Nome Completo: <input id="nome" name="nome" type="text" size="50" required onkeypress="return apenasLetras(event)" placeholder="Digite seu nome completo"></p>
                <p>Data de Nascimento: <input id="data" name="data" type="date" required onkeypress="return blockletras(event)"></p>
                <p>CPF: <input id="cpf" name="cpf" type="text" size="50" maxlength="14" placeholder="000.000.000-00" required></p>
                <p>Sexo: 
                    <select name="genero" required>
                        <option name="pick" value="" disabled selected>Selecione</option>
                        <option name="masc" value="Masculino">Masculino</option>
                        <option name="femi" value="Feminino">Feminino</option>
                    </select>
                </p>
                <p>Telefone de Emergência: <input id="telEmerg" name="telEmerg" type="text" size="30" maxlength="15" required placeholder="(00) 00000-0000"></p>
                <p>Endereço: <input name="endereco" type="text" size="30" placeholder="Digite seu endereço completo"></p>
                <div class="btn-modal">
                    <p><input class="btn-modal" type="submit" value="Cadastrar Dependente"></p>
                </div>
            </form>
        </div>
    </div>
</div>

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


<script src="../../../js/escolha_dependente.js"></script>
</body>
</html>