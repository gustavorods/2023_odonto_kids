<?php
include_once 'Conectar.php';

class Consulta {
    // Propriedades da classe, correspondendo aos campos da tabela
    private $id;
    private $responsavel_id;
    private $horario;
    private $data;
    private $id_dependente;
    private $cod_tratamento;
    private $relatorio;
    private $id_medico;
    private $conn;

    // Métodos de acesso (getters) para cada propriedade
    public function getId() {
        return $this->id;
    }

    public function getResponsavelId() {
        return $this->responsavel_id;
    }

    public function getHorario() {
        return $this->horario;
    }

    public function getData() {
        return $this->data;
    }

    public function getIdDependente() {
        return $this->id_dependente;
    }

    public function getCodTratamento() {
        return $this->cod_tratamento;
    }

    public function getRelatorio() {
        return $this->relatorio;
    }

    public function getIdMedico() {
        return $this->id_medico;
    }

    // Métodos de modificação (setters) para cada propriedade
    public function setId($id) {
        $this->id = $id;
    }

    public function setResponsavelId($responsavel_idd) {
        $this->responsavel_id = $responsavel_idd;
    }

    public function setHorario($horario) {
        $this->horario = $horario;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setIdDependente($id_dependente) {
        $this->id_dependente = $id_dependente;
    }

    public function setCodTratamento($cod_tratamento) {
        $this->cod_tratamento = $cod_tratamento;
    }

    public function setRelatorio($relatorio) {
        $this->relatorio = $relatorio;
    }

    public function setIdMedico($id_medico) {
        $this->id_medico = $id_medico;
    }

    // Método para listar todas as consultas por ID responsavel
    function listarPorIdResponsavel() {
        try {
            $this->conn = new Conectar();

            $responsavel_id = $this->getResponsavelId();

            $sql = $this->conn->prepare("
                SELECT * 
                FROM consulta 
                JOIN dependentes ON consulta.id_dependente = dependentes.id
                WHERE dependentes.id_responsavel = ? 
                AND consulta.status_consulta != 1;
            ");
            $sql->bindParam(1, $responsavel_id, PDO::PARAM_INT);

            $sql->execute();

            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($resultado);
            // Verificar se algum dado foi retornado
            if (count($resultado) > 0) {
                $result_cont = true;
            }
            else{
                $result_cont = false;
            }

            $this->conn = null;
            
            return $result_cont;
        } catch (PDOException $exp) {
            echo "Erro ao puxar consultas. " . $exp->getMessage();
        }
    }    
}

?>
