<?php
include_once 'Conectar.php';

class sexo
{
    private $id;
    private $sexo;
    private $conn;

    // Construtor para inicializar a conexão
    public function __construct()
    {
        $this->conn = new Conectar();
    }

    // Getters e Setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    // Função para buscar todas os Sexos
    public function getAllSexo()
    {
        try {
            $sql = $this->conn->prepare("SELECT * FROM sexo");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Erro ao buscar valores na tabela sexo: " . $exc->getMessage();
            return [];
        }
    }

    // Função que pega um sexo e verifica o ID dele
    public function sexoToId()
    {
        try {
            $sql = $this->conn->prepare("SELECT id_sexo FROM sexo WHERE sexo = ?");
            @$sql->bindParam(1, $this->getSexo(), PDO::PARAM_STR);
            $sql->execute();
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            
            // Retorna o id do sexo
            return $result['id_sexo'];
        } catch (PDOException $exc) {
            echo "Erro ao buscar ID pelo valor de sexo: " . $exc->getMessage();
            return null;
        }
    }

}
?>
