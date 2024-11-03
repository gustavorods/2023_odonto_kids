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
        
        public function listar_proximas_consultas() {
            try {
                $this->conn = new Conectar();
        
                // Primeiro, obtém os dependentes
                $sql = $this->conn->prepare("SELECT * FROM dependentes WHERE id_responsavel = ?");
                @$sql->bindParam(1, $this->getResponsavelId(), PDO::PARAM_STR);
                $sql->execute();
        
                $dependentes = $sql->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os dependentes
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
        
                // Itera sobre cada dependente
                foreach ($dependentes as $dependente) {
                    // Consulta a tabela de consultas usando o id do dependente
                    $idDependente = $dependente['id'];
                    // var_dump($idDependente);

                    $consultaSql = $this->conn->prepare("SELECT * FROM consulta WHERE id_dependente = ?");
                    $consultaSql->bindParam(1, $idDependente, PDO::PARAM_STR);
                    // if (!$consultaSql) {
                    //     die('Erro na preparação da consulta: ' . implode(":", $this->conn->errorInfo()));
                    // }
                    
                    $consultaSql->execute();
        
                    // Obtém as datas das consultas
                    $consultas = $consultaSql->fetchAll(PDO::FETCH_ASSOC);
                    // var_dump($consultas);
        
                    // Adiciona cada consulta ao array organizado
                    foreach ($consultas as $consulta) {
                        $dataConsulta = $consulta['data'];
                        $id_consulta = $consulta['id'];
                        $timestampConsulta = strtotime($dataConsulta); // Converte a data da consulta em timestamp
        
                        // Verifica se a data da consulta é maior ou igual à data atual
                        if ($timestampConsulta >= $dataAtual) {
                            // Prepara os dados para o array organizado
                            $mesTraduzido = $meses[date('F', $timestampConsulta)];
                            $diaDaSemanaTraduzido = $diasDaSemana[date('l', $timestampConsulta)];
        
                            $consultasOrganizadas[] = [
                                'mes' => $mesTraduzido, // Mês traduzido em maiúsculas
                                'dia_da_semana' => $diaDaSemanaTraduzido, // Dia da semana traduzido em maiúsculas
                                'dia_do_mes' => date('j', $timestampConsulta), // Dia do mês (1 a 31)
                                'nome_dependente' => $dependente['nome'], // Nome do dependente
                                'id_consulta' => $id_consulta // Id da consulta
                            ];
                        }
                    }
                }
        
                return $consultasOrganizadas; // Retorna o array organizado
            } catch (PDOException $exc) {
                echo "Erro ao listar próximas consultas. " . $exc->getMessage();
                return false;
            }
        }

        public function listar_historico_consultas() {
            try {
                $this->conn = new Conectar();
        
                $sql = $this->conn->prepare("");
            } catch (PDOException $exc) {
                echo "Erro ao listar próximas consultas. " . $exc->getMessage();
                return false;
            }
        }
         
        
    }
?>