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
                    <button class="detalhes">Detalhes</button>
                </a>
                <div hidden id="id_consulta">${id_consulta}</div>
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