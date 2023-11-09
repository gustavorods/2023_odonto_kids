// Rotação do toggle

const container = document.getElementById('container');
const registerBtn = document.getElementById('register')
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
})

// Formulario de cadastro (botão de próximo e voltar)
const titulo_cadastrar = document.querySelector("#titulo-cadastrar");

const primeiros_inputs = document.querySelector("#input-first-info");
const segundo_inputs = document.querySelector("#input-second-info");
const terceiro_inputs = document.querySelector("#input-three-info");

const area_btn_back_next = document.querySelector(".btn-form-back-next");
const btn_proximo = document.querySelector("#btn-form-next");
const btn_voltar = document.querySelector("#btn-form-back"); 
const btn_enviar = document.querySelector("#btn-form-send"); 



// Botão pra proxima parte do cadastro
primeiros_inputs.style.display = "block";
btn_proximo.addEventListener('click', () => {
    if(primeiros_inputs.style.display == "block") {
        titulo_cadastrar.innerHTML = "Quase lá...";
        primeiros_inputs.style.display = "none";
        segundo_inputs.style.display = "block";
        btn_voltar.style.display = "inline";
    }
    else if(segundo_inputs.style.display == "block") {
        titulo_cadastrar.innerHTML = "Falta um teco assim: 🤏";
        segundo_inputs.style.display = "none";
        terceiro_inputs.style.display = "block";
        btn_proximo.style.display = "none";
        btn_enviar.style.display = "inline";
    };
});

// Botão pra voltar
btn_voltar.addEventListener('click', () => {
    if(segundo_inputs.style.display == "block") {
        titulo_cadastrar.innerHTML = "Cadastrar-se";
        primeiros_inputs.style.display = "block";
        segundo_inputs.style.display = "none";
        btn_voltar.style.display = "none";
    }
    else if(terceiro_inputs.style.display == "block") {
        titulo_cadastrar.innerHTML = "Quase lá...";
        segundo_inputs.style.display = "block";
        terceiro_inputs.style.display = "none";
        btn_proximo.style.display = "inline";
        btn_enviar.style.display = "";
    };
});