<?php
include_once '../../conectar.php';

class consultasMarcadas {
    private $conn;

    public function consultasMarcadas() {
        $input = json_decode(file_get_contents('php://input'), true);
        // error_log("Array recebida: " . var_export($input, true)); //debug
        $tratamento = isset($input['tratamento_nome']) ? $input['tratamento_nome'] : '';
        // error_log("Tratamento recebido: " . $tratamento); //debug

        $this->conn = new Conectar();

        try{
            // Tratamento desejado
            $tratamento_nome = $tratamento;

            // Consulta SQL para buscar datas e horários com JOIN
            $sql = $this->conn->prepare(
                "
                    SELECT 
                        DATE_FORMAT(c.data, '%Y-%m-%d') AS data_formatada, 
                        DATE_FORMAT(c.horario, '%H:%i') AS horario_formatado
                    FROM 
                        tratamento t
                    JOIN 
                        medico_tratamento mt ON t.Id = mt.id_tratamento
                    JOIN 
                        consulta c ON mt.id_medico = c.id_medico
                    WHERE 
                        t.Tratamento = :tratamento_nome
                    ORDER BY 
                        c.data, c.horario;

                "
            );
            // Vincula o parâmetro :tratamento_nome à variável $tratamento_nome
            $sql->bindParam(':tratamento_nome', $tratamento_nome, PDO::PARAM_STR);            
            $sql->execute();
            $datas_horas = $sql->fetchAll(PDO::FETCH_ASSOC);
            $this->conn = null;
            echo json_encode($datas_horas);
        }
        catch(PDOException $exp){
            $this->conn = null;
            header('Content-Type: application/json');
            echo json_encode(['error' => $exp->getMessage()]);
        }
    }
}

// Instancia a classe e chama o método de busca
$consultasMarcadas = new consultasMarcadas();
$consultasMarcadas->consultasMarcadas();
?>
