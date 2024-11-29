<?php
session_start();
// Importando e inicializando as classes necessárias
include_once '../php/sexo.php';
include_once '../php/responsavel.php';
include_once '../php/metodos_principais.php';

// Inicializando as instâncias das classes
$sexo = new sexo();
$responsavel = new responsavel();
$metodos_principais = new metodos_principais();

// Pegando todos os sexos
$all_sexo = $sexo->getAllSexo();

$mensagem = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  if (isset($_POST['Alterar'])) {
    // Armazena os valores em variáveis e mantém os dados no formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $nasc = $_POST['nasc'];

    // Atribuindo valor no sexo
    $sexo_value = $_POST['sexo']; // Recebe o valor do sexo
    $sexo_instancia = new sexo(); // Instanciando o objeto para manipulação
    $sexo_instancia->setSexo($sexo_value);
    $cod_sexo = $sexo_instancia->sexoToId();

    if ($cod_sexo == null) {
      // Se o sexo não for encontrado, podemos adicionar um log ou mensagem de erro aqui
    } else {
      if($email == $_SESSION['dados_user_responsavel']['email']) {
        // Atribuindo os valores para o médico
        $responsavel->setId($_SESSION['dados_user_responsavel']['Id']);
        $responsavel->setNome($nome);
        $responsavel->setEmail($email);
        $responsavel->setCpf($cpf);
        $responsavel->setTelefone($telefone);
        $responsavel->setNasc($nasc);
        $responsavel->setGenero($cod_sexo);
        $responsavel->setSenha($_SESSION['dados_user_responsavel']['senha']); // nesse código não estamos definindo uma senha nova, mas para a função funcionar, o getSenha precisa ter um valor

        // Chamando o método para alterar os dados
        $responsavel->alterar();
        $mensagem = "Informações do responsavel atualizadas com sucesso!";
        header("Location:./perfil_responsavel.php");  
        exit(); 
      } else {
        // Verificando se esse Email já está cadastrado
        $result = $metodos_principais->email_existe($email);
        if ($result == true) {
            $mensagem = 'Esse email já está cadastrado!';
        } else {
          // Atribuindo os valores para o responsavel
          $responsavel->setId($_SESSION['dados_user_responsavel']['Id']);
          $responsavel->setNome($nome);
          $responsavel->setEmail($email);
          $responsavel->setCpf($cpf);
          $responsavel->setTelefone($telefone);
          $responsavel->setNasc($nasc);
          $responsavel->setGenero($cod_sexo);
          $responsavel->setSenha($_SESSION['dados_user_responsavel']['senha']); // nesse código não estamos definindo uma senha nova, mas para a função funcionar, o getSenha precisa ter um valor

          // Chamando o método para alterar os dados
          $responsavel->alterar();
          $mensagem = "Informações do responsavel atualizadas com sucesso!";
          header("Location:./perfil_responsavel.php"); 
          exit(); 
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Cadastro</title>
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
    <h1>Alterar</h1>
    <p>Altere os campos abaixo como preferir</p>
    <form action="#" method="POST">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required value="<?php echo $_SESSION['dados_user_responsavel']['nome']?>">
      </div>
      <div class="form-group">
        <label for="cpf">CPF</label>
        <input type="number" id="cpf" name="cpf" required value="<?php echo $_SESSION['dados_user_responsavel']['cpf']?>">
      </div>
      <div class="form-group">
        <label for="email">email</label>
        <input type="text" id="email" name="email" required value="<?php echo $_SESSION['dados_user_responsavel']['email']?>">
      </div>
      <div class="form-group">
        <label for="telefone">Telefone</label>
        <input type="number" id="telefone" name="telefone" required value="<?php echo $_SESSION['dados_user_responsavel']['telefone']?>">
      </div>
      <div class="form-group">
        <label for="nasc">Data de Nascimento</label>
        <input type="date" id="nasc" name="nasc" required value="<?php echo $_SESSION['dados_user_responsavel']['nasc']?>">
      </div>
      <div class="form-group">
        <label for="sexo">Sexo</label>
        <select id="sexo" name="sexo" required>
          <?php
              if(!empty($all_sexo)) {
                  foreach ($all_sexo as $sexo_item) {
                    $selected = ($sexo_item['sexo'] == $sexo) ? 'selected' : '';
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
