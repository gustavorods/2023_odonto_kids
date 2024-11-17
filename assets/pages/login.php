<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/login/login.css">
    <!--Logo na aba da google-->
    <link rel="icon" type="image/png" href="../img/geral/Logo.svg">
    <title>Login</title>    
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-dark">
            <div class="container-fluid">
                <a href="javascript:history.back()"><img src="../img/login/seta_voltar.svg" alt="seta de voltar branca" class="navbar_seta_voltar"></a>
        
                <div id="div-logo">
                    <h1>Odonto kids</h1>
                    <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
                </div>

                <!--Apenas uma div sem nada, para que os elementos c    entralizem melhor na tela-->
                <div></div>
            </div>
    </nav>

    <!--Login Card-->
    <div class="container">
       <div class="card">
            <h1>Entrar</h1>
            <span>É bom ter você de volta!</span>

            <!-- Formulário de login -->
            <form method="post" class="login_form">
                <div class="header_input">
                    <img src="../img/login/icone_email.png" alt="icone de user" class="label_icon">
                    <label for="txt_email" class="input_label">Email</label>
                </div>
                <input type="email" name="txt_email" id="txt_email" class="form_input" placeholder="Clique aqui para digitar">
                
                <div class="header_input">
                    <img src="../img/login/Login_senha_input_icon.png" alt="icone de cadeado" class="label_icon">
                    <label for="txt_senha" class="input_label">Senha</label>
                </div>
                <input type="password" name="txt_senha" id="txt_senha" class="form_input" placeholder="Clique aqui para digitar">

                <!-- Botões e ações do usuário -->
                <div class="user_actions">
                    <button type="submit" class="btn_entrar" name="btn_entrar">Entrar</button>
                    <a href="./cadastro.php" class="link" name="btn_criar_conta">Criar uma conta</a>
                    <a href="./recuperar_senha_email.php" class="link" name="btn_recuperar_senha">Esqueceu a senha?</a>
                </div>
                
                <?php
                session_start();

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['btn_entrar'])) {
                        // Importando e inicializando a classe com os métodos necessários
                        include_once '../php/metodos_principais.php';
                        $metodos_principais = new metodos_principais();

                        // Armazena os valores em variáveis
                        $email = $_POST['txt_email'];
                        $senha = $_POST['txt_senha'];

                        // Passa as variáveis
                        $metodos_principais->set_email_user($email);
                        $metodos_principais->set_senha_user($senha);
                        $metodos_principais->set_email_medico($email);
                        $metodos_principais->set_senha_medico($senha);
                        
                        // Verifica se o login existe (retorna a tabela se existir ou false caso contrário)
                        $result = $metodos_principais->login();

                        // Verifica se a consulta retornou uma tabela válida
                        if ($result && ($result['tabela'] == "responsavel" || $result['tabela'] == "medico")) {
                            if (password_verify($senha, $result['senha'])) {
                                // Pegando os dados do usuário  
                                $_SESSION['user'] = $metodos_principais->verificar_email_tabela_e_id($email);

                                // Levando cada usuário para sua dashboard
                                if ($result['tabela'] == "responsavel") {
                                    $id = $metodos_principais->selectId($result['tabela']);
                                    $_SESSION['responsavel_id'] = $id;
                                    setcookie("responsavel_id", $id, time() + (30 * 24 * 60 * 60),"/");
                                    
                                    header("Location:dashboard/dashboard.php"); // Altere para o caminho desejado
                                    exit(); 
                                } else if ($result['tabela'] == "medico") {   
                                    $id = $metodos_principais->selectId($result['tabela']);
                                    $_SESSION['responsavel_id'] = $id;
                                    setcookie("responsavel_id", $id, time() + (30 * 24 * 60 * 60),"/");
                                    
                                    header("Location:perfil-medico.php");
                                    exit();
                                }
                            } else {
                                // Mensagem de senha inválida
                                echo "<p style='color:red'>Senha inválida</p>";
                            }
                        } else {
                            // Mensagem de email inválido
                            echo "<p style='color:red'>Email inválido</p>";
                        }
                    }
                }                    
                ?>
            </form>
       </div>
    </div>
<script src="../js/geral.js"></script>    
</body>
</html>