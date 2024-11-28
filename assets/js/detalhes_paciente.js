function filtrarPorStatus(status, element) {
    // Obter o contêiner de cards da seção correta
    var cardsContainer = document.querySelector('.tratamentos .cards');

    // Obter todos os cards dentro do contêiner de cards
    var cards = cardsContainer.querySelectorAll('.card-tratamento');
    
    // Remover a classe 'ativo' de todos os botões de filtro
    var buttons = document.querySelectorAll('.filtros .filho');
    buttons.forEach(function(button) {
        button.classList.remove('ativo');
    });

    // Adicionar a classe 'ativo' ao botão clicado
    element.classList.add('ativo');    

    // Variável para verificar se algum card foi encontrado
    var found = false;

    // Mostrar todos os cards inicialmente
    cards.forEach(function(card) {
        card.style.display = 'block'; // Exibe todos os cards inicialmente
    });

    // Se não for o "Todos", ocultar os cards que não correspondem ao status selecionado
    if (status !== 'Todos') {
        cards.forEach(function(card) {
            var cardStatus = card.getAttribute('data-status'); // Pega o status do card
            if (cardStatus !== status) {
                card.style.display = 'none'; // Oculta o card que não corresponde
            } else {
                found = true; // Encontrou um card com o status correspondente
            }
        });
    } else {
        // Se o filtro for "Todos", mostramos todos os cards
        found = cards.length > 0;
    }

    // Exibir a mensagem de place_holder se nenhum card for encontrado
    var message = '';
    if (status !== 'Todos' && !found) {
        message = 'Nenhum tratamento ';
    } else if (status === 'Todos' && !found) {
        message = 'Esse paciente não possui nenhum tratamento';
    }

    // Adicionar ou remover a mensagem de place_holder
    var place_holder = cardsContainer.querySelector('.place_holder');

    if (message) {
        // Se houver uma mensagem, exiba ela
        if (!place_holder) {
            var place_holderDiv = document.createElement('div');
            place_holderDiv.classList.add('place_holder');
            place_holderDiv.textContent = message;
            cardsContainer.appendChild(place_holderDiv);
        } else {
            place_holder.textContent = message; // Atualiza a mensagem caso o place_holder já exista
        }
    } else {
        // Se algum card for encontrado, remova a mensagem de place_holder
        if (place_holder) {
            place_holder.remove();
        }
    }
}

// Ao carregar a página, aplicar o filtro "Todos" e garantir que o filtro "Todos" esteja ativo
document.addEventListener("DOMContentLoaded", function() {
    // Selecionar o botão de filtro "Todos"
    var todosButton = document.querySelector('.filtros .todos');
    
    // Garantir que o filtro "Todos" esteja ativo
    if (todosButton) {
        todosButton.classList.add('ativo');
        filtrarPorStatus('Todos', todosButton); // Chamar a função com o filtro "Todos"
    }
});
