<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Importação do CSS -->
    <link rel="stylesheet" href="../css/recuperar_senha/recuperar_senha_code.css">
    
    <!-- Ícone na aba do navegador -->
    <link rel="icon" type="image/png" href="../img/geral/Logo.svg">
    
    <title>Recuperar senha</title>
</head>
<body>
    <!-- Navbar (barra de navegação) -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <!-- Botão de voltar -->
            <a href="javascript:history.back()">
                <img src="../img/recuperar_senha/seta_voltar.svg" alt="seta de voltar branca" class="navbar_seta_voltar">
            </a>
    
            <!-- Logo e título da página -->
            <div id="div-logo">
                <h1>Odonto Kids</h1>
                <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>

            <!-- Div vazia para alinhar melhor os elementos (ajuda a centralizar) -->
            <div></div>
        </div>
    </nav>

    <!-- Container do card de recuperação de senha -->
    <div class="container">
       <div class="card">
            <!-- Título e subtítulo -->
            <div class="div_titulo_subtitulo">
                <h1>Digite o código</h1>
                <span>Enviamos um código para seu email: 
                <?php
                    // Continunando sessão que foi iniciada em "recuperar_senha_email.php"
                    session_start();
                    
                    // Exibindo email na tela
                    echo "<u>" . $_SESSION["txt_email"] . "</u>";
                ?>
                </span>
            </div>

            <!-- Formulário para digitar o código -->
            <form method="post" class="recuperar_senha_form">
                <!-- Label e input para o código -->
                <div class="header_input">
                    <img src="../img/recuperar_senha/icone_cpf.png" alt="icone de código" class="label_icon">
                    <label for="txt_codigo" class="input_label">Código</label>
                </div>
                <input type="text" name="txt_codigo_user" class="form_input" placeholder="Clique aqui para digitar">

                <!-- Botão de ação do formulário -->
                <div class="user_actions">
                    <button type="submit" class="btn_continuar" name="btn_enviar_codigo">Continuar</button>
                </div>

                <!-- lógica para fazer a verificação dos dois códigos -->
                <?php
                    $message = "";

                     if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['btn_enviar_codigo'])) {
                            // Extrai os dados enviados via POST
                            extract($_POST, EXTR_OVERWRITE);
                            
                            // Pegando o código que foi enviado no formulário e transformando em número
                            $codigo_input = (int) $_POST['txt_codigo_user']; 
                            
                            // Verifica se o código digitado é correto
                            if($codigo_input == $_SESSION["codigo"]) {
                                header("Location:./recuperar_senha_trocar.php");
                                exit();
                            } else {
                                $message = "Código incorreto";
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
