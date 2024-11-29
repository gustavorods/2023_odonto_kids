<?php
include_once 'Conectar.php';

class Dependente {
    private $id;
    private $id_responsavel;
    private $nome;
    private $nasc;
    private $cpf;
    private $id_sexo;
    private $tel_emergencia;
    private $endereco;
    private $foto; // Novo campo para armazenar a foto

    private $conn;

    // Construtor
    public function __construct($id_responsavel = null, $nome = null, $nasc = null, $cpf = null, $id_sexo = null, $tel_emergencia = null, $endereco = null, $foto = null, $id = null) {
        $this->id_responsavel = $id_responsavel;
        $this->nome = $nome;
        $this->nasc = $nasc;
        $this->cpf = $cpf;
        $this->id_sexo = $id_sexo;
        $this->tel_emergencia = $tel_emergencia;
        $this->endereco = $endereco;
        $this->foto = $foto;
        if ($id !== null) {
            $this->id = $id;
        }
    }

    // Métodos Getters
    public function getId() {
        return $this->id;
    }

    public function getIdResponsavel() {
        return $this->id_responsavel;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getNasc() {
        return $this->nasc;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getIdSexo() {
        return $this->id_sexo;
    }

    public function getTelEmergencia() {
        return $this->tel_emergencia;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getFoto() {
        return $this->foto;
    }

    // Métodos Setters
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setIdResponsavel($id_responsavel) {
        $this->id_responsavel = $id_responsavel;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setNasc($nasc) {
        $this->nasc = $nasc;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setIdSexo($id_sexo) {
        $this->id_sexo = $id_sexo;
    }

    public function setTelEmergencia($tel_emergencia) {
        $this->tel_emergencia = $tel_emergencia;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }


    public function cadastrarDependente() {
        // Cria uma nova conexão com o banco de dados
        $this->conn = new Conectar();
    
        // Prepara a consulta SQL de INSERT
        $sql = $this->conn->prepare("INSERT INTO dependentes (id_responsavel, nome, nasc, cpf, id_sexo, tel_emergencia, endereco, foto) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
        // Bind dos parâmetros para o INSERT
        $sql->bindParam(1, $this->id_responsavel, PDO::PARAM_INT);
        $sql->bindParam(2, $this->nome, PDO::PARAM_STR);
        $sql->bindParam(3, $this->nasc, PDO::PARAM_STR); // A data já deve estar no formato YYYY-MM-DD
        $sql->bindParam(4, $this->cpf, PDO::PARAM_STR);
        $sql->bindParam(5, $this->id_sexo, PDO::PARAM_INT);
        $sql->bindParam(6, $this->tel_emergencia, PDO::PARAM_STR);
        $sql->bindParam(7, $this->endereco, PDO::PARAM_STR);
        $sql->bindParam(8, $this->foto, PDO::PARAM_STR);
    
        // Executa o comando
        $sql->execute();
    }

    public function listarDependentesById() {
        // Cria uma nova conexão com o banco de dados
        $this->conn = new Conectar();
        
        // Obtém o ID do responsável
        $id_responsavel = $this->getIdResponsavel();
        
        try {
            // Prepara a consulta SQL de SELECT
            $sql = $this->conn->prepare("SELECT * FROM dependentes WHERE id_responsavel = ?");
            $sql->bindParam(1, $id_responsavel, PDO::PARAM_INT);
    
            // Executa a consulta
            $sql->execute();
    
            // Retorna os resultados como um array associativo
            $dependentes = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $dependentes;
    
        } catch (PDOException $e) {
            // Tratamento de erro
            echo "Erro ao listar dependentes: " . $e->getMessage();
            return [];
        }
    }    

    public function logDependente() {
        // Cria uma string com os valores das variáveis
        $log_message = "ID: " . $this->getId() . "\n";
        $log_message .= "ID Responsável: " . $this->getIdResponsavel() . "\n";
        $log_message .= "Nome: " . $this->getNome() . "\n";
        $log_message .= "Data de Nascimento: " . $this->getNasc() . "\n";
        $log_message .= "CPF: " . $this->getCpf() . "\n";
        $log_message .= "ID Sexo: " . $this->getIdSexo() . "\n";
        $log_message .= "Telefone de Emergência: " . $this->getTelEmergencia() . "\n";
        $log_message .= "Endereço: " . $this->getEndereco() . "\n";

        // Envia para o log de erros do PHP
        error_log($log_message);
    }
    
    public function nameToId($nome) {
        $this->conn = new Conectar();

        try {
            $sql = $this->conn->prepare("SELECT id FROM dependentes WHERE nome LIKE ?");
            $sql->bindParam(1, $nome, PDO::PARAM_STR);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC)['id'] ?? null;
        } catch (PDOException $e) {
            echo "Erro ao buscar ID pelo nome: " . $e->getMessage();
            return null;
        }
    }

    public function infoById($id) {
        $this->conn = new Conectar();

        try {
            $sql = $this->conn->prepare("SELECT * FROM dependentes WHERE id = ?");
            $sql->bindParam(1, $id, PDO::PARAM_STR);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar dados do dependente: " . $e->getMessage();
            return null;
        }
    }

    public function alterarFoto($novaFoto) {
        try {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("UPDATE dependentes SET foto = ? WHERE id = ?");
            $sql->bindParam(1, $novaFoto, PDO::PARAM_STR); 
            $sql->bindParam(2, $this->getId(), PDO::PARAM_INT); 
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

    public function alterar() {
        try {
            $this->conn = new Conectar();
    
            // Prepara a consulta SQL de UPDATE
            $sql = $this->conn->prepare("UPDATE dependentes SET 
                nome = ?, 
                nasc = ?, 
                cpf = ?, 
                id_sexo = ?, 
                tel_emergencia = ?, 
                endereco = ?
                WHERE id = ?");
    
            // Bind dos parâmetros para o UPDATE
            $sql->bindParam(1, $this->nome, PDO::PARAM_STR);
            $sql->bindParam(2, $this->nasc, PDO::PARAM_STR); // A data já deve estar no formato YYYY-MM-DD
            $sql->bindParam(3, $this->cpf, PDO::PARAM_STR);
            $sql->bindParam(4, $this->id_sexo, PDO::PARAM_INT);
            $sql->bindParam(5, $this->tel_emergencia, PDO::PARAM_STR);
            $sql->bindParam(6, $this->endereco, PDO::PARAM_STR);
            $sql->bindParam(7, $this->id, PDO::PARAM_INT);
    
            // Executa a consulta
            if ($sql->execute()) {
                return "Dependente atualizado com sucesso!";
            } else {
                return "Erro ao atualizar o dependente.";
            }
        } catch (PDOException $e) {
            // Tratamento de erro
            return "Erro ao atualizar o dependente: " . $e->getMessage();
        } finally {
            // Fecha a conexão com o banco de dados
            $this->conn = null;
        }
    }    

    public function ExcluirFotoPerfil() {
        try {
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("UPDATE dependentes SET foto = null WHERE id = ?");
            $sql->bindParam(1, $this->getId(), PDO::PARAM_INT); 
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
}
?>
