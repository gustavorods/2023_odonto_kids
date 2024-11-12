let resultados = [];  // Inicializa o array vazio

// Carregar os tratamentos inicialmente
window.onload = function() {
    // Fazer a requisição AJAX para buscar os tratamentos
    fetch('/2023_odonto_kids/assets/php/handlers/escolha_tratamento/buscarTratamentos.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Verifica o que foi retornado pelo PHP
            resultados = data; // Preenche o array 'resultados' com os dados do PHP
        })
        .catch(error => {
            console.error('Erro ao carregar tratamentos:', error);
        });
};

const caixaDeTexto = document.getElementById('input-box');
const resultadosBox = document.querySelector('.resultados-pesquisa');

caixaDeTexto.onkeyup = function() {
    let resultado = [];
    let input = caixaDeTexto.value;

    // Filtra os resultados
    resultado = resultados.filter((keyword) => {
        return keyword.toLowerCase().includes(input.toLowerCase());
    });

    // Chama a função para mostrar os resultados filtrados
    mostrarResultados(resultado);

    if(!resultado.length){
        resultadosBox.style.display = 'none';
    }
    else{
        // Exibe a caixa de resultados
        resultadosBox.style.display = 'block';            
    }
}

// Função para exibir os resultados no DOM
function mostrarResultados(result) {
    // Converte o array de resultados em uma lista de itens HTML
    const conteudo = result.map((lista) => {
        return "<li onclick=\"pegarTratamento(this)\">" + lista + "</li>";
    }).join('');  // Junta as strings para evitar múltiplos DOM updates

    // Exibe os resultados no elemento
    resultadosBox.innerHTML = "<ul>" + conteudo + "</ul>";
}

// Função para pegar o item clicado
function pegarTratamento(lista) {
    // Atribui o valor do item clicado ao campo de texto
    caixaDeTexto.value = lista.innerHTML;

    // Esconde a caixa de resultados após a seleção
    resultadosBox.style.display = 'none';
}

// Adiciona o evento de pressionamento da tecla 'Enter'
caixaDeTexto.addEventListener('keyup', function(event) {
    // Verifica se a tecla pressionada é 'Enter' (código 13)
    if (event.key === 'Enter') {
        // Verifica se há resultados
        let resultado = resultados.filter((keyword) => {
            return keyword.toLowerCase().includes(caixaDeTexto.value.toLowerCase());
        });

        // Se houver resultados, preenche o campo de texto com o primeiro resultado
        if (resultado.length > 0) {
            caixaDeTexto.value = resultado[0];  // Atribui o primeiro resultado
            resultadosBox.style.display = 'none';  // Esconde a caixa de resultados
        }
    }
});

// Evento de foco no campo de entrada (quando o usuário clica no campo)
caixaDeTexto.addEventListener('focus', function() {
    // Verifica se o campo de entrada está vazio
    if (caixaDeTexto.value === '') {
        // Se o campo estiver vazio, exibe todos os tratamentos
        mostrarResultados(resultados);
        resultadosBox.style.display = 'block';  // Exibe a caixa de resultados
    }
});

// Evento 'blur' para esconder a caixa de resultados quando o campo perder o foco
caixaDeTexto.addEventListener('blur', function() {
    // Verifica se o clique foi fora da caixa de resultados ou no campo de texto
    setTimeout(() => {
        if (!resultadosBox.contains(document.activeElement)) {
            resultadosBox.style.display = 'none';  // Esconde a caixa de resultados
        }
    }, 100);
});

document.getElementById('botao-pesquisar').addEventListener("click", function(){
    if(caixaDeTexto.value == ""){
        alert("Escreva o tratamento desejado.")
    }
    else{
        
    }
});