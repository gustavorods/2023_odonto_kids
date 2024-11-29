<style>
    .card-consulta-vertical{
        width: 230px;
        min-width: 230px;
        background-color: #F6F6F6;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.315);
        border-radius: 15px;
        text-align: center;
        margin-right: 30px;
    }

    .card-consulta-vertical .cabecalho{
        background-color: #0681F3;
        padding: 10px;
        text-align: center;
        align-items: center;
        border-radius: 15px 15px 0px 0px;

    }

    .card-consulta-vertical .mes{
        font-size: 18pt;
        color: white;
        margin: 0px;
    }

    .card-consulta-vertical .corpo{
        padding: 10px;
    }

    .card-consulta-vertical .dia-semana{
        font-size: 12pt;
    }

    .card-consulta-vertical .dia-mes{
        font-size: 60pt;
        font-weight: bolder;
    }

    .card-consulta-vertical .paciente{
        font-size: 12pt;
    }

    .card-consulta-vertical .botao-detalhes-proxima-consulta{
        margin: 7px 0px;
        background-color: #0681F3;
        color: white;
        font-size: 10pt;
        padding: 8px 29px;
        border-radius: 12px;
    }
</style>

<?php
    $proximasConsultasOrganizadas = $metodos_dashboard->listar_proximas_consultas();
?>

<script>
    // Passando a variável PHP para o JavaScript
    const proximasConsultas = <?php echo json_encode($proximasConsultasOrganizadas); ?>;

    function criarCardsProximaConsulta(mes, dia_semana, dia_mes, paciente, id_consulta) {
        const card = document.createElement('div');
        card.classList.add('card-consulta-vertical');

        card.innerHTML = `
            <div class="cabecalho">
                <h1 class="mes">${mes}</h1>
            </div>
            <div class="corpo">
                <h3 class="dia-semana">${dia_semana}</h3>
                <h1 class="dia-mes">${dia_mes}</h1>
                <h2 class="paciente">${paciente}</h2>
                <button class="botao-detalhes-proxima-consulta" data-id="${id_consulta}">Detalhes</button>
            </div>  
        `;

        return card;
    }

    // Iterar sobre as consultasOrganizadas e criar os cartões
    proximasConsultas.forEach(proximaConsulta => {
        const card = criarCardsProximaConsulta(
            proximaConsulta.mes,
            proximaConsulta.dia_da_semana,
            proximaConsulta.dia_do_mes,
            proximaConsulta.nome_dependente,
            proximaConsulta.id_consulta
        );

        // Adiciona o card ao contêiner
        document.querySelector('.cards-proximas-consultas').appendChild(card);
    });
</script>