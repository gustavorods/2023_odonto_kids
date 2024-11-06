function blockletras(event) {
    //CAMPO ESTOQUE - BLOQUEIA lETRAS
    let keypress = event.keyCode || event.which;
    if(keypress>=48 && keypress<=57)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/*passagem carrosel
const cards = document.querySelector('.cards');
const next = document.querySelector('.next');
const prev = document.querySelector('.prev');
let currentIndex = 0;

// Próximo card
next.addEventListener('click', () => {
currentIndex = (currentIndex + 1) % cards.children.length;
updateCarousel();
});

// Card anterior
prev.addEventListener('click', () => {
currentIndex = (currentIndex - 1 + cards.children.length) % cards.children.length;
updateCarousel();
});

// Atualiza a posição do carrossel
function updateCarousel() {
const cardWidth = cards.children[0].offsetWidth;
cards.style.transform = `translateX(-${currentIndex * (cardWidth + 20)}px)`;
}*/


// Abrindo o modal quando o botão "Cadastrar Paciente" for clicado
document.getElementById('btncadastrarDp').addEventListener('click', function() {
document.getElementById('form-container').classList.add('show');
});

// Fechando o modal quando o botão de fechar (x) for clicado
document.querySelector('.close-btn').addEventListener('click', function() {
document.getElementById('form-container').classList.remove('show');
});

// Fechando o modal clicando fora do formulário (no fundo escuro)
window.addEventListener('click', function(event) {
if (event.target == document.getElementById('form-container')) {
    document.getElementById('form-container').classList.remove('show');
}
});
    function blockletras(event) {
        //CAMPO ESTOQUE - BLOQUEIA lETRAS
        let keypress = event.keyCode || event.which;
        if(keypress>=48 && keypress<=57)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*passagem carrosel
const cards = document.querySelector('.cards');
const next = document.querySelector('.next');
const prev = document.querySelector('.prev');
let currentIndex = 0;

// Próximo card
next.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % cards.children.length;
    updateCarousel();
});

// Card anterior
prev.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + cards.children.length) % cards.children.length;
    updateCarousel();
});

// Atualiza a posição do carrossel
function updateCarousel() {
    const cardWidth = cards.children[0].offsetWidth;
    cards.style.transform = `translateX(-${currentIndex * (cardWidth + 20)}px)`;
}*/


// Abrindo o modal quando o botão "Cadastrar Paciente" for clicado
document.getElementById('btncadastrarDp').addEventListener('click', function() {
    document.getElementById('form-container').classList.add('show');
});

// Fechando o modal quando o botão de fechar (x) for clicado
document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('form-container').classList.remove('show');
});

// Fechando o modal clicando fora do formulário (no fundo escuro)
window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('form-container')) {
        document.getElementById('form-container').classList.remove('show');
    }
});

// Função mascara e limitação de deigitos campo CPF
document.getElementById('cpf').addEventListener('input', function (e) {
    let value = e.target.value;
    value = value.replace(/\D/g, ''); // Remove qualquer caractere que não seja número

    // Aplica a máscara de CPF (xxx.xxx.xxx-xx)
    if (value.length > 3 && value.length <= 6) {
        value = value.replace(/(\d{3})(\d+)/, '$1.$2');
    } else if (value.length > 6 && value.length <= 9) {
        value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1.$2.$3');
    } else if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    }

    e.target.value = value;
});    

// Função para permitir apenas letras campo nome
function apenasLetras(e) {
    const char = String.fromCharCode(e.keyCode);
    if (/[^a-zA-Zá-úÁ-Ú\s]/.test(char)) {
        return false;
    }
    return true;
}

// Aplicar máscara de celular
document.getElementById('telEmerg').addEventListener('input', function (e) {
    let value = e.target.value;
    value = value.replace(/\D/g, ''); // Remove qualquer caractere que não seja número

    // Aplica a máscara (00) 00000-0000
    if (value.length > 2 && value.length <= 7) {
        value = value.replace(/(\d{2})(\d+)/, '($1) $2');
    } else if (value.length > 7) {
        value = value.replace(/(\d{2})(\d{5})(\d+)/, '($1) $2-$3');
    }

    e.target.value = value;
});
