<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/recuperar_senha/recuperar_senha_trocar.css">
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
        <h1>Digite sua nova senha</h1>
        <span>Um novo começo...</span>

        <!-- Formulário para trocaar senha -->
        <form method="post" class="nova_senha_form">
            <div class="header_input">
                <img src="../img/recuperar_senha/recuperar_senha_senha_input_icon.png" alt="icone de cadeado" class="label_icon">
                <label for="txt_nova_senha" class="input_label">Nova senha</label>
            </div>
            <input type="text" name="txt_nova_senha" class="form_input" required placeholder="Clique aqui para digitar" >

            <div class="header_input">
                <img src="../img/recuperar_senha/recuperar_senha_senha_input_icon.png" alt="icone de cadeado" class="label_icon">
                <label for="txt_nova_senha_confirmar" class="input_label">Confirmar nova senha</label>
            </div>
            <input type="text" name="txt_nova_senha_confirmar" class="form_input" required placeholder="Clique aqui para digitar" >

            <!-- Botões e ações do usuário -->
            <div class="user_actions">
                <button type="submit" class="btn_continuar" name="btn_definir_nova_senha">Continuar</button>
            </div>

            <?php
                $message = "";

                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['btn_definir_nova_senha'])) {
                        // Extraindo todos os elementos do método POST
                        extract($_POST, EXTR_OVERWRITE);

                        // Continuando sessão que iniciada em "recuperar_senha_email.php"
                        session_start();

                        // Importação de métodos 
                        include_once '../php/metodos_principais.php';
                        include_once '../php/responsavel.php';
                        include_once '../php/medico.php';
                        
                        //Instanciando os métodos  
                        $medico = new Medico();
                        $responsavel = new responsavel();
                        $metodos_principais = new metodos_principais();
                        
                        if($txt_nova_senha == $txt_nova_senha_confirmar) {
                            // Verificando qual tabela o email que o usuario usou pertence
                            $informacao_usuario = $metodos_principais->verificar_email_tabela_e_id($_SESSION["txt_email"]);

                            if($informacao_usuario['tabela'] == "responsavel") {
                                // Definindo os dados do responsavel
                                $responsavel->setId($informacao_usuario['id']);
                                $responsavel->setSenha($txt_nova_senha);

                                // Executando a função para alterar
                                $responsavel->alterar_senha();

                                //Exibindo mensagem de sucesso
                                $message = "Sua senha foi alterada";
                                echo "<center> <p style='color:green'>" . $message . "</p> </center>";
                            } 
                            else if($informacao_usuario['tabela'] == "medico") {
                                // Definindo os dados do responsavel
                                $medico->setId($informacao_usuario['id']);
                                $medico->setSenha($txt_nova_senha);

                                // Executando a função para alterar
                                $medico->alterar_senha();

                                //Exibindo mensagem de sucesso
                                $message = "Sua senha foi alterada";
                                echo "<center> <p style='color:green'>" . $message . "</p> </center>";
                            } 
                            else {
                                /* Esse else provavelmente nunca será acionado, pois ele só executa se a 
                                verificação do e-mail retornar false, o que significa que o e-mail não existe. 
                                No entanto, isso é improvável, já que, para o usuário ter chegado até essa página, 
                                o e-mail já foi validado na página recuperar_senha_email.php. Apesar disso, mantive 
                                esse else para facilitar a identificação de possíveis bugs durante a construção dessa página.  */
                                
                                $message = "Erro ao verificar Email.";
                                ?>
                                <br>
                                <?php 
                                echo "<center> <p style='color:red'>" . $message . "</p> </center>";
                            } 
                        } 
                        else {
                            $message = "Os campos possuem senhas diferentes.";
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