<?php
// Verificar se o valor foi enviado via POST
if (isset($_POST['id_consulta'])) {
    // Obter o valor de 'id_consulta'
    $id_consulta = $_POST['id_consulta'];

    session_start(); 
    $_SESSION['id_consulta'] = $id_consulta;

    // Exibir a resposta
    echo "ID da consulta recebido e armazenado: " . $id_consulta;
} else {
    echo "Nenhum dado enviado.";
}
?>
