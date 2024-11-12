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
            $sqlDadosConsulta = $this->conn->prepare("SELECT * FROM consulta WHERE id = ?");
            $sqlDadosConsulta->bindParam(1, $consultaId, PDO::PARAM_INT);
            $sqlDadosConsulta->execute();

            $consulta = $sqlDadosConsulta->fetchAll(PDO::FETCH_ASSOC);

            $consultaOrganizada = [];

            foreach ($consulta as $dado_consulta) {
                $data_consulta = $dado_consulta['data'];
                $hora_consulta = $dado_consulta['horario'];
                $cod_tratamento = $dado_consulta['cod_tratamento'];
                $id_dependente = $dado_consulta['id_dependente'];

                $sqlTratamento = $this->conn->prepare("SELECT Tratamento FROM tratamento WHERE id = ?");
                $sqlTratamento->bindParam(1, $cod_tratamento, PDO::PARAM_INT);
                $sqlTratamento->execute();
                $tratamento = $sqlTratamento->fetchColumn();

                $sqlNomePaciente = $this->conn->prepare("SELECT nome FROM dependentes WHERE id = ?");
                $sqlNomePaciente->bindParam(1, $id_dependente, PDO::PARAM_INT);
                $sqlNomePaciente->execute();
                $nome = $sqlNomePaciente->fetchColumn();

                $consultaOrganizada[] = [
                    'data' => $data_consulta,
                    'hora' => $hora_consulta,
                    'nome' => $nome,
                    'tratamento' => $tratamento
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($consultaOrganizada);
        } catch (PDOException $exc) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $exc->getMessage()]);
        }
    }
}

$dashboard = new detalhesProximaConsulta();
$dashboard->dadosConsulta();
?>
