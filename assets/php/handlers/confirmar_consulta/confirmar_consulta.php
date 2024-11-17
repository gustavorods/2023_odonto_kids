<?php
include_once '../../conectar.php';

class confirmar_consulta {
    private $conn;

    public function confirmar_consulta(){
        // Decodifica o JSON da requisição
        $data = json_decode(file_get_contents("php://input"), true);

        $hora = $data['hora'];
        $dataConsulta = $data['data'];
        $dependente = $data['dependente'];
        $tratamento = $data['tratamento'];

        // Conectar ao banco de dados
        $this->conn = new Conectar();
        
        // 1. Buscar o ID do tratamento baseado na string do tratamento
        $queryTratamento = "SELECT Id FROM tratamento WHERE Tratamento = :tratamento";  // Alterei para 'Tratamento' (confirme o nome correto)
        $stmtTratamento = $this->conn->prepare($queryTratamento);
        $stmtTratamento->bindParam(':tratamento', $tratamento);
        
        // Depuração - log da consulta (agora apenas a string SQL)
        //error_log("Executando query: " . $queryTratamento);
        $stmtTratamento->execute();
        
        if ($stmtTratamento->rowCount() > 0) {
            $tratamentoId = $stmtTratamento->fetch(PDO::FETCH_ASSOC)['Id'];
            //error_log("Tratamento encontrado, ID: " . $tratamentoId);
        
            // 2. Buscar os médicos associados ao tratamento
            $queryMedicos = "SELECT id_medico FROM medico_tratamento WHERE Id_tratamento = :tratamentoId";
            $stmtMedicos = $this->conn->prepare($queryMedicos);
            $stmtMedicos->bindParam(':tratamentoId', $tratamentoId);
            
            // Depuração - log da consulta
            //error_log("Executando query: " . $queryMedicos);
            $stmtMedicos->execute();
        
            if ($stmtMedicos->rowCount() > 0) {
                // Iterar sobre os médicos e tentar encontrar um que tenha disponibilidade
                while ($medico = $stmtMedicos->fetch(PDO::FETCH_ASSOC)) {
                    $idMedico = $medico['id_medico'];
                    //error_log("Verificando médico ID: " . $idMedico);
        
                    // 3. Verificar se já existe uma consulta marcada para o médico no horário e data fornecidos
                    $queryConsultaExistente = "SELECT 1 FROM consulta WHERE id_medico = :idMedico AND data = :dataConsulta AND horario = :hora";
                    $stmtConsultaExistente = $this->conn->prepare($queryConsultaExistente);
                    $stmtConsultaExistente->bindParam(':idMedico', $idMedico);
                    $stmtConsultaExistente->bindParam(':dataConsulta', $dataConsulta);
                    $stmtConsultaExistente->bindParam(':hora', $hora);
                    
                    // Depuração - log da consulta
                    //error_log("Executando query: " . $queryConsultaExistente);
                    $stmtConsultaExistente->execute();
        
                    // Se não houver consulta existente para este médico no horário
                    if ($stmtConsultaExistente->rowCount() == 0) {
                        //error_log("Médico disponível para a consulta. Realizando insert.");
                        
                        // 4. Realizar o insert na tabela consulta
                        $queryInsertConsulta = "INSERT INTO consulta (horario, data, id_dependente, cod_tratamento, relatorio, id_medico, id_status) 
                                                VALUES (:hora, :dataConsulta, :dependente, :tratamentoId, '', :idMedico, 1)";
                        $stmtInsertConsulta = $this->conn->prepare($queryInsertConsulta);
        
                        // Bind dos parâmetros
                        $stmtInsertConsulta->bindParam(':hora', $hora);
                        $stmtInsertConsulta->bindParam(':dataConsulta', $dataConsulta);
                        $stmtInsertConsulta->bindParam(':dependente', $dependente);
                        $stmtInsertConsulta->bindParam(':tratamentoId', $tratamentoId);
                        $stmtInsertConsulta->bindParam(':idMedico', $idMedico);
        
                        // Executar o insert
                        if ($stmtInsertConsulta->execute()) {
                            echo json_encode(["status" => "sucesso", "message" => "Consulta agendada com sucesso."]);
                            exit;
                        } else {
                            //error_log("Erro ao realizar o insert da consulta.");
                            echo json_encode(["status" => "erro", "message" => "Erro ao tentar agendar a consulta."]);
                            exit;
                        }
                    } else {
                        //error_log("Médico ocupado neste horário.");
                    }
                }
        
                // Se todos os médicos estiverem ocupados, retornar uma mensagem
                echo json_encode(["status" => "erro", "message" => "Todos os médicos estão ocupados nesse horário."]);
            } else {
                //error_log("Nenhum médico encontrado para o tratamento: " . $tratamento);
                echo json_encode(["status" => "erro", "message" => "Tratamento não encontrado."]);
            }
        } else {
            //error_log("Tratamento não encontrado: " . $tratamento);
            echo json_encode(["status" => "erro", "message" => "Tratamento não encontrado."]);
        }
    }
}

// Instancia a classe e chama o método de busca
$confirmar_consulta = new confirmar_consulta();
$confirmar_consulta->confirmar_consulta();
?>
