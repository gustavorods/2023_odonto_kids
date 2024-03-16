document.addEventListener("DOMContentLoaded", function() {
    var campoMensagem = document.querySelector(".input-mensagem");
    var botaoEnviar = document.getElementById("botaoEnviar");
    var campoNome = document.querySelector(".input");
    var campoTelefone = document.querySelector(".input-double");
    var campoObjetivo = document.querySelectorAll(".input-double")[1];

    campoMensagem.addEventListener("input", function() {
        if (campoMensagem.value.trim() !== "") {
            botaoEnviar.style.display = "block";
        } else {
            botaoEnviar.style.display = "none";
        }
    });

    botaoEnviar.addEventListener("click", function() {
        var camposVazios = [];
        
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

        if (camposVazios.length > 0) {

            // Alerta
            var mensagem;
            if (camposVazios.length === 1) {
                mensagem = "Opa! Parece que você esqueceu de preencher o seguinte campo: " + camposVazios[0];
            } else {
                mensagem = "Opa, parece que você esqueceu de preencher os seguintes campos: " + camposVazios.join(", ");
            }
            botaoEnviar.textContent = mensagem;
            botaoEnviar.style.backgroundColor = "#dc3545"; 
            botaoEnviar.style.pointerEvents = "none"; 
        } else {
            // Mensagem envio bem-sucedido
            botaoEnviar.innerHTML = "Mensagem enviada com sucesso!";
            botaoEnviar.style.backgroundColor = "#28a745"; 
            botaoEnviar.style.pointerEvents = "none"; 

            campoNome.readOnly = true;
            campoTelefone.readOnly = true;
            campoObjetivo.readOnly = true;
            campoMensagem.readOnly = true;
        }
    });

    // event listener
    [campoNome, campoTelefone, campoObjetivo, campoMensagem].forEach(function(campo) {
        campo.addEventListener("input", function() {
            var camposPreenchidos = true;
            [campoNome, campoTelefone, campoObjetivo, campoMensagem].forEach(function(campo) {
                if (campo.value.trim() === "") {
                    camposPreenchidos = false;
                }
            });

            if (camposPreenchidos) {
                // Todos os campos preenchidos = limpa a mensagem de alerta
                botaoEnviar.innerHTML = '<img class="img-arrow" src="../img/contato/right arrow.png" alt="">';
                botaoEnviar.style.backgroundColor = "#007bff";
                botaoEnviar.style.pointerEvents = "auto";
            }
        });
    });
});