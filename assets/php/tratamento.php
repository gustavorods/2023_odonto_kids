<?php
include_once 'Conectar.php';

class Tratamento {
    private $id;
    private $tratamento;
    private $descricao;
    private $conn;

    // Construtor para inicializar a classe
    public function __construct($id = null, $tratamento = null, $descricao = null) {
        $this->id = $id;
        $this->tratamento = $tratamento;
        $this->descricao = $descricao;
    }

    // Métodos getters e setters para cada propriedade
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTratamento() {
        return $this->tratamento;
    }

    public function setTratamento($tratamento) {
        $this->tratamento = $tratamento;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function listarTratamentos(){
        $this->conn = new Conectar();

        $sql = $this->conn->prepare("SELECT * FROM tratamento");
        $sql->execute();
        $tratamentos = $sql->fetch(PDO::FETCH_ASSOC);

        return $tratamentos;
    }
}
?>
