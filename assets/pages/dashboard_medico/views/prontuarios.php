<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard_medico/dashboard_medico.css">
    <!-- <link rel="stylesheet" href="../css/servicos/servicos_responsivo.css"> -->
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Prontuário | Odontokids</title>

    <style>
        .container-divs {
            display: flex;
            justify-content: center;
            height: calc(100vh - 47px);
            align-items: center;
        }

        .navbar {
            background-color: #418CFC !important;
            height: auto !important;
        }          

        .container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            width: 100%;
            max-width: 1100px;
            justify-content: center;
            gap: 20px;
        }

        /* Área de Drop */
        .drop-area {
            width: 100%;
            max-width: 500px;
            height: 250px;
            border: 2px dashed #007bff;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #007bff;
            background-color: #ffffff;
            transition: background-color 0.3s, border 0.3s;
            padding: 20px;
        }

        .drop-area.hover {
            background-color: #f0f8ff;
            border-color: #0056b3;
        }

        input[type="file"] {
            display: none;
        }

        .drop-area p {
            margin: 0;
            font-size: 18px;
            color: #007bff;
            font-weight: bold;
        }

        /* Lista de Arquivos */
        #file-list {
            width: 100%;
            max-width: 500px;
            list-style: none;
            padding: 0;
            overflow-y: auto;
            height: 250px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }

        li {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            margin: 0;
            padding: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #333;
        }

        .file-name {
            font-size: 16px;
        }

        .remove-btn, .download-btn {
            color: #ff4d4d;
            cursor: pointer;
            font-size: 20px;
            transition: color 0.3s;
            margin-left: 10px;
        }

        .remove-btn:hover, .download-btn:hover {
            color: #d10000;
        }

        /* Modal de Confirmação de Exclusão */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            text-align: center;
        }

        .modal-content p {
            margin-bottom: 20px;
        }

        .modal button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .modal button:hover {
            background-color: #0056b3;
        }

        .modal button.cancel {
            background-color: #ccc;
        }

        .modal button.cancel:hover {
            background-color: #aaa;
        }

        .voltar{
            position: fixed;
            top:10px;
            left:10px;
            cursor: pointer;
        }

        .voltar img{
            height: 27px;
        }
    </style>
</head>
<body>
    <!--Navbar-->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <div id="div-logo">
                <h1>Odonto kids</h1>
                <img src="../../../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>
        </div>
    </nav>

    <div class="container-divs">
        <div class="container">
            <!-- Área de Drop -->
            <div class="drop-area" id="drop-area">
                <p>Arraste os arquivos aqui ou clique para selecionar</p>
                <input type="file" id="file-input" multiple accept=".pdf">
            </div>

            <!-- Lista de Arquivos -->
            <ul id="file-list">
                <!-- Lista de arquivos carregados será exibida aqui -->
            </ul>
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

    <div class="voltar" onclick="window.location.href='../dashboard_medico.php'">
        <img src="/2023_odonto_kids/assets/img/login/seta_voltar.svg" alt="">
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
        window.onload = function () {
            loadFiles();
        };

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

        // Função para exibir arquivos na lista
        function displayFile(file) {
            const listItem = document.createElement('li');
            listItem.id = `file-${file.name}`;
            listItem.innerHTML = `
                <span class="file-name">${file.name}</span>
                <span class="download-btn" onclick="downloadFile('${file.name}')">⬇️</span>
                <span class="remove-btn" onclick="confirmDelete('${file.name}')">🗑️</span>
            `;
            fileList.appendChild(listItem);
        }

        // Função para carregar os arquivos do localStorage e exibi-los
        function loadFiles() {
            let storedFiles = JSON.parse(localStorage.getItem('files')) || [];
            // Limpar a lista atual antes de recarregar
            fileList.innerHTML = '';
            storedFiles.forEach(file => {
                if (file) { // Certifique-se de que o arquivo não é `undefined` ou nulo
                    displayFile(file);
                }
            });
        }

        // Função para lidar com arquivos arrastados ou selecionados
        function handleFiles(files) {
            Array.from(files).forEach(file => {
                // Verifica se o arquivo é PDF
                if (file.type !== 'application/pdf') {
                    alert('Somente arquivos PDF são permitidos!');
                    return; // Ignora o arquivo se não for PDF
                }

                // Verifica se o arquivo já foi carregado (para não duplicar)
                let storedFiles = JSON.parse(localStorage.getItem('files')) || [];
                if (!storedFiles.some(f => f.name === file.name)) {
                    const fileInfo = { name: file.name, type: file.type, content: file }; // Armazenar informações do arquivo
                    storedFiles.push(fileInfo);
                    localStorage.setItem('files', JSON.stringify(storedFiles));
                    displayFile(fileInfo); // Exibe as informações do arquivo na tela
                }
            });
        }

        // Função para fazer o download do arquivo
        function downloadFile(fileName) {
            let storedFiles = JSON.parse(localStorage.getItem('files')) || [];
            const file = storedFiles.find(f => f.name === fileName);
            if (file) {
                const fileURL = URL.createObjectURL(file.content); // Cria um URL temporário para o arquivo
                const a = document.createElement('a');
                a.href = fileURL;
                a.download = file.name;
                a.click();
                URL.revokeObjectURL(fileURL); // Libera o URL temporário após o download
            }
        }

        // Função para confirmar exclusão de arquivo
        function confirmDelete(fileName) {
            fileToRemove = fileName;
            modal.style.display = 'flex';
        }

        // Função para cancelar a exclusão
        cancelDeleteBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            fileToRemove = null;
        });

        // Função para confirmar a exclusão de arquivo
        confirmDeleteBtn.addEventListener('click', () => {
            let storedFiles = JSON.parse(localStorage.getItem('files')) || [];
            // Filtra os arquivos, removendo o arquivo a ser excluído
            storedFiles = storedFiles.filter(file => file.name !== fileToRemove);
            localStorage.setItem('files', JSON.stringify(storedFiles));

            // Remove o arquivo da lista da interface
            const fileItem = document.getElementById(`file-${fileToRemove}`);
            if (fileItem) {
                fileItem.remove();
            }

            modal.style.display = 'none';
            fileToRemove = null;
        });
    </script>
</body>
</html>
