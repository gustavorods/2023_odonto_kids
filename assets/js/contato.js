// Seleciona os elementos do formulário
var campoMensagem = document.querySelector(".input-mensagem");
var botaoEnviar = document.getElementById("botaoEnviar");
var campoNome = document.querySelector(".input");
var campoTelefone = document.querySelectorAll(".input-double")[0];
var campoObjetivo = document.querySelectorAll(".input-double")[1];

// Adiciona um evento de input no campo de mensagem para controlar a visibilidade do botão de enviar
campoMensagem.addEventListener("input", function() {
    // Verifica se o campo de mensagem não está vazio
    if (campoMensagem.value.trim() !== "") {
        botaoEnviar.style.display = "block";  // Exibe o botão de enviar
    } else {
        botaoEnviar.style.display = "none";  // Esconde o botão de enviar
    }
});

// Adiciona um evento de click no botão de enviar
botaoEnviar.addEventListener("click", function() {
    var camposVazios = [];
    
    // Verifica se cada campo obrigatório está preenchido, caso contrário, adiciona ao array de campos vazios
    if (campoNome.value.trim() === "") {
        camposVazios.push("Nome");
    }
    
    if (campoTelefone.value.trim() === "") {
        camposVazios.push("Telefone");
    }
    
    if (campoObjetivo.value.trim() === "") {
        camposVazios.push("Objetivo");
    }
    
    if (campoMensagem.value.trim() === "") {
        camposVazios.push("Mensagem");
    }

    // Se houver campos vazios, exibe uma mensagem de alerta
    if (camposVazios.length > 0) {
        event.preventDefault();
        var mensagem;
        if (camposVazios.length === 1) {
            mensagem = "Opa! Parece que você esqueceu de preencher o seguinte campo: " + camposVazios[0];
        } else {
            mensagem = "Opa, parece que você esqueceu de preencher os seguintes campos: " + camposVazios.join(", ");
        }
        botaoEnviar.textContent = mensagem;
        botaoEnviar.style.backgroundColor = "#dc3545";  // Muda a cor de fundo para vermelho
        botaoEnviar.style.pointerEvents = "none";  // Desabilita o botão de enviar
    } else {
        // Se todos os campos estiverem preenchidos, exibe uma mensagem de sucesso
        botaoEnviar.innerHTML = "Mensagem enviada com sucesso!";
        botaoEnviar.style.backgroundColor = "#28a745";  // Muda a cor de fundo para verde
        botaoEnviar.style.pointerEvents = "none";  // Desabilita o botão de enviar

        // Após 4 segundos, esconde o botão de enviar e redefine seu estado
        setTimeout(() => {
            botaoEnviar.style.display = "none"; 
            botaoEnviar.innerHTML = '<img class="img-arrow" src="../img/contato/right arrow.png" alt="">';
            botaoEnviar.style.backgroundColor = "#007bff";
            botaoEnviar.style.pointerEvents = "auto";
        }, 4000); // 4000 milissegundos = 4 segundos

        // Limpa os campos do formulário
        campoNome.value = "";   
        campoTelefone.value = "";
        campoObjetivo.value = "";
        campoMensagem.value = "";
    }
});

// Adiciona um evento de input em cada campo para atualizar o estado do botão de enviar
[campoNome, campoTelefone, campoObjetivo, campoMensagem].forEach(function(campo) {
    campo.addEventListener("input", function() {
        var camposPreenchidos = true;
        
        // Verifica se todos os campos estão preenchidos
        [campoNome, campoTelefone, campoObjetivo, campoMensagem].forEach(function(campo) {
            if (campo.value.trim() === "") {
                camposPreenchidos = false;
            }
        });

        // Se todos os campos estiverem preenchidos, redefine a mensagem de alerta e reabilita o botão de enviar
        if (camposPreenchidos) {
            botaoEnviar.innerHTML = '<img class="img-arrow" src="../img/contato/right arrow.png" alt="">';
            botaoEnviar.style.backgroundColor = "#007bff";
            botaoEnviar.style.pointerEvents = "auto";
        }
    });
});
