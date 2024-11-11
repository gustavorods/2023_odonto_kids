<?php
session_start();

// Importando e inicializando a classe com os metodos necessarios
include_once '../php/metodos_principais.php';
include_once '../php/especialidades.php';
include_once '../php/medico.php';
$metodos_principais = new metodos_principais();
$especialidades = new Especialidade();
$usuario = new Medico();
// Pegando todos os dados do medico 
$dados_user = $metodos_principais->obter_dados_do_user($_SESSION['user']['tabela'], $_SESSION['user']['id']);


/*
Exemplo de como puxar os dados:
    $dados_user['NOME_DO_CAMPO']
*/


// pegando o nome da especialidade do médico 
$dados_user_especialidades = $especialidades->getEspecialidadeById($dados_user['cod_especialidade']); 
/*
Exemplo de como puxar os dados:
puxando a função:
    $dados_user_especialidades['funcao'];

puxando a descricao:
    $dados_user_especialidades['descricao'];
*/

// Função para atualizar as informações do médico

if (isset($_SESSION['mensagem'])) {
    echo "<p>{$_SESSION['mensagem']}</p>";
    unset($_SESSION['mensagem']);
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
                            <label class="small mb-1">Gênero:</label>
                            <input class="form-control" type="text" value="<?php echo $dados_user['genero'];?>" readonly>
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
            <form action="atualizar_perfil.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $dados_user['Id']; ?>">
                    <div class="mb-3">
                        <label class="small mb-1">Nome Completo:</label>
                        <input class="form-control" type="text" name="nome" value="<?php echo $dados_user['nome']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Email:</label>
                        <input class="form-control" type="email" name="email" value="<?php echo $dados_user['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Telefone:</label>
                        <input class="form-control" type="text" name="telefone" value="<?php echo $dados_user['telefone']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Data de Nascimento:</label>
                        <input class="form-control" type="date" name="nasc" value="<?php echo $dados_user['nasc']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Gênero:</label>
                        <input class="form-control" type="text" name="genero" value="<?php echo $dados_user['genero']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">CPF:</label>
                        <input class="form-control" type="text" name="cpf" value="<?php echo $dados_user['cpf']; ?>">
                    </div>
                    <div class="mb-3">
    <label class="small mb-1">Senha:</label>
    <div class="input-group">
        <input class="form-control" type="password" id="senha" name="senha" value="<?php echo $dados_user['senha']; ?>">
        <button type="button" class="btn btn-outline-secondary" onclick="toggleSenha()">
            Mostrar/Ocultar
        </button>
    </div>
</div>
                    <div class="mb-3">
                        <label class="small mb-1">CRM:</label>
                        <input class="form-control" type="text" name="crm" value="<?php echo $dados_user['CRM']; ?>">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Intercepta o envio do formulário
        $('form').submit(function(event) {
            event.preventDefault(); // Impede o envio normal do formulário

            // Envia o formulário via Ajax
            $.ajax({
                url: 'atualizar_perfil.php', // Arquivo de processamento
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Atualiza a mensagem de sucesso e fecha o modal
                    alert("Informações atualizadas com sucesso!");
                    location.reload(); // Recarrega a página para exibir os dados atualizados
                },
                error: function() {
                    alert("Erro ao atualizar informações. Tente novamente.");
                }
            });
        });
    });
</script>

</body>
</html>
