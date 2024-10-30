const botaoDetalhes = document.querySelectorAll('.botao-detalhes-proxima-consulta');
const detalhesProximaConsulta = document.querySelector('.detalhes-proxima-consulta');
const fade = document.getElementById("fade");

// Adiciona o evento de clique a cada elemento
botaoDetalhes.forEach(botao => {
    botao.addEventListener('click', function(event) {
        event.preventDefault();
        detalhesProximaConsulta.style.display = "block"
        fade.style.display = "block"
        fade.style.backgroundColor = "rgba(0, 0, 0, 0.6)"
        createCalendar(date, 10)
    });
});

const fechar = document.querySelector(".fechar-detalhe-proxima-consulta");

fechar.addEventListener('click', function(){
    fecharModal();
});

// Adiciona evento de clique no fade para fechar o modal
fade.addEventListener('click', function(event) {
    // Verifica se o clique foi fora do modal
    if (event.target === fade) {
        fecharModal();
    }
});

// Função para fechar o modal
function fecharModal() {
    detalhesProximaConsulta.style.display = "none";
    fade.style.display = "none";
    fade.style.backgroundColor = "rgba(0, 0, 0, 0.0)";
}


