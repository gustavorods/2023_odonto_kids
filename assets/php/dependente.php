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

    private $conn;

    // Construtor
    public function __construct($id_responsavel = null, $nome = null, $nasc = null, $cpf = null, $id_sexo = null, $tel_emergencia = null, $endereco = null, $id = null) {
        $this->id_responsavel = $id_responsavel;
        $this->nome = $nome;
        $this->nasc = $nasc;
        $this->cpf = $cpf;
        $this->id_sexo = $id_sexo;
        $this->tel_emergencia = $tel_emergencia;
        $this->endereco = $endereco;
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

    // Métodos Setters
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

    public function cadastrarDependente() {
        // Cria uma nova conexão com o banco de dados
        $this->conn = new Conectar();
    
        // Prepara a consulta SQL de INSERT
        $sql = $this->conn->prepare("INSERT INTO dependentes (id_responsavel, nome, nasc, cpf, id_sexo, tel_emergencia, endereco) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
    
        // Bind dos parâmetros para o INSERT
        $sql->bindParam(1, $this->id_responsavel, PDO::PARAM_INT);
        $sql->bindParam(2, $this->nome, PDO::PARAM_STR);
        $sql->bindParam(3, $this->nasc, PDO::PARAM_STR); // A data já deve estar no formato YYYY-MM-DD
        $sql->bindParam(4, $this->cpf, PDO::PARAM_STR);
        $sql->bindParam(5, $this->id_sexo, PDO::PARAM_INT);
        $sql->bindParam(6, $this->tel_emergencia, PDO::PARAM_STR);
        $sql->bindParam(7, $this->endereco, PDO::PARAM_STR);
    
        // Executa o comando
        $sql->execute();
    }

    public function listarDependentes() {
        // Cria uma nova conexão com o banco de dados
        $this->conn = new Conectar();
    
        // Prepara a consulta SQL de SELECT
        $sql = $this->conn->prepare("SELECT id, nome, cpf, nasc FROM dependentes");
    
        // Executa a consulta
        $sql->execute();
    
        // Array para armazenar os dados dos dependentes
        $dependentes = [];
    
        // Busca os resultados
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            // Calcula a idade com base na data de nascimento
            $nasc = new DateTime($row['nasc']);
            $hoje = new DateTime();
            $idade = $hoje->diff($nasc)->y;
    
            // Cria o array para o dependente com os dados solicitados
            $dependente = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'cpf' => $row['cpf'], // Aplicando a máscara no CPF
                'idade' => $idade,
                'foto' => 'IMG/placeholder.jpg' // Placeholder para imagem por enquanto
            ];
    
            // Adiciona o dependente ao array de dependentes
            $dependentes[] = $dependente;
        }
    
        // Retorna o array de dependentes
        return $dependentes;
    }
    
    

    // Método para logar os dados
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
}
?>
