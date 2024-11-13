<?php
include_once 'Conectar.php';

// Atributos
class Medico
{
    private $Id;
    private $nome;
    private $email;
    private $cpf;
    private $telefone;
    private $nasc;
    private $id_sexo;
    private $senha;
    private $CRM;
    private $cod_especialidade;
    private $foto;
    private $conn;

    // Getters e Setters
    public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
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

    public function getCRM() {
        return $this->CRM;
    }

    public function setCRM($CRM) {
        $this->CRM = $CRM;
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
            return "Erro ao salvar o registro. " . $exc->getMessage();
        }
    }

    public function alterarFoto($novaFoto) {
        try {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("UPDATE medico SET foto = ? WHERE id = ?");
            $sql->bindParam(1, $novaFoto, PDO::PARAM_STR); // `novaFoto` representa o caminho ou nome do arquivo
            $sql->bindParam(2, $this->getId(), PDO::PARAM_INT); // `id` do médico
            if ($sql->execute()) {
                return "Foto alterada com sucesso!";
            } else {
                return "Erro ao alterar a foto.";
            }
            $this->conn = null;
        } catch (PDOException $exc) {
            return "Erro ao alterar a foto: " . $exc->getMessage();
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

    public function obter_dados_do_user($tabela, $id) {
        try {
            $this->conn = new Conectar();
            
            // Verifica se a tabela é "medico" ou "responsavel"
            if ($tabela === 'medico' || $tabela === 'responsavel') {
                // Define a consulta com base na tabela fornecida
                $sql = $this->conn->prepare("SELECT * FROM $tabela WHERE id = ?");
                $sql->bindParam(1, $id, PDO::PARAM_INT);
                $sql->execute();
    
                // Retorna os dados se encontrados
                $dados = $sql->fetch(PDO::FETCH_ASSOC);
                $this->conn = null;
    
                if ($dados) {
                    return $dados;
                }
            }
    
            return false; // Retorna false se a tabela não for "medico" ou "responsavel" ou se não encontrar dados
    
        } catch (PDOException $exc) {
            echo "Erro ao consultar. " . $exc->getMessage();
            return false;
        }
    }
}
?>
