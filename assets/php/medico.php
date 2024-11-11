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
    private $genero;
    private $senha;
    private $CRM;
    private $cod_especialidade;
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

    // Métodos

    function salvar()
    {
        try
        {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("INSERT INTO medico VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            @$sql->bindParam(1, $this->getNome(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->getEmail(), PDO::PARAM_STR);
            @$sql->bindParam(3, $this->getCpf(), PDO::PARAM_STR);
            @$sql->bindParam(4, $this->getTelefone(), PDO::PARAM_STR);
            @$sql->bindParam(5, $this->getNasc(), PDO::PARAM_STR);
            @$sql->bindParam(6, $this->getGenero(), PDO::PARAM_STR);
            @$sql->bindParam(7, $this->getSenha(), PDO::PARAM_STR);
            @$sql->bindParam(8, $this->getCrm(), PDO::PARAM_STR);
            @$sql->bindParam(9, $this->getCodEspecialidade(), PDO::PARAM_INT);
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
        // Preparação da consulta SQL para atualizar os dados do médico com base no ID
        $sql = $this->conn->prepare("UPDATE medico SET nome = ?, email = ?, cpf = ?, telefone = ?, nasc = ?, genero = ?, senha = ?, CRM = ?, cod_especialidade = ? WHERE Id = ?");
        
        // Binding dos parâmetros com os valores dos atributos da classe
        @$sql->bindParam(1, $this->getNome(), PDO::PARAM_STR);
        @$sql->bindParam(2, $this->getEmail(), PDO::PARAM_STR);
        @$sql->bindParam(3, $this->getCpf(), PDO::PARAM_STR);
        @$sql->bindParam(4, $this->getTelefone(), PDO::PARAM_STR);
        @$sql->bindParam(5, $this->getNasc(), PDO::PARAM_STR);
        @$sql->bindParam(6, $this->getGenero(), PDO::PARAM_STR);
        @$sql->bindParam(7, $this->getSenha(), PDO::PARAM_STR);
        @$sql->bindParam(8, $this->getCRM(), PDO::PARAM_STR);
        @$sql->bindParam(9, $this->getCodEspecialidade(), PDO::PARAM_INT);
        @$sql->bindParam(10, $this->getId(), PDO::PARAM_INT);

        // Execução do comando SQL
        if ($sql->execute()) {
            return "Registro alterado com sucesso!";
        }
        
        $this->conn = null; // Fecha a conexão
    }
    catch (PDOException $exc)
    {
        echo "Erro ao alterar o registro: " . $exc->getMessage();
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

        // Método para atualizar os dados do usuário
        function alterar2() {
            try {
                // Corrigido para usar "=" em vez de "like"
                $sql = $this->conn->prepare("UPDATE medico SET nome = ?, cpf = ?, email = ?, telefone = ?, nasc = ?, genero = ?, senha = ?, CRM = ?, cod_especialidade = ? WHERE Id = ?");
        
                $nome = $this->getNome();
                $cpf = $this->getCpf();
                $email = $this->getEmail();
                $telefone = $this->getTelefone();
                $nasc = $this->getNasc();
                $genero = $this->getGenero();
                $senha = $this->getSenha();  // Considere que a senha está em texto claro, sem hash
                $CRM = $this->getCRM();
                $codEspecialidade = $this->getCodEspecialidade();
                $Id = $this->getId();
        
                // Binding de parâmetros
                $sql->bindParam(1, $nome, PDO::PARAM_STR);
                $sql->bindParam(2, $cpf, PDO::PARAM_STR);
                $sql->bindParam(3, $email, PDO::PARAM_STR);
                $sql->bindParam(4, $telefone, PDO::PARAM_STR);
                $sql->bindParam(5, $nasc, PDO::PARAM_STR);
                $sql->bindParam(6, $genero, PDO::PARAM_STR);
                $sql->bindParam(7, $senha, PDO::PARAM_STR);
                $sql->bindParam(8, $CRM, PDO::PARAM_STR);
                $sql->bindParam(9, $codEspecialidade, PDO::PARAM_INT);
                $sql->bindParam(10, $Id, PDO::PARAM_INT);
        
                if ($sql->execute()) {
                    return "Usuário alterado com sucesso!";
                }
            } catch (PDOException $exc) {
                echo "Erro ao alterar usuário: " . $exc->getMessage();
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
