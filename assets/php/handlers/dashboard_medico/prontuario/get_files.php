<?php
session_start();

if (!isset($_SESSION['id_consulta'])) {
    echo json_encode(['success' => false, 'error' => 'ID da consulta não encontrado']);
    exit;
}

$id_consulta = $_SESSION['id_consulta'];

try {
    // Conexão com o banco de dados
    $dsn = 'mysql:host=localhost;dbname=odontokids';
    $username = 'root';
    $password = '';
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para buscar os arquivos relacionados ao id_consulta
    $sql = 'SELECT nome_arquivo, id_arquivo FROM prontuario WHERE id_consulta = :id_consulta';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_consulta', $id_consulta, PDO::PARAM_INT);
    $stmt->execute();

    // Busca os arquivos e retorna como JSON
    $arquivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'files' => $arquivos]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro ao buscar os arquivos: ' . $e->getMessage()]);
}
?>
