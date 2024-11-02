<style>
    .historico-consulta{
        margin: 30px 50px;
    }

    .historico-consulta h1{
        font-weight: 1000;
        font-size: 16pt;
        margin: 20px 0px;
    }

    .cards-container{
        width: 700px;
    }

    .girl{
        background-color: #FBD2FF;
    }

    .boy{
        background-color: #D2EAFF;
    }

    .card{
        margin: 20px 0px;
        border-radius: 15px;
        border: 0px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.315);
        padding: 10px 40px;
    }

    .corpo-card-horizontal{
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

    .tipo-endereco{
        margin-top: 3px;
        line-height: 2px;
    }


    .tipo-endereco .tipo-consulta{
        font-weight: 1000;
        font-size: 15pt;
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
</style>

<html>
    <div class="historico-consulta">

    <h1>HISTÓRICO DE CONSULTAS:</h1>

    <div class="cards-container">
        
        <div class="card girl">
            <div class="line"></div>

            <div class="corpo-card-horizontal">
                <div class="data-status">

                    <div class="data">
                        <p>26 de Setembro 14</p>
                    </div>
                    
                    <div class="status">
                        Realizado
                    </div>
                </div>

                <div class="tipo-endereco">
                    
                    <div class="tipo-consulta">
                        <p>Retirada de cárie</p>
                    </div>

                </div>

                <div class="perfil-detalhes">
                    
                    <div class="left-container">
                        <div class="perfil-imagem">
                            <img src="/2023_odonto_kids/assets/img/home/carolina.jpg" alt="">
                        </div>

                        <div class="nome-perfil">
                            <p>Valentina</p>
                        </div>
                    </div>

                    <div class="botao-detalhes">
                        <a href="">
                            <button class="detalhes-historico-consulta">
                                Detalhes
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</html>