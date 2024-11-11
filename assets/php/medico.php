<?php
include_once 'Conectar.php';

// Atributos
class Medico
{
    private $id;
    private $nome;
    private $email;
    private $cpf;
    private $telefone;
    private $nasc;
    private $id_sexo;
    private $senha;
    private $crm;
    private $cod_especialidade;
    private $foto;
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

    public function getId_sexo() {
        return $this->id_sexo;
    }

    public function setId_sexo($id_sexo) {
        $this->id_sexo = $id_sexo;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getCrm() {
        return $this->crm;
    }

    public function setCrm($crm) {
        $this->crm = $crm;
    }

    public function getCodEspecialidade() {
        return $this->cod_especialidade;
    }

    public function setCodEspecialidade($cod_especialidade) {
        $this->cod_especialidade = $cod_especialidade;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    // Métodos

    function salvar()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("INSERT INTO medico VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            @$sql->bindParam(1, $this->getNome(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->getEmail(), PDO::PARAM_STR);
            @$sql->bindParam(3, $this->getCpf(), PDO::PARAM_STR);
            @$sql->bindParam(4, $this->getTelefone(), PDO::PARAM_STR);
            @$sql->bindParam(5, $this->getNasc(), PDO::PARAM_STR);
            @$sql->bindParam(6, $this->getId_sexo(), PDO::PARAM_STR);
            @$sql->bindParam(7, $this->getSenha(), PDO::PARAM_STR);
            @$sql->bindParam(8, $this->getCrm(), PDO::PARAM_STR);
            @$sql->bindParam(9, $this->getCodEspecialidade(), PDO::PARAM_INT);
            @$sql->bindParam(10,$this->getFoto(), PDO::PARAM_INT);
            if ($sql->execute()) {
                return "Registro salvo com sucesso!";
            } else {
                return "Erro ao salvar!";
            }
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            return "Erro ao salvar o registro. " . $exc->getMessage();
        }
    }

    function alterar()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("SELECT * FROM medico WHERE id = ?");
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
            $sql = $this->conn->prepare("UPDATE medico SET nome = ?, email = ?, cpf = ?, telefone = ?, nasc = ?, id_sexo = ?, senha = ?, crm = ?, cod_especialidade = ? WHERE id = ?");
            @$sql->bindParam(1, $this->getNome(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->getEmail(), PDO::PARAM_STR);
            @$sql->bindParam(3, $this->getCpf(), PDO::PARAM_STR);
            @$sql->bindParam(4, $this->getTelefone(), PDO::PARAM_STR);
            @$sql->bindParam(5, $this->getNasc(), PDO::PARAM_STR);
            @$sql->bindParam(6, $this->getId_sexo(), PDO::PARAM_STR);
            @$sql->bindParam(7, $this->getSenha(), PDO::PARAM_STR);
            @$sql->bindParam(8, $this->getCrm(), PDO::PARAM_STR);
            @$sql->bindParam(9, $this->getCodEspecialidade(), PDO::PARAM_INT);
            @$sql->bindParam(10, $this->getId(), PDO::PARAM_INT);
            if ($sql->execute()) {
                return "Registro alterado com sucesso!";
            }
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            echo "Erro ao salvar o registro. " . $exc->getMessage();
        }
    }

    function consultar()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("SELECT * FROM medico WHERE nome LIKE ?");
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
            $sql = $this->conn->prepare("DELETE FROM medico WHERE id = ?");
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
            $sql = $this->conn->prepare("SELECT * FROM medico ORDER BY nome");
            $sql->execute();
            return $sql->fetchAll();
            $this->conn = null;
        }
        catch (PDOException $exc) {
            echo "Erro ao listar médicos: " . $exc->getMessage();
        }
    }

    function alterar_senha() {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("UPDATE medico SET senha = ? WHERE id = ?");
            @$sql->bindParam(1, $this->getSenha(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->getId(), PDO::PARAM_INT);
            if ($sql->execute()) {
                return "Registro alterado com sucesso!";
            }
            $this->conn = null;
        }
        catch (PDOException $exc)
        {
            echo "Erro ao salvar o registro. " . $exc->getMessage();
        }
    }
}
?>
