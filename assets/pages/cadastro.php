<?php
    session_start();

    // Importando e inicializando a classe com os metodos necessarios
    include_once '../php/especialidades.php';
    include_once '../php/sexo.php';
    include_once '../php/metodos_principais.php';
    include_once '../php/responsavel.php';
    include_once '../php/enviar_email_medico.php';
    $especialidades_instancia = new Especialidade();
    $sexo_instancia = new sexo();
    $metodos_principais = new metodos_principais();
    $responsavel = new responsavel();

    // Pegando as especialidades do banco de dados
    $result_espec = $especialidades_instancia->getAllEspecialidades();

    // Pegando os sexos do banco de dados
    $result_sexo = $sexo_instancia->getAllSexo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/cadastro/cadastro.css">
    <!--Logo na aba da google-->
    <link rel="icon" type="image/png" href="../img/geral/Logo.svg">
    <title>Cadastro</title>
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

            <!--Apenas uma div sem nada, para que os elementos centralizem melhor na tela-->
            <div></div>
        </div>

    <div class="container">
        <div class="card">
            <h1 id="titulo-cadastrar">Cadastrar-se</h1>
            <span id="subtitulo_cadastrar">O sorriso do seu filho começa aqui!</span>
 
             <form method="POST">
                <!-- código php-->
                <?php
                // Inicializa as variáveis
                $nome = $email = $cpf = $telefone = $nasc = $genero = $senha_confirmar1 = $senha_confirmar2 = '';
                $mensagem = '';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['btn_cadastro_enviar_desktop'])) {
                        // Armazena os valores em variáveis e mantém os dados no formulário
                        $nome = $_POST['input_cadastro_nome_desktop'];
                        $email = $_POST['input_cadastro_email_desktop'];
                        $cpf = $_POST['input_cadastro_cpf_desktop'];
                        $telefone = $_POST['input_cadastro_telefone_desktop'];
                        $nasc = $_POST['input_cadastro_data_nascimento_desktop'];
                        $senha_confirmar1 = $_POST['input_cadastro_senha_desktop'];
                        $senha_confirmar2 = $_POST['input_cadastro_confirmar_senha_desktop'];

                        // Atribuindo valor no sexo
                        $sexo = $_POST['select_cadastro_genero_desktop']; 
                        $sexo_instancia->setSexo($sexo);
                        $cod_sexo = $sexo_instancia->sexoToId();

                        // Verificando se as senhas são iguais
                        if ($senha_confirmar1 != $senha_confirmar2) {
                            $mensagem = 'As senhas são diferentes!';
                        } else {
                            // Verificando se esse Email já está cadastrado
                            $result = $metodos_principais->email_existe($email);
                            if ($result == true) {
                                $mensagem = 'Esse email já está cadastrado!';
                            } else {
                                $senha_hash = password_hash($senha_confirmar1, PASSWORD_DEFAULT);

                                // Passa as variáveis
                                $responsavel->setNome($nome);
                                $responsavel->setEmail($email);
                                $responsavel->setCpf($cpf);
                                $responsavel->setTelefone($telefone);
                                $responsavel->setNasc($nasc);
                                $responsavel->setGenero($cod_sexo);
                                $responsavel->setSenha($senha_hash);

                                $responsavel->salvar();

                                $id = $metodos_principais->selectId($result['tabela']);
                                $_SESSION['responsavel_id'] = $id;
                                setcookie("responsavel_id", $id, time() + (30 * 24 * 60 * 60),"/");
                                header("Location:./dashboard/dashboard.php"); // Altere para o caminho desejado
                                exit(); // Importante para parar a execução do script
                            }
                        }
                    }
                }
                ?>

                <!-- Primeira informação -->
                <div id="input-first-info">
                    <div class="header_input">
                        <img src="../img/cadastro/cadastro_nome_input_icon.png" alt="icone de personagem" class="label_icon">
                        <label for="input_cadastro_nome_desktop" class="input_label">Nome completo</label>
                    </div>
                    <input class="input_form_data" type="text" name="input_cadastro_nome_desktop" required placeholder="Nome" value="<?php echo htmlspecialchars($nome); ?>">

                    <div class="header_input">
                        <img src="../img/cadastro/icone_email.png" alt="icone de email" class="label_icon">
                        <label for="input_cadastro_email_desktop" class="input_label">Email</label>
                    </div>
                    <input class="input_form_data" type="email" name="input_cadastro_email_desktop" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">

                    <div class="header_input">
                        <img src="../img/cadastro/icone_cpf.png" alt="icone de cpf" class="label_icon">
                        <label for="input_cadastro_cpf_desktop" class="input_label">CPF</label>
                    </div>
                    <input class="input_form_data" type="number" name="input_cadastro_cpf_desktop" placeholder="CPF" value="<?php echo htmlspecialchars($cpf); ?>"> 
                </div>

                <!-- Segunda informação -->
                <div id="input-second-info">
                    <div class="header_input">
                        <img src="../img/cadastro/icone_telefone.png" alt="icone de telefone" class="label_icon">
                        <label for="input_cadastro_telefone_desktop" class="input_label">Telefone</label>
                    </div>
                    <input class="input_form_data" type="tel" name="input_cadastro_telefone_desktop" placeholder="Telefone" value="<?php echo htmlspecialchars($telefone); ?>">
                    
                    <div class="header_input">
                        <img src="../img/cadastro/icone_niversario.png" alt="icone de bolo (Aniversário)" class="label_icon">
                        <label for="input_cadastro_data_nascimento_desktop" class="input_label">Data de nascimento</label>
                    </div>
                    <input class="input_form_data" type="date" name="input_cadastro_data_nascimento_desktop"  value="<?php echo htmlspecialchars($nasc); ?>">
                    
                    <div class="header_input">
                        <img src="../img/cadastro/icone_sexo.png" alt="icone de sexo" class="label_icon">
                        <label for="select_cadastro_genero_desktop" class="input_label">Sexo</label>
                    </div>
                    <select class="input_form_data" id="genero" name="select_cadastro_genero_desktop">
                        <?php
                            if(!empty($result_sexo)) {
                                foreach ($result_sexo as $sexo_item) {
                                    $selected = ($sexo_item['sexo'] == $sexo) ? 'selected' : '';
                                    echo "<option value='{$sexo_item['sexo']}' $selected>{$sexo_item['sexo']}</option>";
                                }   
                            }
                        ?> 
                    </select>
                </div>

                <!-- Terceira informação -->
                <div id="input-three-info">
                    <div class="header_input">
                        <img src="../img/cadastro/cadastro_senha_input_icon.png" alt="icone de cadeado" class="label_icon">
                        <label for="input_cadastro_senha_desktop" class="input_label">Senha</label>
                    </div>
                    <input class="input_form_data" type="password" name="input_cadastro_senha_desktop" placeholder="Senha">
                    
                    <div class="header_input">
                        <img src="../img/cadastro/cadastro_senha_input_icon.png" alt="icone de cadeado" class="label_icon">
                        <label for="input_cadastro_confirmar_senha_desktop" class="input_label">Confirmar senha</label>
                    </div>
                    <input class="input_form_data" type="password" name="input_cadastro_confirmar_senha_desktop" placeholder="Confirmar Senha">
                </div>
                
                <!--Ações do usuário-->
                <div class="div_btn_form_actions">
                    <button class="btn_form_actions" type="button" name="btn_cadastro_proximo_desktop" id="btn-form-next">Próximo</button>
                    <button class="btn_form_actions" type="submit" name="btn_cadastro_enviar_desktop" id="btn-form-send">Enviar</button>
                    <button class="btn_form_actions" type="button" name="btn_cadastro_voltar_desktop" id="btn-form-back">Voltar</button>
                </div>

                 <!-- Mensagem de retorno -->
                 <?php if (!empty($mensagem)) { ?>
                    <script>alert('<?php echo htmlspecialchars($mensagem); ?>');</script>
                <?php } ?>
            </form>
        </div>
     </div>
<script src="../js/cadastro.js"></script>
</body>
</html>