/* Botões */
const btn_criar_conta = document.querySelector(".mobile-btn-NoAccount");
const btn_voltar_para_login = document.querySelector(".mobile-btn-form-BackToLogin");
const btn_proxim0 = document.querySelector(".mobile-btn-form-next");
const btn_v0ltar = document.querySelector(".mobile-btn-form-back");
const btn_Enviar = document.querySelector(".mobile-btn-form-send");

/* Áreas */
const card = document.querySelector(".card");
const primeirasInformacoes = document.querySelector(".mobile-input-first-info");
const segundasInformacoes = document.querySelector(".mobile-input-second-info");
const terceirasInformacoes = document.querySelector(".mobile-input-third-info");

/* Outros elementos */
const tituloAreaCadastrar = document.querySelector(".mobile-form-titulo")


// Botão de virar e desvirar o card
btn_criar_conta.addEventListener('click', () => {
    card.style.transform = "rotateY(-180deg)";
});
btn_voltar_para_login.addEventListener('click', () => {
    card.style.transform = "rotateY(0deg)";
});


// Botão de próximo
primeirasInformacoes.style.display = "block";
btn_proxim0.addEventListener('click', () => {
    if(primeirasInformacoes.style.display == "block"){
        tituloAreaCadastrar.innerHTML = "Quase lá...";
        primeirasInformacoes.style.display = 'none'
        segundasInformacoes.style.display = 'block'
        btn_voltar_para_login.style.display = 'none'
        btn_v0ltar.style.display = 'inline'
    } else if(segundasInformacoes.style.display == "block"){
        tituloAreaCadastrar.innerHTML = "Falta um teco assim 🤏"
        segundasInformacoes.style.display = 'none'
        terceirasInformacoes.style.display = 'block'
        btn_proxim0.style.display = 'none'
        btn_Enviar.style.display = 'inline'
    }
});

// Botão de voltar 
btn_v0ltar.addEventListener('click', () => {
    if(segundasInformacoes.style.display == "block"){
        tituloAreaCadastrar.innerHTML = "Cadastrar-se";
        primeirasInformacoes.style.display = 'block'
        segundasInformacoes.style.display = 'none'
        btn_voltar_para_login.style.display = 'inline'
        btn_v0ltar.style.display = 'none'
    } else if(terceirasInformacoes.style.display == "block"){
        tituloAreaCadastrar.innerHTML = "Quase lá...";
        segundasInformacoes.style.display = 'block'
        terceirasInformacoes.style.display = 'none'
        btn_Enviar.style.display = 'none'
        btn_proxim0.style.display = 'inline'

    }
    
})
