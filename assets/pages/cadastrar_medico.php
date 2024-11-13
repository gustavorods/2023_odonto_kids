<?php
    session_start();

    // Importando e inicializando a classe com os metodos necessarios
    include_once '../php/especialidades.php';
    include_once '../php/sexo.php';
    include_once '../php/metodos_principais.php';
    include_once '../php/medico.php';
    include_once '../php/enviar_email_medico.php';
    $especialidades_instancia = new Especialidade();
    $sexo_instancia = new sexo();
    $metodos_principais = new metodos_principais();
    $medico = new Medico();

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
    <link rel="stylesheet" href="../css/cadastro/cadastro_medico.css">
    <link rel="stylesheet" href="../css/cadastro/cadastro_medico_responsivade.css">
    <!--Logo na aba da google-->
    <link rel="icon" type="image/png" href="../img/geral/Logo.svg">
    <title>Cadastrar médico</title>
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <div id="div-logo">
                <h1>Odonto kids</h1>
                <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>
        </div>
    </nav>

    <!--Cadastro Card-->
    <div class="container">
        <div class="card">
             <h1>Cadastro de médico</h1>
 
             <!-- Formulário de cadastro -->
             <form method="post" class="cadastro_form">
                <!--Lógica de cadastro php-->
                <?php
                    $nome = $email = $cpf = $telefone = $nasc = $CRM = $sexo = $especialidade = '';
                    $mensagem = '';
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                        if (isset($_POST['btn_cadastrar_medico'])) {
                            // Armazena os valores em variáveis e mantém os dados no formulário
                            $nome = $_POST['txt_nome'];
                            $email = $_POST['txt_email'];
                            $cpf = $_POST['txt_cpf'];
                            $telefone = $_POST['txt_telefone'];
                            $nasc = $_POST['txt_data_nascimento'];
                            $CRM = $_POST['txt_crm'];

                            // Criando a senha e seu hash
                            $senha= gerarSenhaAleatoria();
                            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                            
                            // Atribuindo valor no sexo
                            $sexo = $_POST['txt_sexo']; 
                            $sexo_instancia->setSexo($sexo);
                            $cod_sexo = $sexo_instancia->sexoToId(); // Vai ser essa variavel que vou usar no INSERT do medico
                            if($cod_sexo == null) {
                                // espaço pra log
                            } 
                            else {
                                // Atribuindo valor na especialidade
                                $especialidade = $_POST['txt_especialidade']; 
                                $cod_especialidade = $especialidades_instancia->getIdByFuncao($especialidade); // Vai ser essa variavel que vou usar no INSERT do medico
                                if($cod_especialidade == null) {
                                    // espaço pra log
                                } 
                                else {
                                    // Verificando se esse Email já está cadastrado
                                    $result = $metodos_principais->email_existe($email);
                                    if ($result == true) {
                                        $mensagem = 'Esse email já está cadastrado!';
                                    } else {    
                                        // Passa as variáveis
                                        $medico->setNome($nome);
                                        $medico->setEmail($email);
                                        $medico->setCpf($cpf);
                                        $medico->setTelefone($telefone);
                                        $medico->setNasc($nasc);
                                        $medico->setId_sexo($cod_sexo);
                                        $medico->setSenha($senha_hash);
                                        $medico->setCrm($CRM);
                                        $medico->setCodEspecialidade($cod_especialidade);
                                        $medico->setFoto(null);
        
                                        $medico->salvar();; // Log
                                        
                                        // Enviar email para o medico com seu acesso
                                        enviar_email_suporte($nome, $email, $senha);

                                        // Redirecionar 
                                        header("Location:cadastrar_medico_sucesso.html"); 
                                        exit(); 
                                    }
                                }
                            }     
                        }            
                    }

                    function gerarSenhaAleatoria() {
                        $senha = '';
                        for ($i = 0; $i < 8; $i++) {
                            $senha .= rand(0, 9); // Adiciona um número aleatório de 0 a 9
                        }
                        return $senha;
                    }
                ?>

                <div class="div_form_input">
                    <!-- Nome completo -->
                    <div class="header_input">
                        <img src="../img/cadastro/cadastro_nome_input_icon.png" alt="icone de user" class="label_icon">
                        <label for="txt_nome" class="input_label">Nome completo</label>
                    </div>
                    <input type="text" name="txt_nome" id="txt_nome" class="form_input" placeholder="Clique aqui para digitar" required value="<?php echo htmlspecialchars($nome); ?>">

                    <!-- Email -->
                    <div class="header_input">
                        <img src="../img/cadastro/icone_email.png" alt="icone de email" class="label_icon">
                        <label for="txt_email" class="input_label">Email</label>
                    </div>
                    <input type="email" name="txt_email" id="txt_email" class="form_input" placeholder="Digite seu email" required value="<?php echo htmlspecialchars($email); ?>">

                    <!-- CPF -->
                    <div class="header_input">
                        <img src="../img/cadastro/icone_cpf.png" alt="icone de CPF" class="label_icon">
                        <label for="txt_cpf" class="input_label">CPF</label>
                    </div>
                    <input type="text" name="txt_cpf" id="txt_cpf" class="form_input" placeholder="Digite seu CPF" required title="O CPF deve conter exatamente 11 dígitos numéricos." value="<?php echo htmlspecialchars($cpf); ?>">  

                    <!-- Telefone -->
                    <div class="header_input">
                        <img src="../img/cadastro/icone_telefone.png" alt="icone de telefone" class="label_icon">
                        <label for="txt_telefone" class="input_label">Telefone</label>
                    </div>
                    <input type="tel" name="txt_telefone" id="txt_telefone" class="form_input" placeholder="Digite seu telefone" required title="O telefone deve conter entre 10 e 11 dígitos numéricos." value="<?php echo htmlspecialchars($telefone); ?>">
                </div>

                <div class="div_form_input">
                    <!-- Data de nascimento -->
                    <div class="header_input">
                        <img src="../img/cadastro/icone_niversario.png" alt="icone de data de nascimento" class="label_icon">
                        <label for="txt_data_nascimento" class="input_label">Data de nascimento</label>
                    </div>
                    <input type="date" name="txt_data_nascimento" id="txt_data_nascimento" class="form_input" required value="<?php echo htmlspecialchars($nasc); ?>">

                    <!-- Sexo -->
                    <div class="header_input">
                        <img src="../img/cadastro/icone_sexo.png " alt="icone de sexo" class="label_icon">
                        <label for="txt_sexo" class="input_label">Sexo</label>
                    </div>
                    <select name="txt_sexo" id="txt_sexo" class="form_input" required>
                        <?php
                        if(!empty($result_sexo)) {
                            foreach ($result_sexo as $sexo_item) {
                                $selected = ($sexo_item['sexo'] == $sexo) ? 'selected' : '';
                                echo "<option value='{$sexo_item['sexo']}' $selected>{$sexo_item['sexo']}</option>";
                            }   
                        }
                        ?> 
                    </select>


                    <!-- CRM -->
                    <div class="header_input">
                        <img src="../img/cadastro/crm_icon.png" alt="icone de CRM" class="label_icon">
                        <label for="txt_crm" class="input_label">CRM</label>
                    </div>
                    <input type="text" name="txt_crm" id="txt_crm" class="form_input" placeholder="Digite seu CRM" required title="O CRM deve conter exatamente 10 dígitos numéricos."  value="<?php echo htmlspecialchars($CRM); ?>">

                    <!-- Especialidade -->
                    <div class="header_input">
                        <img src="../img/cadastro/especialidade_icon.png" alt="icone de especialidade" class="label_icon">
                        <label for="txt_especialidade" class="input_label">Especialidade</label>
                    </div>
                    <select name="txt_especialidade" id="txt_especialidade" class="form_input" required>
                        <?php
                        if(!empty($result_espec)) {
                            foreach ($result_espec as $especialidade_item) {
                                $selected = ($especialidade_item['funcao'] == $especialidade) ? 'selected' : '';
                                echo "<option value='{$especialidade_item['funcao']}' $selected>{$especialidade_item['funcao']}</option>";
                            }   
                        }
                        ?>   
                    </select>
                </div>

                <!--Ações do usuario-->
                <div class="user_actions">
                    <button type="submit" name="btn_cadastrar_medico" class="btn_cadastrar">Cadastrar</button>
                </div>

                <!-- Mensagem de retorno -->
                <?php if (!empty($mensagem)) { ?>
                    <script>alert('<?php echo htmlspecialchars($mensagem); ?>');</script>
                <?php } ?>
            </form>
        </div>
     </div>

     <script src="../js/cadastro_medico.js"></script>
</body>
</html>
