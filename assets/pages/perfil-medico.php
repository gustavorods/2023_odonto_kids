<?php
session_start();
require '../php/conectar.php';
require '../php/medico.php';


$user_id = $_SESSION['user_id'];
$medico = Medico::buscarPorId($user_id);

// Função para atualizar as informações do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['alterar'])) {
    $medico->setNome($_POST['nome']);
    $medico->setCpf($_POST['cpf']);
    $medico->setEmail($_POST['email']);
    $medico->setTelefone($_POST['telefone']);
    $medico->setNasc($_POST['nasc']);
    $medico->setGenero($_POST['genero']);
    $medico->setSenha($_POST['senha']); // Senha em texto claro
    $medico->setCrm($_POST['crm']);
    $medico->setCodEspecialidade($_POST['cod_especialidade']);
    $mensagem = $medico->alterar2();
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
    </style>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("inputEditSenha");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                event.target.textContent = "Ocultar";
            } else {
                passwordInput.type = "password";
                event.target.textContent = "Mostrar";
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
                <div class="card-header">Olá, <?php echo htmlspecialchars($medico->getNome()); ?></div>
                <div class="card-body text-center">
                    <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="Imagem de Perfil">
                    <div class="small font-italic text-muted mb-4"><?php echo htmlspecialchars($medico->getNome()); ?></div>
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
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getNome()); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">CPF:</label>
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getCpf()); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Email:</label>
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getEmail()); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Telefone:</label>
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getTelefone()); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Data de Nascimento:</label>
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getNasc()); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Gênero:</label>
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getGenero()); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">CRM:</label>
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getCrm()); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Código da Especialidade:</label>
                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($medico->getCodEspecialidade()); ?>" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar as informações -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Informações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <!-- Campos de edição das informações -->
                    <!-- Campos atualizados de acordo com os dados do objeto $medico -->
                    <div class="mb-3">
                        <label for="inputEditNome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="inputEditNome" name="nome" value="<?php echo htmlspecialchars($medico->getNome()); ?>">
                    </div>
                    <!-- Repetir os outros campos de edição como CPF, email, etc. -->
                    <button type="submit" name="alterar" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
