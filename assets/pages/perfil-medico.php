<?php
session_start();

// Importando e inicializando as classes necessárias
include_once '../php/metodos_principais.php';
include_once '../php/especialidades.php';
include_once '../php/sexo.php';
include_once '../php/medico.php';

// Inicializando as instâncias das classes
$metodos_principais = new metodos_principais();
$especialidades = new Especialidade();
$sexo = new sexo();
$medico = new Medico(); // Instanciando o objeto Medico para poder chamar seus métodos

// Pegando todos os dados do médico
$dados_user = $metodos_principais->obter_dados_do_user($_SESSION['user']['tabela'], $_SESSION['user']['id']);

// Pegando o nome da especialidade do médico
$dados_user_especialidades = $especialidades->getEspecialidadeById($dados_user['cod_especialidade']);

// Pegando o nome do sexo do médico
$dados_user_sexo = $sexo->getSexoById($dados_user['id_sexo']);

// Pegando todas as especialidades e todos os sexos
$all_sexo = $sexo->getAllSexo();
$all_especialidades = $especialidades->getAllEspecialidades();

$mensagem;
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    var_dump($_POST);
    if (isset($_POST['btn_salvar_alteracoes'])) {
        // Armazena os valores em variáveis e mantém os dados no formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $nasc = $_POST['nasc'];
        $CRM = $_POST['crm'];

        // Criando a senha e seu hash
        $senha_nova = $_POST['senha_nova'];
        $senha_atual = $_POST['senha_atual'];
        if (!password_verify($senha_atual, $dados_user['senha'])) {
            $mensagem = "Senha atual incorreta";
        } else {
            if($senha_nova == '') {
                $senha_hash = $dados_user['senha'];
            } {
                $senha_hash = password_hash($senha_nova, PASSWORD_DEFAULT);
            }
            
            // Atribuindo valor no sexo
            $sexo_value = $_POST['txt_sexo']; // Recebe o valor do sexo
            $sexo_instancia = new sexo(); // Instanciando o objeto para manipulação
            $sexo_instancia->setSexo($sexo_value);
            $_SESSION['log_medico'] = $cod_sexo = $sexo_instancia->sexoToId();

            if ($cod_sexo == null) {
                // Se o sexo não for encontrado, podemos adicionar um log ou mensagem de erro aqui
            } else {
                // Atribuindo valor na especialidade
                $especialidade_value = $_POST['txt_especialidade']; // Recebe a especialidade
                $especialidades_instancia = new Especialidade(); // Instanciando o objeto para manipulação
                $cod_especialidade = $especialidades_instancia->getIdByFuncao($especialidade_value);

                if ($cod_especialidade == null) {
                    // Se a especialidade não for encontrada, podemos adicionar um log ou mensagem de erro aqui
                    echo "Especialidade inválida!";
                } else {
                    if($email == $dados_user['email']) {
                        // Atribuindo os valores para o médico
                        $medico->setId($_SESSION['user']['id']);
                        $medico->setNome($nome);
                        $medico->setEmail($email);
                        $medico->setCpf($cpf);
                        $medico->setTelefone($telefone);
                        $medico->setNasc($nasc);
                        $medico->setId_sexo($cod_sexo);
                        $medico->setSenha($senha_hash);
                        $medico->setCrm($CRM);
                        $medico->setCodEspecialidade($cod_especialidade);

                        // Chamando o método para alterar os dados
                        $medico->alterar();
                        $mensagem = "Informações do médico atualizadas com sucesso!";
                        header("Location:perfil-medico.php"); 
                        exit();
                    } else {
                        // Verificando se esse Email já está cadastrado
                        $result = $metodos_principais->email_existe($email);
                        if ($result == true) {
                            $mensagem = 'Esse email já está cadastrado!';
                        } else {
                            // Atribuindo os valores para o médico
                            $medico->setId($_SESSION['user']['id']);
                            $medico->setNome($nome);
                            $medico->setEmail($email);
                            $medico->setCpf($cpf);
                            $medico->setTelefone($telefone);
                            $medico->setNasc($nasc);
                            $medico->setId_sexo($cod_sexo);
                            $medico->setSenha($senha_hash);
                            $medico->setCrm($CRM);
                            $medico->setCodEspecialidade($cod_especialidade);

                            // Chamando o método para alterar os dados
                            $medico->alterar();
                            $mensagem = "Informações do médico atualizadas com sucesso!";
                            header("Location:perfil-medico.php"); 
                            exit(); 
                        }
                    }
                }
            }     
        }
    }            
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Perfil</title>
    <style>
        /* Estilos para o layout da página */
        body {
            margin-top: 20px;
            background-color: #f8f8ff;
            color: #69707a;
        }
        .img-account-profile {
            height: 10rem;
        }
        .rounded-circle {
            border-radius: 50% !important;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 25%);
        }
        .card-header {
            font-weight: 700;
            background-color: #408CFC;
            color: white;
        }
        .btn-primary {
            background-color: #408CFC;
            border-color: #408CFC;
        }
        .btn-primary:hover {
            background-color: #3078d4;
            border-color: #3078d4;
        }
        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }
        .float-end {
            float: right;
        }

        /* Estilos para a div que envolve o botão */
