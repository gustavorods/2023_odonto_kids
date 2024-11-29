<?php
session_start();
if (isset($_GET['id_arquivo'])) {
    $id_arquivo = $_GET['id_arquivo'];

    // Conexão com o banco de dados (ajuste conforme necessário)
    $dsn = 'mysql:host=localhost;dbname=odontokids';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para obter o nome do arquivo com base no id_arquivo
        $sql = 'SELECT nome_arquivo FROM prontuario WHERE id_arquivo = :id_arquivo';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_arquivo', $id_arquivo, PDO::PARAM_INT);
        $stmt->execute();

        $arquivo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($arquivo) {
            // Gera a URL pública para o arquivo
            $caminho_diretorio = '/2023_odonto_kids/assets/php/handlers/dashboard_medico/prontuario/uploads/'; // Caminho público
            $nome_arquivo = $arquivo['nome_arquivo'];
            $url_arquivo = $caminho_diretorio . $nome_arquivo;

            // Retorna a URL do arquivo
            echo json_encode(['success' => true, 'url_arquivo' => $url_arquivo]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Arquivo não encontrado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID do arquivo não fornecido.']);
}
?>
