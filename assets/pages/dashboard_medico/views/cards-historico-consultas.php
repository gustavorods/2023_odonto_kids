<style>
    .historico-consulta{
        margin: 30px 50px;
    }

    .historico-consulta h1{
        font-weight: 1000;
        font-size: 16pt;
        margin: 20px 0px;
    }

    .cards-historico-consulta{
        width: 700px;
    }

    .girl{
        background-color: #FBD2FF;
    }

    .boy{
        background-color: #D2EAFF;
    }

    .card-historico{
        margin: 20px 0px;
        border-radius: 8px;
        border: 0px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.315);
        padding: 10px 40px;
    }

    .corpo-card-historico{
        margin-left: 10px;
    }

    .line{
        width: 3px;
        height: 144px;
        position: absolute;
        transform: translate(-8px, -10px);
    }

    .boy .line{
        background: #0681F3;
    }

    .girl .line{
        background: #E336DC;
    }

    .data-status{
        display: flex;
        justify-content: space-between;
        font-weight: 1000;
        font-size: 13pt;
    }

    .data-status .data{
        color: #636363;
    }

    .boy .data-status .status{
        color: #2E81C9;
    }

    .girl .data-status .status{
        color: #FF55F8;
    }

    .left-container{
        display: flex;
        align-items: baseline;
    }

    .tipo-consulta{
        font-weight: 1000;
        font-size: 15pt;
        margin-top: 3px;
        line-height: 2px;
    }

    .tipo-endereco .endereco{
        font-size: 12pt;
        font-weight: bold;
        color: #636363;
    }

    .perfil-detalhes{
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
    }

    .perfil-detalhes .perfil-imagem img{
        height: 40px;
        width: 40px;
        object-fit: cover;
        border-radius: 100px;    
        border: 2px solid;
        margin-right: 4px;
    }

    .perfil-detalhes .botao-detalhes .detalhes-historico-consulta{
        background-color: #0681F3;
        padding: 8px 20px;
        border-radius: 8px;
        color: white;
    }

    .girl .perfil-detalhes .botao-detalhes .detalhes-historico-consulta{
        background-color: #FF55F8;
    }

    .boy .perfil-detalhes .botao-detalhes .detalhes-historico-consulta{
        background-color: #0681F3;
    }

    .boy .perfil-detalhes .perfil-imagem img{
        border-color: #0681F3;
    }

    .girl .perfil-detalhes .perfil-imagem img{
        border-color: #E336DC;
    }

    .nome-perfil{
        font-size: 12pt;
        font-weight: bold;
        color: #636363;
    }
    
    .aviso-cancelada {
        display: none;
    }

    .cancelada-ausente {
        background-color: #ffd4d4;
    }

    .cancelada-ausente .status {
        color: #8b0000;
    }

    .cancelada-ausente .line {
        background: red;
    }

    .cancelada-ausente .aviso-cancelada .cancelada {
        display: block;
        line-height: 0px;
        color: #9b0000;
        font-size: 11pt;
    }

    .cancelada-ausente .detalhes-historico-consulta {
        display: none;
    }    

    .aviso-ausente {
        display: none;
    }   

    .botao-detalhes h1{
        display: none;
    }
    
    .cancelada-ausente .botao-detalhes h1 {
        line-height: 0px;
        color: #8b0000;
        font-size: 11pt;
        display: block;
    }
</style>

<?php
    $historicoConsultasOrganizadas = $listar_consulta->listar_historico_consultas();
    // var_dump($historicoConsultasOrganizadas);
?>


<script>
    // Passando a variável PHP para o JavaScript
    const historicoConsultas = <?php echo json_encode($historicoConsultasOrganizadas); ?>;
    // console.log(historicoConsultas);

    function criarCardsHistoricoConsulta(dia, mes, horario, status, tratamento, dependente, sexo, id) {
        const card = document.createElement('div');
        card.classList.add('card-historico');

        // Variável para a mensagem de aviso
        let avisoMessage = "";

        switch (status) {
            case "Realizada":
                if (sexo === "Masculino") {
                    card.classList.add('boy');
                } else if (sexo === "Feminino") {
                    card.classList.add('girl');
                }
                break;
            default:
                card.classList.add('cancelada-ausente');
                if(status==="Cancelada"){
                    avisoMessage = "";
                }
                else{
                    avisoMessage = "Paciente não compareceu à consulta";
                }
                break;
        }

        card.innerHTML = `
            <div class="line"></div>

            <div class="corpo-card-historico">
                <div class="data-status">
                    <div class="data">
                        <p>${dia} de ${mes} às ${horario}</p>
                    </div>
                    
                    <div class="status">
                        ${status}
                    </div>
                </div>

                <div class="tipo-consulta">
                    <div>
                        <p>${tratamento}</p>
                    </div>
                </div>

                <div class="perfil-detalhes">
                    <div class="left-container">
                        <div class="perfil-imagem">
                            <img src="/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png" alt="">
                        </div>

                        <div class="nome-perfil">
                            <p>${dependente}</p>
                        </div>
                    </div>

                    <div class="botao-detalhes">
                        <h1 class="aviso">${avisoMessage}</h1> <!-- Mensagem de aviso aqui -->
                        <button class="detalhes-historico-consulta " data_id="${id}">
                            Detalhes
                        </button>
                    </div>
                </div>
            </div>
        `;

        return card;
    }

    // Iterar sobre as consultasOrganizadas e criar os cartões
    historicoConsultas.forEach(historicoConsulta => {
        // console.log('Depurando historicoConsulta:', historicoConsulta);
        const card = criarCardsHistoricoConsulta(
            historicoConsulta.dia,
            historicoConsulta.mes,
            historicoConsulta.horario,
            historicoConsulta.status,
            historicoConsulta.tratamento,
            historicoConsulta.dependente,
            historicoConsulta.sexo,
            historicoConsulta.id
        );

        // Adiciona o card ao contêiner
        document.querySelector('.cards-historico-consulta').appendChild(card);
    });    

    // document.querySelector('.cards-container').appendChild(
    //     criarCardsHistoricoConsulta(
    //         "26 de Setembro", // data
    //         "14:00",          // hora
    //         "Retirada de cárie", // tratamento
    //         "Valentina",      // nome do dependente
    //         "Masculino",      // sexo do dependente
    //         "Realizada",      // status da consulta   
    //         1
    //     )
    // )

</script>