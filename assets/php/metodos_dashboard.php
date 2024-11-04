<?php
    include_once 'Conectar.php';

    class metodos_dashboard{
        private $responsavel_id;

        private $conn;

        public function getResponsavelId() {
            return $this->responsavel_id;
        }
    
        public function setResponsavelId($responsavel_idd) {
            $this->responsavel_id = $responsavel_idd;
        }
        
        public function listar_dependentes(){
            try {
                $this->conn = new Conectar();

                // Obtém os dependentes
                $sqlBuscarDependentes = $this->conn->prepare("SELECT * FROM dependentes WHERE id_responsavel = ?");
                $idResponsavel = $this->getResponsavelId();
                $sqlBuscarDependentes->bindParam(1, $idResponsavel, PDO::PARAM_STR);
                $sqlBuscarDependentes->execute();
                $dependentes = $sqlBuscarDependentes->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os dependentes

                return $dependentes;
            } catch (PDOException $exp) {
                echo "Erro ao listar próximas consultas. " . $exp->getMessage();            }
        }

        public function listar_proximas_consultas() {
            try {
                $this->conn = new Conectar();
        
                $dependentes = $this->listar_dependentes(); // Obtém todos os dependentes
                // var_dump($dependentes);

                $consultasOrganizadas = []; // Array para armazenar as consultas organizadas
        
                // Obtém a data atual como timestamp
                $dataAtual = time(); // Timestamp atual
        
                // Arrays para traduzir os meses e dias da semana
                $meses = [
                    'January' => 'JANEIRO',
                    'February' => 'FEVEREIRO',
                    'March' => 'MARÇO',
                    'April' => 'ABRIL',
                    'May' => 'MAIO',
                    'June' => 'JUNHO',
                    'July' => 'JULHO',
                    'August' => 'AGOSTO',
                    'September' => 'SETEMBRO',
                    'October' => 'OUTUBRO',
                    'November' => 'NOVEMBRO',
                    'December' => 'DEZEMBRO'
                ];
        
                $diasDaSemana = [
                    'Sunday' => 'DOMINGO',
                    'Monday' => 'SEGUNDA-FEIRA',
                    'Tuesday' => 'TERÇA-FEIRA',
                    'Wednesday' => 'QUARTA-FEIRA',
                    'Thursday' => 'QUINTA-FEIRA',
                    'Friday' => 'SEXTA-FEIRA',
                    'Saturday' => 'SÁBADO'
                ];
        
                $consultaSql = $this->conn->prepare("
                    SELECT consulta.*, dependentes.nome 
                    FROM consulta 
                    JOIN dependentes ON consulta.id_dependente = dependentes.id 
                    WHERE dependentes.id_responsavel = ? 
                    ORDER BY consulta.data ASC, consulta.horario ASC
                ");
                $idResponsavel = $this->getResponsavelId();
                $consultaSql->bindParam(1, $idResponsavel, PDO::PARAM_INT);

                $consultaSql->execute();
                $consultas = $consultaSql->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($consultas);

                $data_atual = time();
                $consultasOrganizadas = [];
                foreach ($consultas as $consulta) {
                    $data_consulta = $consulta['data'];
                    $data_consulta_time_stamp = strtotime($data_consulta);

                    if ($data_consulta_time_stamp >= $data_atual) {
                        $consultasOrganizadas[] = [
                            'mes' => date('F', $data_consulta_time_stamp), // Mês traduzido em maiúsculas
                            'dia_da_semana' => date('l', $data_consulta_time_stamp), // Dia da semana traduzido em maiúsculas
                            'dia_do_mes' => date('j', $data_consulta_time_stamp), // Dia do mês (1 a 31)
                            'nome_dependente' => $consulta['nome'], // Nome do dependente
                            'id_consulta' => $consulta['id'] // Id da consulta
                        ];
                    }
                }
        
                return $consultasOrganizadas; // Retorna o array organizado
            } catch (PDOException $exp) {
                echo "Erro ao listar próximas consultas. " . $exp->getMessage();
                return false;
            }
        }

        public function listar_historico_consultas() {
            try {
                $this->conn = new Conectar();
                
                $dependentes = $this->listar_dependentes();

            } catch (PDOException $exp) {
                echo "Erro ao listar próximas consultas. " . $exp->getMessage();
                return false;
            }
        }
    }
?>