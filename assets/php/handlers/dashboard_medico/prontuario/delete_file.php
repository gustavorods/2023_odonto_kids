<?php
session_start();

// Verifica se o id_arquivo foi enviado
if (isset($_POST['id_arquivo'])) {
    $id_arquivo = $_POST['id_arquivo'];

    // Conexão com o banco de dados
    try {
        $dsn = 'mysql:host=localhost;dbname=odontokids';
        $username = 'root';
        $password = '';
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para obter o nome do arquivo com base no id_arquivo
        $sql = 'SELECT nome_arquivo FROM prontuario WHERE id_arquivo = :id_arquivo';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_arquivo', $id_arquivo, PDO::PARAM_INT);
        $stmt->execute();

        // Verifica se o arquivo existe
        $arquivo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($arquivo) {
            // Definir o caminho do diretório de uploads (ajuste conforme necessário)
            $caminho_diretorio = './uploads/'; // Caminho fixo para os arquivos
            $nome_arquivo = $arquivo['nome_arquivo'];
            $caminho_arquivo = $caminho_diretorio . $nome_arquivo;  // Concatena o caminho fixo com o nome do arquivo

            // Verifica se o arquivo existe no servidor e exclui
            if (unlink($caminho_arquivo)) {
                // Exclui o arquivo do banco de dados
                $deleteSql = 'DELETE FROM prontuario WHERE id_arquivo = :id_arquivo';
                $deleteStmt = $pdo->prepare($deleteSql);
                $deleteStmt->bindParam(':id_arquivo', $id_arquivo, PDO::PARAM_INT);
                if ($deleteStmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Erro ao excluir o arquivo do banco de dados.']);
                    error_log("Erro ao excluir o arquivo do banco de dados: ID do arquivo {$id_arquivo}", 0);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao excluir o arquivo do diretório.']);
                error_log("Erro ao excluir o arquivo do diretório: {$caminho_arquivo}", 0);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Arquivo não encontrado no banco de dados.']);
            error_log("Arquivo não encontrado no banco de dados: ID do arquivo {$id_arquivo}", 0);
        }
    } catch (PDOException $e) {
        // Captura a exceção e registra o erro no log
        echo json_encode(['success' => false, 'error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
        error_log("Erro ao conectar ao banco de dados: " . $e->getMessage(), 0);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID do arquivo não fornecido.']);
    error_log("ID do arquivo não fornecido.", 0);
}
?>
