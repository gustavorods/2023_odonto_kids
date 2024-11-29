<?php
    // Dados para conexão com o banco de dados
    $host = "localhost";
    $user = "root"; 
    $password = ""; 
    $database = "odontokids"; 

    // Criando a conexão
    $conn = new mysqli($host, $user, $password, $database);

    // Verificando se houve erros na conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $dependente->setIdResponsavel($responsavel_id);
    $dependentes = $dependente->listarDependentes();
?>
<div class="cards">
    <?php if (empty($dependentes)): ?>
        <div class="aviso">
            Você ainda não possui nenhum dependente cadastrado
        </div>
    <?php else: ?>
        <!-- Se houver dependentes, cria os cards -->
        <?php foreach ($dependentes as $dep): ?>
            <?php
                // Consulta a foto no banco usando o ID do dependente
                $foto = '/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png'; // URL padrão
                $id_dependente = $dep['id'];

                $stmt = $conn->prepare("SELECT foto FROM dependentes WHERE id = ?");
                $stmt->bind_param("i", $id_dependente);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    // Verifica se a foto não está vazia e converte para Base64
                    if (!empty($row['foto'])) {
                        $foto = 'data:image/jpeg;base64,' . base64_encode($row['foto']);
                    }
                }

                $stmt->close();
            ?>
            <div class="card" onclick="window.location.href = '../escolha_tratamento/escolha_tratamento.php?id_paciente=<?= $dep['id'] ?>'">
                <img src="<?= $foto ?>" alt="Foto de <?= $dep['nome'] ?>">
                <p class="nome"><span>Nome:</span> <?= $dep['nome'] ?></p>
                <p class="idade"><span>Idade:</span> <?= $dep['idade'] ?></p>
                <p class="cpf"><span>CPF:</span> <?= mascaraCpf($dep['cpf']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
// Função para mascarar o CPF, deixando os primeiros 3 e os dois últimos dígitos com asteriscos
function mascaraCpf($cpf) {
    return preg_replace('/(\d{3})\d{3}(\d{3})(\d{2})/', '***.$2.$3-**', $cpf);
}
?>
