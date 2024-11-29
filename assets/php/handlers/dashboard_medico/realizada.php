<?php
    include '../..//conectar.php';

    class realizada{
        private $conn;

        function consultaRealizada(){
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
                // Preparar o SQL para atualizar o status da consulta
                $sql = $this->conn->prepare("
                    UPDATE consulta
                    SET status_consulta = 2
                    WHERE id = ?;
                ");
                
                // Vincular o parâmetro (consulta_id)
                $sql->bindParam(1, $consultaId, PDO::PARAM_INT);
            
                // Executar a consulta
                $executou = $sql->execute();
            
                // Verificar se a atualização foi bem-sucedida
                if ($executou) {
                    // Se a consulta foi executada com sucesso
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Status da consulta atualizado com sucesso'
                    ]);
                } else {
                    // Se a consulta falhou
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Falha ao atualizar o status da consulta'
                    ]);
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
    $realizada->consultaRealizada();
?>