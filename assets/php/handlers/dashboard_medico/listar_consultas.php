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
                        c.id_medico = ?
                        AND c.data >= CURDATE()
                        AND c.status_consulta = 1;    
                ");
                $sql->bindParam(1,$medico_id,PDO::PARAM_INT);
                $sql->execute();
                
                $this->conn = null;

                return $proximas_consultas_medico = $sql->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $exp) {
                echo "Erro ao listar próximas consultas médico. " . $exp->getMessage();
            }
        }

        public function listar_historico_consultas() {
            try {
                $this->conn = new Conectar();
                
                $medico_id = $this->getMedicoId();
                $historico_consultas_sql = $this->conn->prepare("
                    SELECT 
                        c.id AS consulta_id,
                        c.data,
                        c.horario,
                        s.status_consulta,
                        t.Tratamento,
                        c.id,
                        d.nome AS nome_dependente,
                        d.id AS id_dependente,
                        sex.sexo
                    FROM 
                        consulta c
                    JOIN 
                        status_consulta s ON c.status_consulta = s.id_status_consulta
                    JOIN 
                        tratamento t ON c.cod_tratamento = t.Id
                    JOIN 
                        dependentes d ON c.id_dependente = d.id
                    JOIN 
                        sexo sex ON d.id_sexo = sex.id_sexo
                    WHERE 
                        c.id_medico = ?
                        AND c.status_consulta != 1;
                ");

                $historico_consultas_sql->bindParam(1, $medico_id, PDO::PARAM_INT);
                $historico_consultas_sql->execute();
                $historico_consultas = $historico_consultas_sql->fetchAll(PDO::FETCH_ASSOC);

                $historico_consultasStr = print_r($historico_consultas, true); // Converta o array para uma string legível
                error_log($historico_consultasStr); // Registra no log de erros 
                
                $historico_consultas_organizadas = [];

                foreach ($historico_consultas as $historico_consulta) {
                    $data_consulta_time_stamp = strtotime($historico_consulta['data']);

                    $dia_consulta = date('j', $data_consulta_time_stamp);
                    $mes_consulta = $this->mes_semana("mes",date('F', $data_consulta_time_stamp));
                    $horario_formatado = date('H:i', strtotime(datetime: $historico_consulta['horario']));
                    $status = $historico_consulta['status_consulta'];
                    $tratamento = $historico_consulta['Tratamento'];
                    $dependente = $historico_consulta['nome_dependente'];
                    $sexo = $historico_consulta['sexo'];
                    $id = $historico_consulta['id'];
                    $id_dependente = $historico_consulta['id_dependente'];
                    
                    $historico_consultas_organizadas[] = [
                        'dia' => $dia_consulta,
                        'mes' => $mes_consulta,
                        'horario' => $horario_formatado,
                        'status' => $status,
                        'tratamento' => $tratamento,
                        'dependente' => $dependente,
                        'sexo' => $sexo,
                        'id' => $id,
                        'id_dependente' => $id_dependente
                    ];
                }
                
                // var_dump($historico_consultas_organizadas);
                return $historico_consultas_organizadas;
            } catch (PDOException $exp) {
                echo "Erro ao listar próximas consultas. " . $exp->getMessage();
                return false;
            }
        }


        public function  mes_semana(String $mes_ou_semana,String $valor){
            if ($mes_ou_semana == "mes") {
                // Arrays para traduzir os meses com a primeira letra maiúscula
                $meses = [
                    'January' => 'Janeiro',
                    'February' => 'Fevereiro',
                    'March' => 'Março',
                    'April' => 'Abril',
                    'May' => 'Maio',
                    'June' => 'Junho',
                    'July' => 'Julho',
                    'August' => 'Agosto',
                    'September' => 'Setembro',
                    'October' => 'Outubro',
                    'November' => 'Novembro',
                    'December' => 'Dezembro'
                ];
                return $meses[$valor];
            }
            elseif($mes_ou_semana == "semana"){
                // Arrays para traduzir os dias da semana com a primeira letra maiúscula
                $diasDaSemana = [
                    'Sunday' => 'Domingo',
                    'Monday' => 'Segunda-feira',
                    'Tuesday' => 'Terça-feira',
                    'Wednesday' => 'Quarta-feira',
                    'Thursday' => 'Quinta-feira',
                    'Friday' => 'Sexta-feira',
                    'Saturday' => 'Sábado'
                ];

                return $diasDaSemana[$valor];
            }
        }
    }
?>