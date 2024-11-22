<?php
session_start();
// Importando e inicializando as classes necessárias
include_once '../php/sexo.php';
include_once '../php/dependente.php';
include_once '../php/metodos_principais.php';

// Inicializando as instâncias das classes
$sexo = new sexo();
$metodos_principais = new metodos_principais();
$dependente = new Dependente();

// Pegando todos os sexos
$all_sexo = $sexo->getAllSexo();

$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_POST['Alterar'])) {
      // Armazena os valores em variáveis e mantém os dados no formulário
      $nome = $_POST['nome_completo'];
      $tel_emergencia = $_POST['telefone_emergencia'];
      $endereco = $_POST['endereco'];
      $nasc = $_POST['nasc'];
      $cpf = $_POST['cpf'];
  
      // Atribuindo valor no sexo
      $sexo_value = $_POST['sexo']; // Recebe o valor do sexo
      $sexo_instancia = new sexo(); // Instanciando o objeto para manipulação
      $sexo_instancia->setSexo($sexo_value);
      $cod_sexo = $sexo_instancia->sexoToId();
  
      if ($cod_sexo == null) {
        // Se o sexo não for encontrado, podemos adicionar um log ou mensagem de erro aqui
      } else {
        // Atribuindo os valores para o dependente
        $dependente->setId($_SESSION['dados_dependente']['id']);
        $dependente->setNome($nome);
        $dependente->setCpf($cpf);
        $dependente->setTelEmergencia($tel_emergencia);
        $dependente->setEndereco($endereco);
        $dependente->setNasc($nasc);
        $dependente->setIdSexo($cod_sexo);

        // Chamando o método para alterar os dados
        $dependente->alterar();
        $mensagem = "Informações do dependente atualizadas com sucesso!";
        header("Location:./perfil_dependente.php");  
        exit(); 
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Alterar</title>
  <style>
    @import '../css/geral/header_seta_voltar.css'; /* Importação do CSS do header */

    /* Estilos para o formulário */
    .form-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #007bff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      font-family: Arial, sans-serif;
      text-align: center;
    }

    .form-container h1 {
      font-size: 24px;
      color: #007bff;
      margin-bottom: 15px;
    }

    .form-container p {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
      text-align: left;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      font-weight: bold;
      color: #007bff;
      margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #007bff;
      border-radius: 4px;
      font-size: 14px;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: #0056b3;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-submit {
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-dark">
    <div class="container-fluid">
      <a href="javascript:history.back()"><img src="../img/recuperar_senha/seta_voltar.svg" alt="seta de voltar branca" class="navbar_seta_voltar"></a>

      <div id="div-logo">
        <h1>Odonto Kids</h1>
        <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
      </div>

      <!-- Apenas uma div vazia para centralizar -->
      <div></div>
    </div>
  </nav>

  <!-- Conteúdo do Formulário -->
  <div class="form-container">
    <h1>Cadastro</h1>
    <p>Preencha os campos abaixo</p>
    <form action="#" method="POST">
      <div class="form-group">
        <label for="nome_completo">Nome Completo</label>
        <input type="text" id="nome_completo" name="nome_completo" required value="<?php echo $_SESSION['dados_dependente']['nome'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="telefone_emergencia">Telefone de Emergência</label>
        <input type="tel" id="telefone_emergencia" name="telefone_emergencia" required value="<?php echo $_SESSION['dados_dependente']['tel_emergencia'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" required value="<?php echo $_SESSION['dados_dependente']['endereco'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="nasc">Data de Nascimento</label>
        <input type="date" id="nasc" name="nasc" required value="<?php echo $_SESSION['dados_dependente']['nasc'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="cpf">CPF</label>
        <input type="number" id="cpf" name="cpf" required value="<?php echo $_SESSION['dados_dependente']['cpf'] ?? ''; ?>">
      </div>
      <div class="form-group">
        <label for="sexo">Sexo</label>
        <select id="sexo" name="sexo" required>
          <?php
              if (!empty($all_sexo)) {
                  foreach ($all_sexo as $sexo_item) {
                      $selected = ($sexo_item['sexo'] == ($_SESSION['dados_dependente_sexo'] ?? '')) ? 'selected' : '';
                      echo "<option value='{$sexo_item['sexo']}' $selected>{$sexo_item['sexo']}</option>";
                  }
              }
          ?>
        </select>
      </div>
      <button type="submit" class="btn-submit" name="Alterar">Alterar</button>
    </form>
    <!-- Mensagem de retorno -->
    <?php if (!empty($mensagem)) { ?>
        <script>alert('<?php echo htmlspecialchars($mensagem); ?>');</script>
    <?php } ?>
  </div>
</body>
</html>
