<?php
    include_once '../../php/conectar.php';

    class listar_consultas{

        private $medico_id;
        private $conn;

        public function getMedicoId() {
            return $this->medico_id;
        }
    
        public function setMedicoId($medico_id) {
            $this->medico_id = $medico_id;
        }

        function listarProximasConsultas(){
            try {
                $this->conn = new Conectar();

                $medico_id = $this->getMedicoId();

                $sql = $this->conn->prepare("
                    SELECT 
                        c.data, 
                        d.nome AS nome_dependente, 
                        t.Tratamento AS nome_tratamento, 
                        c.id
                    FROM 
                        consulta c
                    JOIN 
                        dependentes d ON c.id_dependente = d.id
                    JOIN 
                        tratamento t ON c.cod_tratamento = t.Id
                    WHERE 
                        c.id_medico = ?;               
                ");
                $sql->bindParam(1,$medico_id,PDO::PARAM_INT);
                $sql->execute();
                
                $this->conn = null;

                return $proximas_consultas_medico = $sql->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $exp) {
                echo "Erro ao listar próximas consultas médico. " . $exp->getMessage();
            }
        }
    }
?>