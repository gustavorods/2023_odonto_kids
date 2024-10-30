<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap');

    *{
        font-family: 'Inter';
    }

    .card-vertical-detalhes-container{
        background-color: white;
        width: 400px;
        max-width: 90%;
        border-radius: 12px;
        padding: 10px 30px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
    }

    .card-vertical-detalhes-container .header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #000000;
    }

    .card-vertical-detalhes-container .header img{
        height: 25px;
        cursor: pointer;
    }

    .card-vertical-detalhes-container #dateHolder{
        font-size: 12pt;
        font-weight: normal;
    }

    .card-vertical-detalhes-container .calendario{
        margin: 14px 0px;
    }

    .card-vertical-detalhes-container .perfil-imagem img{
        height: 40px;
        width: 40px;
        object-fit: cover;
        border-radius: 100px;    
        border: 2px solid;
        margin-right: 4px;
        border-color: #0681F3;
    }

    .card-vertical-detalhes-container td, th{
        text-align: center;
    }

    .card-vertical-detalhes-container .bottom{
        display: flex;
        justify-content: space-between;
    }

    .card-vertical-detalhes-container .left-bottom{
        display: flex;
        align-items: center;
    }

    .card-vertical-detalhes-container .right-bottom{
        max-width: 140px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-vertical-detalhes-container .paciente{
        margin-left: 4px;
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-vertical-detalhes-container .nome-paciente, .titulo-tratamento{
        font-size: 11pt;
    }

    .card-vertical-detalhes-container .tratamento{
        font-size: 14pt;
        font-weight: bolder;
    }

    .card-vertical-detalhes-container .aviso-relatorio{
        text-align: center;
        color: #7b7b7b;
        font-weight: 600;
        font-size: 10pt;
        padding: 20px 30px;
    }
</style>
<html>
    <div class="card-vertical-detalhes-container">
        <div class="header">
            <h1>Detalhes</h1>
            <img src="/2023_odonto_kids/assets/img/dashboard/x-fechar-detalhes.png" alt="" onclick="">
        </div>

        <div class="calendario">
            <?php
                include './Untitled-2.html';
            ?>
        </div>

        <div class="bottom">
            <div class="left-bottom">
                <div class="perfil-imagem">
                    <img src="/2023_odonto_kids/assets/img/home/erick.jpeg" alt="">
                </div>
        
                <div class="paciente">
                    <div class="nome-paciente">
                        Paciente:
                    </div>
                    <div class="nome-perfil">
                        Lourenço Alvite
                    </div>
                </div>
            </div>
            <div class="right-bottom">
                <div class="titulo-tratamento">
                    Tratamento
                </div>
                <div class="tratamento">
                    Canal dentário
                </div>
            </div>
        </div>

        <div class="aviso-relatorio">
            Relatórios podem ser disponibilizados pelo médico após a consulta
        </div>
    </div>
</html>