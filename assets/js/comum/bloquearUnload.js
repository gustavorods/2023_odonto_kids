let allowUnload = false; // Variável de controle para permitir o unload sem a mensagem de confirmação

// Adiciona o evento `beforeunload` para pedir confirmação
window.addEventListener('beforeunload', function (event) {
    if (!allowUnload) {
        event.preventDefault();
        event.returnValue = ''; // Exibe a mensagem padrão do navegador
    }
});