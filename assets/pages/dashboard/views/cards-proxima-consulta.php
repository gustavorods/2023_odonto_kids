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

    .card-consulta-vertical .detalhes{
        margin: 7px 0px;
        background-color: #0681F3;
        color: white;
        font-size: 10pt;
        padding: 8px 29px;
        border-radius: 12px;
    }
</style>

<?php
    $consultasOrganizadas = $metodos_dashboard->listar_proximas_consultas();
?>

<script>
    // Passando a variável PHP para o JavaScript
    const consultas = <?php echo json_encode($consultasOrganizadas); ?>;

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
                <a href="">
                    <button class="detalhes" data-id="${id_consulta}">Detalhes</button>
                </a>
            </div>  
        `;

        return card;
    }

    // Iterar sobre as consultasOrganizadas e criar os cartões
    consultas.forEach(consulta => {
        const card = criarCardsProximaConsulta(
            consulta.mes,
            consulta.dia_da_semana,
            consulta.dia_do_mes,
            consulta.nome_dependente,
            consulta.id_consulta
        );

        // Adiciona o card ao contêiner
        document.getElementById('cards_proximasconsultas').appendChild(card);
    });
</script>