.logout-container {
    text-align: center;
    margin-top: 20px;
}

/* Estilos para o botão de logout */
.logout-btn {
    padding: 10px 20px;
    background-color: red;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Efeito de hover para o botão */
.logout-btn:hover {
    background-color: darkred;
    transform: scale(1.05);
}

    </style>
    <script>
      function toggleSenha() {
    const senhaInput = document.getElementById("senha");
    const senhaIcone = document.getElementById("senhaIcone");

    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        senhaIcone.classList.remove("bi-eye");
        senhaIcone.classList.add("bi-eye-slash");
    } else {
        senhaInput.type = "password";
        senhaIcone.classList.remove("bi-eye-slash");
        senhaIcone.classList.add("bi-eye");
    }
}

    </script>
</head>
<body>
<div class="container-xl px-4 mt-4">
    <!-- Navegação -->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="#">Perfil</a>
    </nav>
    <hr class="mt-0 mb-4">
    
    <!-- Mensagem de sucesso -->
    <?php if (isset($mensagem)) echo "<div class='alert alert-success'>$mensagem</div>"; ?>
    
    <div class="row">
        <div class="col-xl-4">
            <!-- Card de perfil -->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Olá, <?php echo $dados_user['nome'];?></div>
                <div class="card-body text-center">
                    <?php
                        if($dados_user['foto'] == null) {
                            ?>
                            <img class="img-account-profile rounded-circle mb-2" src="../img/perfil_medico/perfil_anonimo_icon.png" alt="Imagem de Perfil">
                            <?php
                        } else {
                            // Lógica pra puxar a imagem real do user
                        }
                    ?>
                    <div class="small font-italic text-muted mb-4"><?php?></div>
                    <button class="btn btn-primary" type="button">Upload nova imagem</button>
                </div>
            </div>
            
        </div>
        
        
        <div class="col-xl-8">
            <!-- Card de informações do médico -->
            <div class="card mb-4">
                <div class="card-header">Perfil do Profissional
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#editModal">Alterar Informações</button>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="small mb-1">Nome Completo:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user['nome'];?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">CPF:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user['cpf'];?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Email:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user['email'];?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Telefone:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user['telefone'];?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Data de Nascimento:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user['nasc'];?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">sexo:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user_sexo;?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">CRM:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user['CRM'];?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Especialidade:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user_especialidades['funcao'];?>" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para alterar informações -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Alterar Informações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="cadastro_form">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $dados_user['Id']; ?>">
                    <div class="mb-3">
                        <label class="small mb-1">Nome Completo:</label>
                        <input class="form-control" type="text" name="nome" value="<?php echo $dados_user['nome']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Email:</label>
                        <input class="form-control" id="txt_email" type="email" name="email" value="<?php echo $dados_user['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Telefone:</label>
                        <input class="form-control" id="txt_telefone" type="text" name="telefone" value="<?php echo $dados_user['telefone']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Data de Nascimento:</label>
                        <input class="form-control" id="txt_data_nascimento" type="date" name="nasc" value="<?php echo $dados_user['nasc']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Sexo:</label>
                        <select name="txt_sexo" id="txt_sexo" class="form-control">
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
                    <div class="mb-3">
                        <label class="small mb-1">CPF:</label>
                        <input class="form-control" id="txt_cpf" type="text" name="cpf" value="<?php echo $dados_user['cpf']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Senha nova:</label>
                        <div class="input-group">
                            <input class="form-control" type="password" id="senha" name="senha_nova">
                            <button type="button" class="btn btn-outline-secondary" onclick="toggleSenha()">
                                Mostrar/Ocultar
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">CRM:</label>
                        <input class="form-control" id="txt_crm" type="text" name="crm" value="<?php echo $dados_user['CRM']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Especialidade:</label>
                        <select name="txt_especialidade" id="txt_especialidade" class="form-control" required>
                            <?php
                            if(!empty($all_especialidades)) {
                                foreach ($all_especialidades as $especialidade_item) {
                                    $selected = ($especialidade_item['funcao'] == $especialidade) ? 'selected' : '';
                                    echo "<option value='{$especialidade_item['funcao']}' $selected>{$especialidade_item['funcao']}</option>";
                                }   
                            }
                            ?>   
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Senha:</label>
                        <div class="input-group">
                            <input class="form-control" type="password" id="senha" name="senha_atual">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name="btn_salvar_alteracoes">Salvar Alterações</button>
                </div>

                <!-- Mensagem de retorno -->
                <?php if (!empty($mensagem)) { ?>
                    <script>alert('<?php echo htmlspecialchars($mensagem); ?>');</script>
                <?php } ?>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../js/config_perfil_medico.js"></script>
</body>
</html>
