<link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard_medico/card-historico-consultas/card-historico-consultas.css">

<?php
    $historicoConsultasOrganizadas = $listar_consulta->listar_historico_consultas();

    // Iterar sobre as consultas e gerar os cartões diretamente no PHP
    foreach ($historicoConsultasOrganizadas as $consulta) {
        // Definindo variáveis
        $dia = $consulta['dia'];
        $mes = $consulta['mes'];
        $horario = $consulta['horario'];
        $status = $consulta['status'];
        $tratamento = $consulta['tratamento'];
        $dependente = $consulta['dependente'];
        $sexo = $consulta['sexo'];
        $id = $consulta['id'];
        $id_dependente = $consulta['id_dependente'];
        $dependente_foto = $consulta['foto'];

        // Mensagem de aviso para consultas canceladas ou ausentes
        $avisoMessage = "";
        $classCard = "card-historico";
        $classLine = "line";

        // Adiciona classe de gênero e status (Cancelada ou Ausente)
        if ($status == "Realizada") {
            if ($sexo == "Masculino") {
                $classCard .= " boy";
                $classLine .= " boy";
            } else {
                $classCard .= " girl";
                $classLine .= " girl";
            }
        } else {
            $classCard .= " cancelada-ausente";
            if ($status === "Cancelada") {
                $avisoMessage = "";
            } else {
                $avisoMessage = "Paciente não compareceu à consulta";
            }
        }

        // Verifica se o campo 'foto' não está vazio ou nulo
        if (!empty($dependente_foto)) {
            // Verifica o tipo da imagem
            $image_info = getimagesizefromstring($dependente_foto);
            $image_type = $image_info['mime']; // O tipo MIME (exemplo: image/jpeg, image/png, etc.)
            
            // Converte o BLOB para base64
            $foto_base64 = base64_encode($dependente_foto);
        } else {
            // Caso não tenha imagem
        }        

        // Gerar o HTML do card diretamente
?>
<div class="<?php echo $classCard; ?>">
    <div class="<?php echo $classLine; ?>"></div>
    <div class="corpo-card-historico">
        <div class="data-status">
            <div class="data">
                <p><?php echo $dia . ' de ' . $mes . ' às ' . $horario; ?></p>
            </div>
            <div class="status">
                <?php echo $status; ?>
            </div>
        </div>

        <div class="tipo-consulta">
            <p><?php echo $tratamento; ?></p>
        </div>

        <div class="perfil-detalhes">
            <form id="form-detalhes-paciente" action="/2023_odonto_kids/assets/pages/dashboard_medico/views/detalhes_paciente.php" method="POST" style="display: none;">
                <input type="hidden" name="consulta_id" id="consulta_id_form" value="<?php echo $id; ?>">
            </form>

            <div class="left-container">
                <div class="perfil-imagem clicar-imagem" consulta_id="<?php echo $id_dependente; ?>">
                    <!-- Exibe a foto do paciente -->
                </div>
                <div class="nome-perfil clicar-nome" consulta_id="<?php echo $id_dependente; ?>">
                    <p><?php echo $dependente; ?></p>
                </div>
            </div>

            <div class="botao-detalhes">
                <h1 class="aviso"><?php echo $avisoMessage; ?></h1>
                <button class="detalhes-historico-consulta" data_id="<?php echo $id; ?>">Detalhes</button>
            </div>
        </div>
    </div>
</div>

<?php
    }
?>
