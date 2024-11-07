let resultados = [
    'Selante dentário para prevenção de cáries',
    'Fluoretação para fortalecimento do esmalte',
    'Restauração dentária em dentes de leite',
    'Tratamento de canal em dentes decíduos',
    'Extração de dentes de leite quando necessário',
    'Correção ortodôntica para alinhamento dos dentes',
    'Cuidados com traumas dentários em crianças',
    'Orientação para uma boa higiene bucal desde cedo',
];

const caixaDeTexto = document.getElementById('input-box');
const resultadosBox = document.querySelector('.resultados-pesquisa');

caixaDeTexto.onkeyup = function() {
    let resultado = [];
    let input = caixaDeTexto.value;

    // Se a entrada estiver vazia, esconder a caixa de resultados
    if(input.length === 0) {
        resultadosBox.style.display = 'none';
    } else {
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
}

function mostrarResultados(result) {
    // Converte o array de resultados em uma lista de itens HTML
    const conteudo = result.map((lista) => {
        return "<li onclick=\"pegarTratamento(this)\">" + lista + "</li>";
    }).join('');  // Junta as strings para evitar múltiplos DOM updates

    // Exibe os resultados no elemento
    resultadosBox.innerHTML = "<ul>" + conteudo + "</ul>";
}

function pegarTratamento(lista) {
    // Atribui o valor do item clicado ao campo de texto
    caixaDeTexto.value = lista.innerHTML;

    // Esconde a caixa de resultados após a seleção
    resultadosBox.style.display = 'none';
}
