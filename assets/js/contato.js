const botoes = document.querySelectorAll('.buttom');
    
botoes.forEach((botao) => {
    botao.addEventListener('click', () => {
        const link = botao.getAttribute('data-link');

        window.location.href = link;
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var campoMensagem = document.querySelector(".input-mensagem");
    var botaoEnviar = document.getElementById("botaoEnviar");
    var campoNome = document.querySelector(".input");
    var campoTelefone = document.querySelector(".input-double");
    var campoObjetivo = document.querySelector(".input-double");
    var campoMensagem = document.querySelector(".input-mensagem");
    var botaoEnviar = document.getElementById("botaoEnviar");

    campoMensagem.addEventListener("input", function() {
        if (campoMensagem.value.trim() !== "") {
            botaoEnviar.style.display = "block";
        } else {
            botaoEnviar.style.display = "none";
        }
    });

    botaoEnviar.addEventListener("click", function() {
        if (campoNome.value.trim() === "" || campoTelefone.value.trim() === "" || campoObjetivo.value.trim() === "" || campoMensagem.value.trim() === "") {
            alert("Por favor, preencha todos os campos antes de enviar.");
        } else {
          
        }
    });
});