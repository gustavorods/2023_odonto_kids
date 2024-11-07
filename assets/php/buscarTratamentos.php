<?php
include_once 'Conectar.php';

class buscarTratamentos {
    private $conn;

    public function buscarTratamentos() {
        $this->conn = new Conectar();

        // Query para pegar todos os tratamentos
        $sql = $this->conn->prepare("SELECT Tratamento FROM tratamento");
        $sql->execute();
        
        // Fetch todos os tratamentos
        $tratamentos = $sql->fetchAll(PDO::FETCH_COLUMN);

        // Retornar os tratamentos como JSON
        echo json_encode($tratamentos);
    }
}

// Instancia a classe e chama o método de busca
$buscarTratamentos = new buscarTratamentos();
$buscarTratamentos->buscarTratamentos();
?>
