<?php
include_once 'Conectar.php';

class metodos_principais
{
    private $email_user;
    private $senha_user;
    private $email_medico;
    private $senha_medico;
    private $conn;

    // Getters e Setters para email e senha do usuário
    public function get_email_user() {
        return $this->email_user;
    }

    public function set_email_user($email_userr) {
        $this->email_user = $email_userr;
    }

    public function get_senha_user() {
        return $this->senha_user;
    }

    public function set_senha_user($senha_userr) {
        $this->senha_user = $senha_userr;
    }

    // Getters e Setters para email e senha do médico
    public function get_email_medico() {
        return $this->email_medico;
    }

    public function set_email_medico($email_medicoo) {
        $this->email_medico = $email_medicoo;
    }

    public function get_senha_medico() {
        return $this->senha_medico;
    }

    public function set_senha_medico($senha_medicoo) {
        $this->senha_medico = $senha_medicoo;
    }

    // Método de login
    public function login()
    {
        try {
            $this->conn = new Conectar();
            
            // Verificação na tabela de responsável
            $sql = $this->conn->prepare("SELECT * FROM responsavel WHERE email = ? AND senha = ?");
            @$sql->bindParam(1, $this->get_email_user(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->get_senha_user(), PDO::PARAM_STR);
            $sql->execute();

            $result = $sql->fetch();

            if ($result) {
                $this->conn = null;
                return "responsavel"; // Se encontrou um responsável, retorna "responsavel"
            }

            $this->conn = new Conectar();

            // Caso não seja encontrado, verifica na tabela de médico
            $sql = $this->conn->prepare("SELECT * FROM medico WHERE email = ? AND senha = ?");
            @$sql->bindParam(1, $this->get_email_medico(), PDO::PARAM_STR);
            @$sql->bindParam(2, $this->get_senha_medico(), PDO::PARAM_STR);
            $sql->execute();

            $result = $sql->fetch();
            $this->conn = null;

            if ($result) {
                return "medico"; // Se encontrou um médico, retorna "medico"
            }

            return false; // Se não encontrou nada, retorna false

        } catch (PDOException $exc) {
            echo "Erro ao consultar. " . $exc->getMessage();
            return false;
        }
    }

    public function selectId($nome_tabela_enviada)
    {
        try {
            $this->conn = new Conectar();
            
            // Verificação na tabela de responsável
            $sql = $this->conn->prepare("SELECT Id FROM $nome_tabela_enviada WHERE email = ?");
            @$sql->bindParam(1, $this->get_email_user(), PDO::PARAM_STR);
            $sql->execute();

            $result = $sql->fetchColumn();

            if ($result) {
                $this->conn = null;
                return $result; // Se encontrou um responsável, retorna "responsavel"
            }
        } catch (PDOException $exc) {
            echo "Erro ao consultar. " . $exc->getMessage();
            return false;
        }
    }

    
    public function email_existe($email) {
        try {
            $this->conn = new Conectar();
    
            // Verifica o email na tabela de responsáveis
            $sql = $this->conn->prepare("SELECT * FROM responsavel WHERE email = ?");
            $sql->bindParam(1, $email, PDO::PARAM_STR);
            $sql->execute();
    
            // Se o email for encontrado na tabela de responsáveis, retorna true
            if ($sql->fetch()) {
                return true;
            }
    
            // Verifica o email na tabela de médicos, se não encontrado em responsáveis
            $sql = $this->conn->prepare("SELECT * FROM medico WHERE email = ?");
            $sql->bindParam(1, $email, PDO::PARAM_STR);
            $sql->execute();
    
            // Se o email for encontrado na tabela de médicos, retorna true
            if ($sql->fetch()) {
                return true;
            }
    
            // Se não encontrou em nenhuma tabela, retorna false
            return false;
    
        } catch (PDOException $exc) {
            echo "Erro ao consultar. " . $exc->getMessage();
            return false;
        }
    }

    public function verificar_email_tabela_e_id($email) {
        try {
            $this->conn = new Conectar();
    
            // Verifica o email na tabela de responsáveis
            $sql = $this->conn->prepare("SELECT id FROM responsavel WHERE email = ?");
            $sql->bindParam(1, $email, PDO::PARAM_STR);
            $sql->execute();
    
            $result = $sql->fetch(PDO::FETCH_ASSOC);
    
            // Se o email for encontrado na tabela de responsáveis, retorna o id e a tabela
            if ($result) {
                return [
                    'tabela' => 'responsavel',
                    'id' => $result['id']
                ];
            }
    
            // Verifica o email na tabela de médicos, se não encontrado em responsáveis
            $sql = $this->conn->prepare("SELECT id FROM medico WHERE email = ?");
            $sql->bindParam(1, $email, PDO::PARAM_STR);
            $sql->execute();
    
            $result = $sql->fetch(PDO::FETCH_ASSOC);
    
            // Se o email for encontrado na tabela de médicos, retorna o id e a tabela
            if ($result) {
                return [
                    'tabela' => 'medico',
                    'id' => $result['id']
                ];
            }
    
            // Se não encontrou em nenhuma tabela, retorna false
            return false;
    
        } catch (PDOException $exc) {
            echo "Erro ao consultar. " . $exc->getMessage();
            return false;
        }
    }    
}
?>
