// Formulario de cadastro (botão de próximo e voltar)
const titulo_cadastrar = document.querySelector("#titulo-cadastrar");
const subtitulo_cadastrar = document.querySelector("#subtitulo_cadastrar");

const primeiros_inputs = document.querySelector("#input-first-info");
const segundo_inputs = document.querySelector("#input-second-info");
const terceiro_inputs = document.querySelector("#input-three-info");

const area_btn_back_next = document.querySelector(".div_btn_form_actions");
const btn_proximo = document.querySelector("#btn-form-next");
const btn_voltar = document.querySelector("#btn-form-back"); 
const btn_enviar = document.querySelector("#btn-form-send"); 



// Botão pra proxima parte do cadastro
primeiros_inputs.style.display = "flex";
btn_proximo.addEventListener('click', () => {
    if(primeiros_inputs.style.display == "flex") {
        titulo_cadastrar.innerHTML = "Quase lá...";
        subtitulo_cadastrar.innerHTML = "O primerio passo é o mais importante";
        primeiros_inputs.style.display = "none";
        segundo_inputs.style.display = "flex";
        btn_voltar.style.display = "inline";
    }
    else if(segundo_inputs.style.display == "flex") {
        titulo_cadastrar.innerHTML = "Falta um teco assim: 🤏";
        subtitulo_cadastrar.innerHTML = "Calma, falta só mais um pouquinho";
        segundo_inputs.style.display = "none";
        terceiro_inputs.style.display = "flex";
        btn_proximo.style.display = "none";
        btn_enviar.style.display = "inline";
    };
});

// Botão pra voltar
btn_voltar.addEventListener('click', () => {
    if(segundo_inputs.style.display == "flex") {
        titulo_cadastrar.innerHTML = "Cadastrar-se";
        subtitulo_cadastrar.innerHTML = "O sorriso do seu filho começa aqui!";
        primeiros_inputs.style.display = "flex";
        segundo_inputs.style.display = "none";
        btn_voltar.style.display = "none";
    }
    else if(terceiro_inputs.style.display == "flex") {
        titulo_cadastrar.innerHTML = "Quase lá...";
        subtitulo_cadastrar.innerHTML = "O primerio passo é o mais importante";
        segundo_inputs.style.display = "flex";
        terceiro_inputs.style.display = "none";
        btn_proximo.style.display = "inline";
        btn_enviar.style.display = "";
    };
});