<?php
include_once 'Conectar.php';

// Atributos
class responsavel
{
    private $id;
    private $nome;
    private $email;
    private $cpf;
    private $telefone;
    private $nasc;
    private $genero;
    private $senha;
    private $conn;

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function setId($iid) {
        $this->id = $iid;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($name) {
        $this->nome = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getNasc() {
        return $this->nasc;
    }

    public function setNasc($nasc) {
        $this->nasc = $nasc;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    // Métodos

    function salvar()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("INSERT INTO responsavel VALUES (null, ?, ?, ?, ?, ?, ?, ?)");
            @$sql->bindParam(1, $this->getNome(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->getEmail(), PDO::PARAM_STR);
            @$sql->bindParam(3, $this->getCpf(), PDO::PARAM_STR);
            @$sql->bindParam(4, $this->getTelefone(), PDO::PARAM_STR);
            @$sql->bindParam(5, $this->getNasc(), PDO::PARAM_STR);
            @$sql->bindParam(6, $this->getGenero(), PDO::PARAM_STR);
            @$sql->bindParam(7, $this->getSenha(), PDO::PARAM_STR);
            if ($sql->execute()) {
                return "Registro salvo com sucesso!";
            }
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            echo "Erro ao salvar o registro. " . $exc->getMessage();
        }
    }

    function alterar()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("SELECT * FROM usuario WHERE id = ?");
            @$sql->bindParam(1, $this->getId(), PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetchAll();
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            echo "Erro ao alterar. " . $exc->getMessage();
        }
    }

    function alterar2()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("UPDATE usuario SET nome = ?, email = ?, cpf = ?, telefone = ?, nasc = ?, genero = ?, senha = ? WHERE id = ?");
            @$sql->bindParam(1, $this->getNome(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->getEmail(), PDO::PARAM_STR);
            @$sql->bindParam(3, $this->getCpf(), PDO::PARAM_STR);
            @$sql->bindParam(4, $this->getTelefone(), PDO::PARAM_STR);
            @$sql->bindParam(5, $this->getNasc(), PDO::PARAM_STR);
            @$sql->bindParam(6, $this->getGenero(), PDO::PARAM_STR);
            @$sql->bindParam(7, $this->getSenha(), PDO::PARAM_STR);
            @$sql->bindParam(8, $this->getId(), PDO::PARAM_INT);
            if ($sql->execute()) {
                return "Registro alterado com sucesso!";
            }
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            echo "Erro ao alterar o registro. " . $exc->getMessage();
        }
    }

    function consultar()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("SELECT * FROM usuario WHERE nome LIKE ?");
            @$sql->bindParam(1, $this->getNome(), PDO::PARAM_STR);
            $sql->execute();
            return $sql->fetchAll();
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            echo "Erro ao consultar. " . $exc->getMessage();
        }
    }

    function exclusao()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("DELETE FROM usuario WHERE id = ?");
            @$sql->bindParam(1, $this->getId(), PDO::PARAM_INT);
            if ($sql->execute()) {
                return "Excluído com sucesso!";
            }
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            echo "Erro ao excluir. " . $exc->getMessage();
        }
    }

    function listar()
    {
        try {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("SELECT * FROM usuario ORDER BY nome");
            $sql->execute();
            return $sql->fetchAll();
            $this->conn = null;
        }
        catch (PDOException $exc) {
            echo "Erro ao listar usuários: " . $exc->getMessage();
        }
    }
}
?>
