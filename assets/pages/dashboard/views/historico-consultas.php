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

    .card-boy{
        margin: 20px 0px;
        border-radius: 15px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.315);
        padding: 10px 40px;
        background-color: #D2EAFF;
    }

    .card-girl{
        margin: 20px 0px;
        border-radius: 15px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.315);
        padding: 10px 40px;
        background-color: #FBD2FF;
    }

    .corpo-card-horizontal{
        margin-left: 10px;
    }

    .line-boy{
        background: #0681F3;
        width: 3px;
        height: 168px;
        position: absolute;
        transform: translate(-8px, -10px);
    }

    .line-girl{
        background: #E336DC;
        width: 3px;
        height: 168px;
        position: absolute;
        transform: translate(-8px, -10px);
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

    .card-boy .data-status .status{
        color: #2E81C9;
    }

    .card-girl .data-status .status{
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

    .card-girl .perfil-detalhes .botao-detalhes .detalhes-historico-consulta{
        background-color: #FF55F8;
    }

    .card-boy .perfil-detalhes .perfil-imagem img{
        border-color: #0681F3;
    }

    .card-girl .perfil-detalhes .perfil-imagem img{
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
        <div class="card-boy">
            <div class="line-boy"></div>

            <div class="corpo-card-horizontal">
                <div class="data-status">

                    <div class="data">
                        <p>26 de Setembro</p>
                    </div>
                    
                    <div class="status">
                        Realizado
                    </div>

                    
                </div>

                <div class="tipo-endereco">
                    
                    <div class="tipo-consulta">
                        <p>Canal dentário</p>
                    </div>
                    
                    <div class="endereco">
                        <img src="" alt="">
                        <p>Av. Pires do rio, 2043</p>
                    </div>
                </div>

                <div class="perfil-detalhes">
                    
                    <div class="left-container">
                        <div class="perfil-imagem">
                            <img src="/2023_odonto_kids/assets/img/home/erick.jpeg" alt="">
                        </div>

                        <div class="nome-perfil">
                            <p>Lourenço Alvite</p>
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

        <div class="card-girl">
            <div class="line-girl"></div>

            <div class="corpo-card-horizontal">
                <div class="data-status">

                    <div class="data">
                        <p>26 de Setembro</p>
                    </div>
                    
                    <div class="status">
                        Realizado
                    </div>

                    
                </div>

                <div class="tipo-endereco">
                    
                    <div class="tipo-consulta">
                        <p>Retirada de cárie</p>
                    </div>
                    
                    <div class="endereco">
                        <img src="" alt="">
                        <p>Av. Pires do rio, 2043</p>
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