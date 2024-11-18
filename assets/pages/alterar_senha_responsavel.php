<?php
session_start();

// Importando e inicializando as classes necessárias
include_once '../php/responsavel.php';
$responsavel = new responsavel();

$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  if (isset($_POST['salvar_alteracao_senha'])) {
      $senha_atual = $_POST['atual-password'];
      $senha_nova = $_POST['nova-password'];

      if (password_verify($senha_atual, $_SESSION['dados_user_responsavel']['senha'])) {
        // Verificação para ele não alterar nada caso o campo de senha nova esteja vazio
        if(empty($senha_nova)) {
          $senha_hash = $_SESSION['dados_user_responsavel']['senha'];
        } else {
          $senha_hash = password_hash($senha_nova, PASSWORD_DEFAULT);
        }
        // Setando valores
        $responsavel->setId($_SESSION['dados_user_responsavel']['Id']);
        $responsavel->setSenha($senha_hash);

        $responsavel->alterar_senha();
        $mensagem = "Senha alterada com sucesso!";
        header("Location:./perfil_responsavel.php");  
        exit(); 
      } else {
        $mensagem = "Senha atual incorreta";
      }  
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alteração de Senha</title>
  <style>
    @import '../css/geral/header_seta_voltar.css'; /* Importação do CSS do header */

    /* Estilos para o formulário de alteração de senha */
    .password-reset-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #007bff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      font-family: Arial, sans-serif;
      text-align: center;
    }

    .password-reset-container h1 {
      font-size: 24px;
      color: #007bff;
      margin-bottom: 15px;
    }

    .password-reset-container p {
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

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #007bff;
      border-radius: 4px;
      font-size: 14px;
    }

    .form-group input:focus {
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

  <!-- Conteúdo da Tela de Alteração de Senha -->
  <div class="password-reset-container">
    <h1>Alterar Senha</h1>
    <p>Digite sua nova senha abaixo.</p>
    <form action="#" method="POST">
      <div class="form-group">
        <label for="atual-password">Senha atual</label>
        <input type="password" id="atual-password" name="atual-password">
      </div>
      <div class="form-group">
        <label for="nova-password">Senha nova</label>
        <input type="password" id="nova-password" name="nova-password">
      </div>
      <button type="submit" class="btn-submit" name="salvar_alteracao_senha">Salvar Alterações</button>
    </form>

     <!-- Mensagem de retorno -->
     <?php if (!empty($mensagem)) { ?>
          <script>alert('<?php echo htmlspecialchars($mensagem); ?>');</script>
      <?php } ?>
  </div>
</body>
</html>
