const botoes = document.querySelectorAll('.buttom');
    
botoes.forEach((botao) => {
    botao.addEventListener('click', () => {
        const link = botao.getAttribute('data-link');

        window.location.href = link;
    });
});