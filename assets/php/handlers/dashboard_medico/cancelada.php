<?php
    include '../..//conectar.php';

    class realizada{
        private $conn;

        function consultaCancelada(){
            // Receber dados da requisição
            $input = json_decode(file_get_contents('php://input'), true);
            $consultaId = isset($input['consulta_id']) ? intval($input['consulta_id']) : 0;
            
            // Verificar se o consulta_id é válido
            if ($consultaId <= 0) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'ID da consulta inválido'
                ]);
                exit;
            }
        
            // Conectar ao banco de dados
            $this->conn = new conectar();
        
            try {
                // 1. Buscar o 'cod_tratamento' associado ao consulta_id
                $queryTratamento = "SELECT cod_tratamento, data, horario FROM consulta WHERE id = :consultaId";
                $stmtTratamento = $this->conn->prepare($queryTratamento);
                $stmtTratamento->bindParam(':consultaId', $consultaId, PDO::PARAM_INT);
                $stmtTratamento->execute();
        
                // Verificar se encontramos a consulta
                if ($stmtTratamento->rowCount() > 0) {
                    $consultaData = $stmtTratamento->fetch(PDO::FETCH_ASSOC);
                    $codTratamento = $consultaData['cod_tratamento'];
                    $dataConsulta = $consultaData['data'];
                    $horaConsulta = $consultaData['horario'];
        
                    // 2. Buscar médicos associados ao tratamento
                    $queryMedicos = "SELECT id_medico FROM medico_tratamento WHERE Id_tratamento = :codTratamento";
                    $stmtMedicos = $this->conn->prepare($queryMedicos);
                    $stmtMedicos->bindParam(':codTratamento', $codTratamento, PDO::PARAM_INT);
                    $stmtMedicos->execute();
        
                    // Verificar se encontramos médicos associados
                    if ($stmtMedicos->rowCount() > 0) {
                        // Iterar sobre os médicos e verificar a disponibilidade
                        while ($medico = $stmtMedicos->fetch(PDO::FETCH_ASSOC)) {
                            $idMedico = $medico['id_medico'];
        
                            // 3. Verificar a disponibilidade do médico para a data e horário
                            $queryDisponibilidade = "SELECT 1 FROM consulta WHERE id_medico = :idMedico AND data = :dataConsulta AND horario = :horaConsulta";
                            $stmtDisponibilidade = $this->conn->prepare($queryDisponibilidade);
                            $stmtDisponibilidade->bindParam(':idMedico', $idMedico, PDO::PARAM_INT);
                            $stmtDisponibilidade->bindParam(':dataConsulta', $dataConsulta, PDO::PARAM_STR);
                            $stmtDisponibilidade->bindParam(':horaConsulta', $horaConsulta, PDO::PARAM_STR);
                            $stmtDisponibilidade->execute();
        
                            // Se encontrar uma consulta já marcada, significa que o médico está ocupado nesse horário
                            if ($stmtDisponibilidade->rowCount() == 0) {
                                // Médico disponível para a data e horário
        
                                // 4. Atualizar a tabela 'consulta' com o novo id_medico
                                $queryAtualizarConsulta = "UPDATE consulta SET id_medico = :idMedico WHERE id = :consultaId";
                                $stmtAtualizar = $this->conn->prepare($queryAtualizarConsulta);
                                $stmtAtualizar->bindParam(':idMedico', $idMedico, PDO::PARAM_INT);
                                $stmtAtualizar->bindParam(':consultaId', $consultaId, PDO::PARAM_INT);
        
                                if ($stmtAtualizar->execute()) {
                                    // Se a atualização for bem-sucedida
                                    echo json_encode([
                                        'status' => 'success',
                                        'available' => true,
                                        'message' => 'Consulta atualizada com o novo médico com sucesso.'
                                    ]);
                                    exit;
                                } else {
                                    // Se falhar ao atualizar
                                    echo json_encode([
                                        'status' => 'error',
                                        'message' => 'Falha ao atualizar o médico da consulta.'
                                    ]);
                                    exit;
                                }
                            }
                        }
        
                        // Se todos os médicos estiverem ocupados
                        echo json_encode(['status' => 'success', 'available' => false, 'message' => 'Nenhum médico encontrado para fazer a substituição, fale com o suporte para cancelar essa consulta.']);
                    } else {
                        // Nenhum médico encontrado para o tratamento
                        echo json_encode(['status' => 'error', 'message' => 'Nenhum médico encontrado para fazer a substituição, fale com o suporte para cancelar essa consulta.']);
                    }
                } else {
                    // Consulta não encontrada
                    echo json_encode(['status' => 'error', 'message' => 'Consulta não encontrada.']);
                }
            } catch (PDOException $e) {
                // Caso ocorra um erro na execução da consulta
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erro ao realizar a operação: ' . $e->getMessage()
                ]);
            }
        }
        
    }

    $realizada = new realizada();
    $realizada->consultaCancelada();
?>