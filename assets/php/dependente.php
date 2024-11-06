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

    // Construtor
    public function __construct($id_responsavel, $nome, $nasc, $cpf, $id_sexo, $tel_emergencia, $endereco, $id = null) {
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
