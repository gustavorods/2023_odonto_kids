<?php
// Verifica se o valor 'data-id' foi enviado via POST
if (isset($_POST['data-id'])) {
    // Obtém o valor do 'data-id' enviado no POST
    $id_consulta = $_POST['data-id'];

    // Agora você pode usar o $dataId em sua lógica
    // echo "O data-id enviado é: " . htmlspecialchars($id_consulta);
} else {
    echo "O data-id não foi enviado!";
}

// Conexão com o banco de dados (exemplo usando MySQL com PDO)
$dsn = 'mysql:host=localhost;dbname=odontokids'; // Substitua 'nome_do_banco' com o nome do seu banco
$username = 'root'; // Substitua pelo seu nome de usuário do banco de dados
$password = ''; // Substitua pela sua senha do banco de dados

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obter os arquivos relacionados ao id_consulta
    $sql = 'SELECT * FROM prontuario WHERE id_consulta = :id_consulta';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_consulta', $id_consulta, PDO::PARAM_INT);
    $stmt->execute();

    $arquivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard_medico/dashboard_medico.css">
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/prontuario/prontuario.css">
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
    <title>Prontuário | Odontokids</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
            <div class="container-fluid">

                <div class="voltar" onclick=window.history.back();>
                    <img src="/2023_odonto_kids/assets/img/login/seta_voltar.svg" alt="">
                </div>                    
                <div id="div-logo">
                    <h1>Odonto kids</h1>
                    <img src="/2023_odonto_kids/assets/img/geral/Logo.svg" alt="Odonto Kids logo">
                </div>
        
                <!-- <div id="div_perfil">
                    <a href="#">
                        <img class="foto_de_perfil_responsavel" name="img_foto_perfil_responsavel"src="/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png" alt="foto de perfil">
                    </a>
                </div> -->
            </div>
    </nav>

    <div class="container-divs">
        <div class="container">
            <!-- Área de Drop -->
            <!-- <div class="drop-area" id="drop-area">
                <p>Arraste os arquivos aqui ou clique para selecionar</p>
                <input type="file" id="file-input" multiple accept=".pdf">
            </div> -->

            <!-- Lista de Arquivos -->
            <div class="lista-de-arquivos">
                <ul id="file-list">
                    <?php
                    // Exibe os arquivos obtidos do banco de dados
                    foreach ($arquivos as $arquivo) {
                        $nome_arquivo = htmlspecialchars($arquivo['nome_arquivo']);
                        $id_arquivo = htmlspecialchars($arquivo['id_arquivo']);
                        echo '<li class="file-item">
                                <span class="file-name">' . $nome_arquivo . '</span>
                                <div class="file-actions">
                                    <img src="/2023_odonto_kids/assets/img/dashboard_medico/prontuario/abrir.png" alt="Visualizar" class="icon" onclick="viewFile(\'' . $id_arquivo . '\')">
                                </div>
                            </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <p>Tem certeza de que deseja excluir este arquivo?</p>
                <button id="confirm-delete">Sim</button>
                <button id="cancel-delete" class="cancel">Não</button>
            </div>
        </div>
    </div>

    <script>
        const dropArea = document.getElementById("drop-area");
        const fileInput = document.getElementById("file-input");
        const fileList = document.getElementById("file-list");
        const modal = document.getElementById("modal");
        const confirmDeleteBtn = document.getElementById("confirm-delete");
        const cancelDeleteBtn = document.getElementById("cancel-delete");

        let fileToRemove = null;

        // Carregar arquivos do localStorage ao entrar na página
        // window.onload = function () {
        //     loadFiles();
        // };

        dropArea.addEventListener("click", () => {
            fileInput.click(); // Simula o clique no input de arquivos
        });        

        // Prevenir o comportamento padrão do navegador (evitar abrir o arquivo na tela)
        dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropArea.classList.add("hover");
        });

        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove("hover");
        });

        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            dropArea.classList.remove("hover");

            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        // Função para tratar arquivos
        fileInput.addEventListener("change", (e) => {
            const files = e.target.files;
            handleFiles(files);
        });

        // // Função para exibir arquivos na lista
        // function displayFile(file) {
        //     const listItem = document.createElement('li');
        //     listItem.id = `file-${file.name}`;
        //     listItem.innerHTML = `
        //         <span class="file-name">${file.name}</span>
        //         <span class="download-btn" onclick="downloadFile('${file.name}')">⬇️</span>
        //         <span class="remove-btn" onclick="confirmDelete('${file.name}')">🗑️</span>
        //     `;
        //     fileList.appendChild(listItem);
        // }

        // Função para carregar os arquivos do localStorage e exibi-los
        // function loadFiles() {
        //     let storedFiles = JSON.parse(localStorage.getItem('files')) || [];
        //     // Limpar a lista atual antes de recarregar
        //     fileList.innerHTML = '';
        //     storedFiles.forEach(file => {
        //         if (file) { // Certifique-se de que o arquivo não é `undefined` ou nulo
        //             displayFile(file);
        //         }
        //     });
        // }

        // Função para lidar com arquivos arrastados ou selecionados
        function handleFiles(files) {
            // Obtém o id_consulta da sessão (do PHP)
            const idConsulta = <?php echo $id_consulta?>;

            // Loop para processar cada arquivo selecionado
            Array.from(files).forEach(file => {
                // Verifica se o arquivo é PDF
                if (file.type !== 'application/pdf') {
                    alert('Somente arquivos PDF são permitidos!');
                    return; // Ignora o arquivo se não for PDF
                }


                // Prepare o arquivo para upload
                const formData = new FormData();
                formData.append('data-id', idConsulta);  // Passa o id_consulta da sessão
                formData.append('arquivo_prontuario', file);  // O arquivo
                formData.append('nome_arquivo', file.name);  // Nome do arquivo

                // Envia o arquivo para o servidor usando AJAX (fetch)
                fetch('/2023_odonto_kids/assets/php/handlers/dashboard_medico/prontuario/upload_file.php', { // Crie o arquivo PHP para processar o upload
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Após sucesso no upload, salva o arquivo no localStorage (ou atualiza a UI)
                        updateFileList();
                    } else {
                        alert('Erro ao enviar o arquivo: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Erro ao fazer upload do arquivo:', error);
                    alert('Erro ao fazer upload do arquivo.');
                });
            });
        }


        // Função para visualizar o arquivo em uma nova página
        function viewFile(idArquivo) {
            // Faz uma requisição para obter o URL correto do arquivo
            fetch(`/2023_odonto_kids/assets/php/handlers/dashboard_medico/prontuario/view_file.php?id_arquivo=${idArquivo}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redireciona para o arquivo gerado com a URL pública
                        window.open(data.url_arquivo, '_blank');
                    } else {
                        alert('Erro ao carregar o arquivo para visualização.');
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar o arquivo:', error);
                    alert('Erro ao carregar o arquivo.');
                });
        }

        // Função para confirmar exclusão de arquivo
        function confirmDelete(fileId) {
            fileToRemove = fileId;
            // console.log(fileToRemove);
            modal.style.display = 'flex';
        }

        // Função para cancelar a exclusão
        cancelDeleteBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            fileToRemove = null;
        });

        // Função para confirmar a exclusão de arquivo
        confirmDeleteBtn.addEventListener('click', () => {
            // Enviar a solicitação para o servidor para excluir o arquivo da tabela prontuario
            fetch('/2023_odonto_kids/assets/php/handlers/dashboard_medico/prontuario/delete_file.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_arquivo=${fileToRemove}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // // Exclui o arquivo da lista localStorage e da interface
                    // let storedFiles = JSON.parse(localStorage.getItem('files')) || [];
                    // storedFiles = storedFiles.filter(file => file.name !== fileToRemove);
                    // localStorage.setItem('files', JSON.stringify(storedFiles));

                    // // Remove o arquivo da lista de arquivos na interface
                    // const fileItem = document.getElementById(`file-${fileToRemove}`);
                    // if (fileItem) {
                    //     fileItem.remove();
                    // }Erro ao excluir o arquivo no banco de dados.
                    updateFileList();
                } else {
                    alert('Erro ao excluir o arquivo no banco de dados.');
                    console.log(data.error);
                }
            })
            .catch(err => {
                console.error('Erro ao excluir o arquivo:', err);
                alert('Erro ao excluir o arquivo.');
            });

            modal.style.display = 'none';
            fileToRemove = null;
        });

        // Função para atualizar a exibição da lista de arquivos
        function updateFileList() {
            // Faz uma requisição AJAX para o servidor para buscar os arquivos
            fetch('/2023_odonto_kids/assets/php/handlers/dashboard_medico/prontuario/get_files.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // console.log(data)
                        const fileList = document.getElementById("file-list");
                        fileList.innerHTML = ''; // Limpa a lista de arquivos

                        // Adiciona os arquivos recebidos ao DOM
                        data.files.forEach(arquivo => {
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `
                                <span class="file-name">${arquivo.nome_arquivo}</span>
                                <div class="file-actions">
                                    <img src="/2023_odonto_kids/assets/img/dashboard_medico/prontuario/abrir.png" alt="Visualizar" class="icon" onclick="viewFile(${arquivo.id_arquivo})">
                                    <img src="/2023_odonto_kids/assets/img/dashboard_medico/prontuario/lixeira.png" alt="Excluir" class="icon" onclick="confirmDelete(${arquivo.id_arquivo})">
                                </div>
                            `;
                            fileList.appendChild(listItem);
                        });
                    } else {
                        alert('Erro ao carregar os arquivos.');
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar arquivos:', error);
                    alert('Erro ao carregar a lista de arquivos.');
                });
        }
        
    </script>
</body>
</html>
