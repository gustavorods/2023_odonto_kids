<?php
session_start();
include_once '../php/metodos_principais.php';

$metodos = new metodos_principais();
$id = $_POST['id'];
$novosDados = [
    'nome' => $_POST['nome'],
    'email' => $_POST['email'],
    'telefone' => $_POST['telefone'],
    'nasc' => $_POST['nasc'],
    'genero' => $_POST['genero'],
    'cpf' => $_POST['cpf'],
    'senha' => $_POST['senha'], // Senha como string simples
    'crm' => $_POST['crm'],
    'especialidade' => $_POST['especialidade']
];


// Executa a alteração dos dados
if ($metodos->alterarDadosMedico($id, $novosDados)) {
    $_SESSION['mensagem'] = "Informações atualizadas com sucesso!";
    echo "success";
} else {
    echo "error";
}
?>
