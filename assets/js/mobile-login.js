const criar_conta = document.querySelector("#mobile-btn-SemContaAinda")
const card = document.querySelector(".card");

criar_conta.addEventListener('click', () => {
    card.style.transform = "rotateY(-180deg)";
})