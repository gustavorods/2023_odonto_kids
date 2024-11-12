<?php
include_once 'Conectar.php';

class Consulta {
    // Propriedades
    private $id;
    private $horario;
    private $data;
    private $id_dependente;
    private $cod_tratamento;
    private $relatorio;
    private $id_medico;
    private $id_status;

    // Conexão com o banco de dados
    private $conn;
    
    // Construtor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Setters (Métodos para definir os valores das propriedades)
    public function setId($id) {
        $this->id = $id;
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

    public function setIdStatus($id_status) {
        $this->id_status = $id_status;
    }

    // Getters (Métodos para obter os valores das propriedades)
    public function getId() {
        return $this->id;
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

    public function getIdStatus() {
        return $this->id_status;
    }

    
}
?>
