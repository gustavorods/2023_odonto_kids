<?php
    include_once '../../php/conectar.php';

    class metodos_dashboard{
        private $responsavel_id;

        private $conn;

        public function getResponsavelId() {
            return $this->responsavel_id;
        }
    
        public function setResponsavelId($responsavel_idd) {
            $this->responsavel_id = $responsavel_idd;
        }

        public function listar_proximas_consultas() {
            try {
                $this->conn = new Conectar();

                $proximas_consultas_sql = $this->conn->prepare("
                    SELECT consulta.*, dependentes.nome 
                    FROM consulta 
                    JOIN dependentes ON consulta.id_dependente = dependentes.id 
                    WHERE dependentes.id_responsavel = ? 
                    AND consulta.data > CURDATE()  -- Filtra para consultas acima da data de hoje
                    ORDER BY consulta.data ASC, consulta.horario ASC
                ");
                $idResponsavel = $this->getResponsavelId();
                $proximas_consultas_sql->bindParam(1, $idResponsavel, PDO::PARAM_INT);

                $proximas_consultas_sql->execute();
                $proximas_consultas = $proximas_consultas_sql->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($consultas);

                $proximas_consultas_organizadas = [];
                foreach ($proximas_consultas as $consulta) {
                    $data_consulta_time_stamp = strtotime($consulta['data']);

                    $mes = $this->mes_semana("mes",date('F', $data_consulta_time_stamp));
                    $dia_semana = $this->mes_semana("semana",date('l', $data_consulta_time_stamp));
                    $dia_mes = date('j', $data_consulta_time_stamp);
                    $nome = $consulta['nome'];
                    $id = $consulta['id'];

                    $proximas_consultas_organizadas[] = [
                        'mes' => $mes, // Mês traduzido em maiúsculas
                        'dia_da_semana' => $dia_semana, // Dia da semana traduzido em maiúsculas
                        'dia_do_mes' => $dia_mes, // Dia do mês (1 a 31)
                        'nome_dependente' => $nome, // Nome do dependente
                        'id_consulta' => $id // Id da consulta
                    ];
                }
        
                $this->conn = null;
                return $proximas_consultas_organizadas; // Retorna o array organizado
            } catch (PDOException $exp) {
                $this->conn = null;
                echo "Erro ao listar próximas consultas. " . $exp->getMessage();
                return false;
            }
        }

        public function listar_historico_consultas() {
            try {
                $this->conn = new Conectar();
                
                $idResponsavel = $this->getResponsavelId();
                $historico_consultas_sql = $this->conn->prepare("
                    SELECT 
                        consulta.id, 
                        consulta.horario, 
                        consulta.data, 
                        status.status AS id_status, 
                        tratamento.Tratamento AS cod_tratamento, 
                        dependentes.nome AS id_dependente,
                        sexo.sexo AS sexo  -- Adicionando o campo sexo
                    FROM 
                        consulta 
                    JOIN 
                        status ON consulta.id_status = status.id_status 
                    JOIN 
                        tratamento ON consulta.cod_tratamento = tratamento.Id 
                    JOIN 
                        dependentes ON consulta.id_dependente = dependentes.id 
                    JOIN 
                        sexo ON dependentes.id_sexo = sexo.id_sexo  -- Fazendo o JOIN com a tabela sexo
                    WHERE 
                        dependentes.id_responsavel = ? 
                        AND consulta.data < CURDATE()
                ");

                $historico_consultas_sql->bindParam(1, $idResponsavel, PDO::PARAM_INT);
                $historico_consultas_sql->execute();
                $historico_consultas = $historico_consultas_sql->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($historico_consultas);
                
                $historico_consultas_organizadas = [];

                foreach ($historico_consultas as $historico_consulta) {
                    $data_consulta_time_stamp = strtotime($historico_consulta['data']);

                    $dia_consulta = date('j', $data_consulta_time_stamp);
                    $mes_consulta = $this->mes_semana("mes",date('F', $data_consulta_time_stamp));
                    $horario_formatado = date('H:i', strtotime(datetime: $historico_consulta['horario']));
                    $status = $historico_consulta['id_status'];
                    $tratamento = $historico_consulta['cod_tratamento'];
                    $dependente = $historico_consulta['id_dependente'];
                    $sexo = $historico_consulta['sexo'];
                    $id = $historico_consulta['id'];

                    $historico_consultas_organizadas[] = [
                        'dia' => $dia_consulta,
                        'mes' => $mes_consulta,
                        'horario' => $horario_formatado,
                        'status' => $status,
                        'tratamento' => $tratamento,
                        'dependente' => $dependente,
                        'sexo' => $sexo,
                        'id' => $id
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