<?php
include_once 'Conectar.php';

class Especialidade
{
    private $id;
    private $funcao;
    private $descricao;
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

    public function getFuncao()
    {
        return $this->funcao;
    }

    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    // Função para buscar todas as especialidades
    public function getAllEspecialidades()
    {
        try {
            $sql = $this->conn->prepare("SELECT * FROM especialidade");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Erro ao buscar especialidades: " . $exc->getMessage();
            return [];
        }
    }

    // Função para buscar a função e descrição por ID
    public function getEspecialidadeById($id)
    {
        try {
            $sql = $this->conn->prepare("SELECT funcao, descricao FROM especialidade WHERE id = ?");
            $sql->bindParam(1, $id, PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Erro ao buscar especialidade por ID: " . $exc->getMessage();
            return null;
        }
    }

    // Função para buscar o ID pela função (nome)
    public function getIdByFuncao($funcao)
    {
        try {
            $sql = $this->conn->prepare("SELECT id FROM especialidade WHERE funcao = ?");
            $sql->bindParam(1, $funcao, PDO::PARAM_STR);
            $sql->execute();
            $result = $sql->fetch(PDO::FETCH_ASSOC);

            // Verifica se encontrou a especialidade e retorna o ID
            if ($result) {
                return $result['id'];
            } else {
                return null;  // Retorna null caso não encontre a função
            }
        } catch (PDOException $exc) {
            echo "Erro ao buscar especialidade por função: " . $exc->getMessage();
            return null;
        }
    }
}
?>
