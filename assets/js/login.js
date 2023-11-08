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
const primeiros_inputs = document.querySelector(".input-first-info");
const segundo_inputs = document.querySelector(".input-second-info");
const area_btn_back_next = document.querySelector(".btn-form-back-next");
const btn_proximo = document.querySelector("#btn-form-next");
const btn_voltar = document.querySelector("#btn-form-back"); 

btn_proximo.addEventListener('click', () => {
    titulo_cadastrar.innerHTML = "Quase lá..."
    primeiros_inputs.style.display = "none";
    segundo_inputs.style.display = "block";
    btn_voltar.style.display = "inline"
})

btn_voltar.addEventListener('click', () => {
    titulo_cadastrar.innerHTML = "Cadastrar-se"
    primeiros_inputs.style.display = "block";
    segundo_inputs.style.display = "none";
    btn_voltar.style.display = "none"
})