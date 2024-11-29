<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o id_consulta está na sessão
    if (isset($_SESSION['id_consulta'])) {
        $id_consulta = $_SESSION['id_consulta'];
    } else {
        echo json_encode(['success' => false, 'error' => 'ID da consulta não encontrado']);
        exit;
    }

    // Verifica se o arquivo foi enviado
    if (isset($_FILES['arquivo_prontuario']) && $_FILES['arquivo_prontuario']['error'] === UPLOAD_ERR_OK) {
        $arquivo = $_FILES['arquivo_prontuario'];
        $nome_arquivo = $_POST['nome_arquivo'];

        // Define o diretório para armazenar os arquivos
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Gera o caminho completo para o arquivo
        $upload_path = $upload_dir . basename($nome_arquivo);

        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($arquivo['tmp_name'], $upload_path)) {
            // Agora você pode armazenar informações no banco de dados, se necessário
            // Exemplo de inserção no banco de dados:
            $dsn = 'mysql:host=localhost;dbname=odontokids';
            $username = 'root';
            $password = '';

            try {
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = 'INSERT INTO prontuario (id_consulta, nome_arquivo, arquivo_prontuario) VALUES (:id_consulta, :nome_arquivo, :arquivo_prontuario)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_consulta', $id_consulta, PDO::PARAM_INT);
                $stmt->bindParam(':nome_arquivo', $nome_arquivo, PDO::PARAM_STR);
                $stmt->bindParam(':arquivo_prontuario', $upload_path, PDO::PARAM_STR);
                $stmt->execute();

                echo json_encode(['success' => true]);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao mover o arquivo para o servidor']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Arquivo não enviado']);
    }
}
?>
