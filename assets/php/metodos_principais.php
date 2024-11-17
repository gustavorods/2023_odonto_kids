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
    // Função de login para verificar o email nas duas tabelas
    public function login()
    {
        try {
            $this->conn = new Conectar();
            
            // Verificação na tabela de responsável
            $sql = $this->conn->prepare("SELECT senha FROM responsavel WHERE email = ?");
            @$sql->bindParam(1, $this->get_email_user(), PDO::PARAM_STR);
            $sql->execute();

            $result = $sql->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->conn = null;
                return [
                    'tabela' => 'responsavel',
                    'senha' => $result['senha']
                ];
            }

            // Verificação na tabela de médico
            $this->conn = new Conectar();
            $sql = $this->conn->prepare("SELECT senha FROM medico WHERE email = ?");
            @$sql->bindParam(1, $this->get_email_medico(), PDO::PARAM_STR);
            $sql->execute();

            $result = $sql->fetch(PDO::FETCH_ASSOC);
            $this->conn = null;

            if ($result) {
                return [
                    'tabela' => 'medico',
                    'senha' => $result['senha']
                ];
            }

            // Se não encontrou o email em nenhuma das tabelas, retorna false
            return false;

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
    public function alterarDadosMedico($id, $novosDados) {
        try {
            $this->conn = new Conectar();
    
            $sql = $this->conn->prepare("UPDATE medico SET nome = ?, email = ?, telefone = ?, nasc = ?, genero = ?, cpf = ?, senha = ?, crm = ? WHERE id = ?");
            $sql->bindParam(1, $novosDados['nome'], PDO::PARAM_STR);
            $sql->bindParam(2, $novosDados['email'], PDO::PARAM_STR);
            $sql->bindParam(3, $novosDados['telefone'], PDO::PARAM_STR);
            $sql->bindParam(4, $novosDados['nasc'], PDO::PARAM_STR);
            $sql->bindParam(5, $novosDados['genero'], PDO::PARAM_STR);
            $sql->bindParam(6, $novosDados['cpf'], PDO::PARAM_STR);
            $sql->bindParam(7, $novosDados['senha'], PDO::PARAM_STR);
            $sql->bindParam(8, $novosDados['crm'], PDO::PARAM_STR);
            $sql->bindParam(9, $id, PDO::PARAM_INT);
            
    
            if ($sql->execute()) {
                return true;
            } else {
                return false;
            }
    
        } catch (PDOException $exc) {
            echo "Erro ao atualizar dados: " . $exc->getMessage();
            return false;
        }
    }

    public function atualizarFoto($id, $foto) {
        try {
            $this->conn = new Conectar();
            
            // Atualiza o campo foto na tabela do médico
            $sql = $this->conn->prepare("UPDATE medico SET foto = ? WHERE id = ?");
            $sql->bindParam(1, $foto, PDO::PARAM_STR);
            $sql->bindParam(2, $id, PDO::PARAM_INT);
            
            if ($sql->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            echo "Erro ao atualizar foto: " . $exc->getMessage();
            return false;
        }
    }
    
    
}
?>
