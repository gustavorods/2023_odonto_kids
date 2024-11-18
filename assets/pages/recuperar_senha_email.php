<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/recuperar_senha/recuperar_senha_email.css">
    <!--Logo na aba da google-->
    <link rel="icon" type="image/png" href="../img/geral/Logo.svg">
    <title>Recuperar senha</title>
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a href="javascript:history.back()"><img src="../img/recuperar_senha/seta_voltar.svg" alt="seta de voltar branca" class="navbar_seta_voltar"></a>

            <div id="div-logo">
                <h1>Odonto kids</h1>
                <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>

            <!--Apenas uma div sem nada, para que os elementos centralizem melhor na tela-->
            <div></div>
        </div>
    </nav>
                
<!--recuperar senha Card-->
<div class="container">
   <div class="card">
        <h1>Digite seu email</h1>
        <span>Isso acontece. Vamos recuperar sua senha!</span>

        <!-- Formulário de recuperar senha -->
        <form method="post" class="recuperar_senha_form">
            <div class="header_input">
                <img src="../img/recuperar_senha/icone_email.png" alt="icone de email" class="label_icon">
                <label for="txt_email" class="input_label">Email</label>
            </div>
            <input type="email" name="txt_email" id="txt_email" class="form_input" required placeholder="Clique aqui para digitar">

            <!-- Botões e ações do usuário -->
            <div class="user_actions">
                <button type="submit" class="btn_continuar" name="btn_continuar">Continuar</button>
            </div>

            <?php
                $message = "";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['btn_continuar'])) {
                        // Extraindo elementos do método POST 
                        extract($_POST, EXTR_OVERWRITE);

                        // Iniciando sessão (isso é importante pra saber para lidar com a verificação em "recuperar_senha_code.php")
                        session_start();

                        /* Nesse código são criadas duas variaveis de sessao, uma pra armazenar o email que vai ser exibido na próxima página
                        (recuperar_senha_code.php), e uma pra armazenar o código de verificação enviado por email, 
                        que vai ser usado para fazer a verificação na próxima página (recuperar_senha_code.php) */ 

                        $_SESSION["txt_email"] = $txt_email;
                        
                        // Importação de métodos auxiliares
                        include_once '../php/metodos_principais.php'; 
                        include_once '../php/enviar_cod_email.php';
                        $metodos_principais = new metodos_principais();

                        // Verifica se o email existe no banco de dados
                        $resposta_email_existe = $metodos_principais->email_existe($_SESSION["txt_email"]);
                        
                        // Se o email existir, envia o código de recuperação
                        if($resposta_email_existe != false) {
                            $_SESSION["codigo"] = sendEmailWithCode($_SESSION["txt_email"]);
                            header("Location:./recuperar_senha_code.php");
                            exit();
                        } else {
                            $message = "Esse email não esta cadastrado";
                            ?>

                            <br>
                            
                            <?php
                            echo "<center> <p style='color:red'>" . $message . "</p> </center>";
                        }
                    }
                }
            ?>
        </form>
   </div>
</div>
</body>
</html>