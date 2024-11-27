<?php
include_once '../../conectar.php';

class detalhesProximaConsulta {
    private $conn;

    public function dadosConsulta() {
        $input = json_decode(file_get_contents('php://input'), true);
        $consultaId = isset($input['consulta_id']) ? intval($input['consulta_id']) : 0;
        // error_log("Consulta ID recebido: " . $consultaId); //para debug

        try {
            $this->conn = new Conectar();

            $sql = $this->conn->prepare("
                SELECT
                    c.data,
                    c.horario,
                    c.id_dependente,
                    d.nome AS nome_dependente,
                    s.status_consulta,
                    t.Tratamento
                FROM
                    consulta c
                JOIN
                    status_consulta s ON c.status_consulta = s.id_status_consulta
                JOIN
                    dependentes d ON c.id_dependente = d.id
                JOIN
                    tratamento t ON c.cod_tratamento = t.id
                WHERE
                    c.id = ?
            ");
            $sql->bindParam(1,$consultaId,PDO::PARAM_INT);
            $sql->execute();
            $detalhes = $sql->fetchAll(PDO::FETCH_ASSOC);

            
            // $detalhesStr = print_r($detalhes, true); // Converta o array para uma string legível
            // error_log($detalhesStr); // Registra no log de erros


            // Verifica se dados foram encontrados
            if (empty($detalhes)) {
                echo json_encode(['error' => 'Consulta não encontrada']);
                // error_log("Consulta não encontrada");
                exit;
            }

            header('Content-Type: application/json');
            echo json_encode($detalhes);
            $this->conn = null;
        } catch (PDOException $exc) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $exc->getMessage()]);
            $this->conn = null;
        }
    }
}

$dashboard = new detalhesProximaConsulta();
$dashboard->dadosConsulta();
?>
