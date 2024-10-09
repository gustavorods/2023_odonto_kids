<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login/login.css">
    <link rel="stylesheet" href="../css/login/login-responsivo.css"> 
    <link rel="icon" type="image/png" href="./assets/img/geral/Logo.svg">
    <script src="https://kit.fontawesome.com/78372ad020.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
     <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a href="../../index.html">
                <img src="../img/login/bacl.svg" alt="Seta de voltar" class="backArrow">
            </a>
        </div>
    </nav>

    <!-- PC & mobile -->
    <div class="main-container">
        <!--Pc-->
        <div class="container" id="container">
            <!-- Criar Conta -->
            <div class="form-container sing-up">
            <form method="POST">
                <?php
                // Inicializa as variáveis
                $nome = $email = $cpf = $telefone = $nasc = $genero = $senha_confirmar1 = $senha_confirmar2 = '';
                $mensagem = '';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['btn_cadastro_enviar_desktop'])) {
                        include_once '../php/responsavel.php';
                        include_once '../php/metodos_principais.php';
                        $responsavel = new responsavel();
                        $metodos_principais = new metodos_principais();

                        // Armazena os valores em variáveis e mantém os dados no formulário
                        $nome = $_POST['input_cadastro_nome_desktop'];
                        $email = $_POST['input_cadastro_email_desktop'];
                        $cpf = $_POST['input_cadastro_cpf_desktop'];
                        $telefone = $_POST['input_cadastro_telefone_desktop'];
                        $nasc = $_POST['input_cadastro_data_nascimento_desktop'];
                        $genero = $_POST['select_cadastro_genero_desktop'];
                        $senha_confirmar1 = $_POST['input_cadastro_senha_desktop'];
                        $senha_confirmar2 = $_POST['input_cadastro_confirmar_senha_desktop'];

                        // Verificando se as senhas são iguais
                        if ($senha_confirmar1 != $senha_confirmar2) {
                            $mensagem = 'As senhas são diferentes!';
                        } else {
                            // Verificando se esse Email já está cadastrado
                            $result = $metodos_principais->email_existe($email);
                            if ($result == true) {
                                $mensagem = 'Esse email já está cadastrado!';
                            } else {
                                // Passa as variáveis
                                $responsavel->setNome($nome);
                                $responsavel->setEmail($email);
                                $responsavel->setCpf($cpf);
                                $responsavel->setTelefone($telefone);
                                $responsavel->setNasc($nasc);
                                $responsavel->setGenero($genero);
                                $responsavel->setSenha($senha_confirmar1);

                                $responsavel->salvar();
                                
                            }
                        }
                    }
                }
                ?>

                <h1 id="titulo-cadastrar">Cadastrar-se</h1>
                <span>Insira seus dados para continuar o cadastro</span>

                <!-- Primeira informação -->
                <div id="input-first-info">
                    <input type="text" name="input_cadastro_nome_desktop" required placeholder="Nome" value="<?php echo htmlspecialchars($nome); ?>">
                    <input type="email" name="input_cadastro_email_desktop" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                    <input type="number" name="input_cadastro_cpf_desktop" placeholder="CPF" value="<?php echo htmlspecialchars($cpf); ?>">
                </div>

                <!-- Segunda informação -->
                <div id="input-second-info">
                    <input type="tel" name="input_cadastro_telefone_desktop" placeholder="Telefone" value="<?php echo htmlspecialchars($telefone); ?>">
                    <input type="date" name="input_cadastro_data_nascimento_desktop" value="<?php echo htmlspecialchars($nasc); ?>">
                    <select id="genero" name="select_cadastro_genero_desktop">
                        <option disabled selected>Selecione seu gênero</option>
                        <option value="masculino" <?php if ($genero == "masculino") echo 'selected'; ?>>Masculino</option>
                        <option value="feminino" <?php if ($genero == "feminino") echo 'selected'; ?>>Feminino</option>
                        <option value="nao-binario" <?php if ($genero == "nao-binario") echo 'selected'; ?>>Não binário</option>
                        <option value="outro" <?php if ($genero == "outro") echo 'selected'; ?>>Outro</option>
                    </select>
                </div>

                <!-- Terceira informação -->
                <div id="input-three-info">
                    <input type="password" name="input_cadastro_senha_desktop" placeholder="Senha">
                    <input type="password" name="input_cadastro_confirmar_senha_desktop" placeholder="Confirmar Senha">
                </div>

                <div class="btn-form-back-next">
                    <button type="button" name="btn_cadastro_voltar_desktop" id="btn-form-back">Voltar</button>
                    <button type="button" name="btn_cadastro_proximo_desktop" id="btn-form-next">Próximo</button>
                    <button type="submit" name="btn_cadastro_enviar_desktop" id="btn-form-send">Enviar</button>
                </div>
                
                <!-- Mensagem de retorno -->
                <?php if (!empty($mensagem)): ?>
                    <script>alert("<?php echo $mensagem; ?>");</script>
                <?php endif; ?>
            </form>
            </div>

            <!-- Logar na Conta -->
            <div class="form-container sing-in">
                <form method="POST">
                    <h1>Entrar</h1>
                    <div class="social-icons">
                        <a href="#" class="icon">
                            <i class="fa-brands fa-google-plus-g"></i>
                        </a>
                        <a href="#" class="icon">
                            <i class="fa-brands fa-apple"></i>
                        </a>
                    </div>
                    <span>Ou use seu email e senha para Entrar</span>
                    <input type="email" placeholder="Email"name="input_login_email_desktop">
                    <input type="password" placeholder="Senha" name="input_login_senha_desktop">
                    <a href="#">Esqueceu sua senha?</a>
                    <button type="submit" name="btn_login_desktop">Entrar</button>
                    <!-- PHP script -->
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_POST['btn_login_desktop'])) {
                                include_once '../php/metodos_principais.php';
                                $metodos_principais = new metodos_principais();
                        
                                // Armazena os valores em variáveis
                                $email = $_POST['input_login_email_desktop'];
                                $senha = $_POST['input_login_senha_desktop'];
                        
                                // Passa as variáveis
                                $metodos_principais->set_email_user($email);
                                $metodos_principais->set_senha_user($senha);
                                $metodos_principais->set_email_medico($email);
                                $metodos_principais->set_senha_medico($senha);
                                
                                $result = $metodos_principais->login();
                        
                                if ($result == "responsavel") {
                                    // Código pra ir pra dashboard do responsável
                                } 
                                else if($result == "medico") {
                                    // Código pra ir pra dashboard do médico
                                }
                                else {
                                    echo "<p style='color:red'>Email ou Senha inválidos</p>";
                                    echo $result;
                                }
                            }
                        }
                    ?>
                </form>
            </div>

            <div class="toggle-container">
                <div class="toggle">
                    <div class="toggle-panel toggle-left">
                        <h1>Bem vindo de volta!</h1>
                        <p>Entre usando seus dados pessoais para usar tudo do site</p>
                        <button class="hidden" id="login">Entrar</button>
                    </div>
                    <div class="toggle-panel toggle-right">
                        <h1>Olá! Novo aqui?</h1>
                        <p>Faça o cadastro usando seus dados pessoais para usar tudo do site</p>
                        <button class="hidden" id="register">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--mobile-->
        <div class="flip-container">
            <div class="card">
                <div class="front">
                    <div class="mobile-form-container">
                        <form method="POST">
                            <h1>Entrar</h1>
                            <div class="social-icons">
                                <a href="#" class="icon">
                                    <i class="fa-brands fa-google-plus-g"></i>
                                </a>
                                <a href="#" class="icon">
                                    <i class="fa-brands fa-apple"></i>
                                </a>
                            </div>
                            <span>Ou use seu email e senha para Entrar</span>
                            <input type="email" placeholder="Email" name="input_login_email_mobile">
                            <input type="password" placeholder="Senha" name="input_login_senha_mobile">
                            <a href="#">Esqueceu sua senha?</a>
                            <button name="btn_login_mobile" type="submit">Entrar</button>
                            <button type="button" class="mobile-btn-NoAccount">Sem conta ainda?</button>

                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    if (isset($_POST['btn_login_mobile'])) {
                                        include_once '../php/metodos_principais.php';
                                        $metodos_principais = new metodos_principais();
                                
                                        // Armazena os valores em variáveis
                                        $email = $_POST['input_login_email_mobile'];
                                        $senha = $_POST['input_login_senha_mobile'];
                                
                                        // Passa as variáveis
                                        $metodos_principais->set_email_user($email);
                                        $metodos_principais->set_senha_user($senha);
                                        $metodos_principais->set_email_medico($email);
                                        $metodos_principais->set_senha_medico($senha);
                                        
                                        $result = $metodos_principais->login();
                                
                                        if ($result == "responsavel") {
                                            // Código pra ir pra dashboard do responsável
                                        } 
                                        else if($result == "medico") {
                                            // Código pra ir pra dashboard do médico
                                        }
                                        else {
                                            echo "<p style='color:red'>Email ou Senha inválidos</p>";
                                        }
                                    }
                                }
                            ?>
                        </form>
                    </div>
                </div>
                <div class="back">
                    <div class="mobile-form-container">
                        <form method="POST">
                            <!--lógica de login-->
                            <?php
                            // Inicializa as variáveis
                            $nome = $email = $cpf = $telefone = $nasc = $genero = $senha_confirmar1 = $senha_confirmar2 = '';
                            $mensagem = '';

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST['btn_cadastro_enviar_mobile'])) {
                                    include_once '../php/responsavel.php';
                                    include_once '../php/metodos_principais.php';
                                    $responsavel = new responsavel();
                                    $metodos_principais = new metodos_principais();

                                    // Armazena os valores em variáveis e mantém os dados no formulário
                                    $nome = $_POST['input_cadastro_nome_mobile'];
                                    $email = $_POST['input_cadastro_email_mobile'];
                                    $cpf = $_POST['input_cadastro_cpf_mobile'];
                                    $telefone = $_POST['input_cadastro_telefone_mobile'];
                                    $nasc = $_POST['input_cadastro_data_nascimento_mobile'];
                                    $genero = $_POST['select_cadastro_genero_mobile'];
                                    $senha_confirmar1 = $_POST['input_cadastro_senha_mobile'];
                                    $senha_confirmar2 = $_POST['input_cadastro_confirmar_senha_mobile'];

                                    // Verificando se as senhas são iguais
                                    if ($senha_confirmar1 != $senha_confirmar2) {
                                        $mensagem = 'As senhas são diferentes!';
                                    } else {
                                        // Verificando se esse Email já está cadastrado
                                        $result = $metodos_principais->email_existe($email);
                                        if ($result == true) {
                                            $mensagem = 'Esse email já está cadastrado!';
                                        } else {
                                            // Passa as variáveis
                                            $responsavel->setNome($nome);
                                            $responsavel->setEmail($email);
                                            $responsavel->setCpf($cpf);
                                            $responsavel->setTelefone($telefone);
                                            $responsavel->setNasc($nasc);
                                            $responsavel->setGenero($genero);
                                            $responsavel->setSenha($senha_confirmar1);

                                            $responsavel->salvar();
                                            
                                        }
                                    }
                                }
                            }
                            ?> 

                            <h1 class="mobile-form-titulo">Cadastrar-se</h1>
                            <span>Insira seus dados para continuar o cadastro</span>
                            <!-- Primeiras informações -->
                            <div class="mobile-input-first-info">
                                <input type="text" name="input_cadastro_nome_mobile" placeholder="Nome completo" value="<?php echo htmlspecialchars($nome); ?>">
                                <input type="number" name="input_cadastro_cpf_mobile" placeholder="CPF"  value="<?php echo htmlspecialchars($cpf); ?>">
                                <input type="email" name="input_cadastro_email_mobile" placeholder="Email"  value="<?php echo htmlspecialchars($email); ?>">
                            </div>

                            <!-- Segundas informações -->
                            <div class="mobile-input-second-info">
                                <input type="tel" name="input_cadastro_telefone_mobile" placeholder="Telefone" value="<?php echo htmlspecialchars($telefone); ?>">
                                <input type="date" name="input_cadastro_data_nascimento_mobile"  value="<?php echo htmlspecialchars($nasc); ?>">
                                <select name="select_cadastro_genero_mobile">
                                    <option disabled selected>Selecione seu gênero</option>
                                    <option value="masculino" <?php if ($genero == "masculino") echo 'selected'; ?>>Masculino</option>
                                    <option value="feminino" <?php if ($genero == "feminino") echo 'selected'; ?>>Feminino</option>
                                    <option value="nao-binario" <?php if ($genero == "nao-binario") echo 'selected'; ?>>Não binário</option>
                                    <option value="outro" <?php if ($genero == "outro") echo 'selected'; ?>>Outro</option>
                                </select>
                            </div>

                            <!-- Terceiras informações --> 
                            <div class="mobile-input-third-info">
                                <input type="password" name="input_cadastro_senha_mobile" placeholder="Senha">
                                <input type="password" name="input_cadastro_confirmar_senha_mobile" placeholder="Confirmar Senha">
                            </div>

                            <!-- Botões -->
                            <button type="button" name="btn_cadastro_proximo_mobile" class="mobile-btn-form-next">Próximo</button>
                            <button type="submit" name="btn_cadastro_enviar_mobile" class="mobile-btn-form-send">Enviar</button>
                            <button type="button" name="btn_cadastro_ja_tem_conta_mobile" class="mobile-btn-form-BackToLogin">Já tem uma conta?</button>
                            <button type="button" name="btn_cadastro_voltar_mobile" class="mobile-btn-form-back">Voltar</button>

                             <!-- Mensagem de retorno -->
                            <?php if (!empty($mensagem)): ?>
                                <script>alert("<?php echo $mensagem; ?>");</script>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <script src="../js/login.js"></script>
    <script src="../js/mobile-login.js"></script>
</body>
</html>
