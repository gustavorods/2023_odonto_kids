<meta charset="UTF-8">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap');

    *{
        font-family: 'Inter';
    }

    .cards-informativos-container{
        display: flex;
        justify-content: space-evenly;
        margin: 30px 0px;
    }

    .card-informativo {
        background-color: #43A0F6;
        width: 300px;
        color: white;
        padding: 25px;
        text-align: center;
        border-radius: 12px;
    }

    .card-informativo .titulo{
        font-size: 20pt;
        font-weight: 600;
    }

    .card-informativo .imagem img{
        width: 250px;
    }

    .card-informativo .paragrafo{
        margin-top: 10px;
        font-size: 12pt;
        font-weight: 500;
    }
</style>
<html>
    <div class="cards-informativos-container" id="cardsContainer">

    </div>
</html>

<script>

    function criarCard(titulo,imagem,paragrafo){
        const card = document.createElement('div')
        card.classList.add('card-informativo')

        card.innerHTML = `
            <div class="titulo">
                ${titulo}
            </div>
            <div class="imagem">
                <img src="${imagem}" alt="">
            </div>
            <div class="paragrafo">
                ${paragrafo}
            </div>            
        `

        return card
    }

    cardsContainer.appendChild(criarCard(
        "Escovar os dentes após cada refeição",
        "/2023_odonto_kids/assets/img/dashboard/escova-card.png",
        "Utilize uma escova de cerdas macias e pasta de dente com flúor. Escove por pelo menos 2 minutos, garantindo a limpeza de todas as superfícies dos dentes e da língua."
    ))

    cardsContainer.appendChild(criarCard(
        "Usar fio dental diariamente",
        "/2023_odonto_kids/assets/img/dashboard/fiodental-card.png",
        "O fio dental remove restos de alimentos e placa bacteriana que a escova não alcança, prevenindo cáries e doenças gengivais."
    ))

    cardsContainer.appendChild(criarCard(
        "Visitar o dentista regularmente",
        "/2023_odonto_kids/assets/img/dashboard/dentista-card.png",
        "Consultas periódicas, a cada 6 meses, são essenciais para identificar e tratar problemas dentários precocemente, além de realizar limpezas profissionais."
    ))

</script>