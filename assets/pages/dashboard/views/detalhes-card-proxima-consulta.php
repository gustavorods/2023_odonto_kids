<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap');

    *{
        font-family: 'Inter';
    }

    .detalhes-proxima-consulta{
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
        display: none;
    }

    .detalhes-proxima-consulta .header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #000000;
    }

    .detalhes-proxima-consulta .header span{
        font-size: 31pt;
        cursor: pointer;
    }

    .detalhes-proxima-consulta #dateHolder{
        font-size: 12pt;
        font-weight: normal;
    }

    .detalhes-proxima-consulta .calendario{
        margin: 14px 0px;
    }

    .detalhes-proxima-consulta .dia-consulta{
        margin-bottom: 5px;
    }

    .detalhes-proxima-consulta .perfil-imagem img{
        height: 40px;
        width: 40px;
        object-fit: cover;
        border-radius: 100px;    
        border: 2px solid;
        margin-right: 4px;
        border-color: #0681F3;
    }

    .detalhes-proxima-consulta td, th{
        text-align: center;
    }

    .detalhes-proxima-consulta .bottom{
        display: flex;
        justify-content: space-between;
    }

    .detalhes-proxima-consulta .left-bottom{
        display: flex;
        align-items: center;
    }

    .detalhes-proxima-consulta .right-bottom{
        max-width: max-content;
        border-left: 1px solid;
        padding-left: 13px;
        min-width: 151px;
    }

    .detalhes-proxima-consulta .paciente{
        margin-left: 4px;
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .detalhes-proxima-consulta .nome-paciente, .titulo-tratamento{
        font-size: 11pt;
    }

    .detalhes-proxima-consulta .tratamento{
        font-size: 11pt;
        font-weight: bolder;
    }

    .detalhes-proxima-consulta .aviso-relatorio{
        text-align: center;
        color: #7b7b7b;
        font-weight: 600;
        font-size: 10pt;
        padding: 20px 30px;
    }

    .detalhes-proxima-consulta .marked{
        border: 3px solid #447caf;
    }
</style>
<html>
    <div class="detalhes-proxima-consulta" id="modal">
        <div class="header">
            <h1>Detalhes</h1>
            <span class="fechar-detalhe-proxima-consulta">&times;</span>
        </div>

        <div class="calendario">
            <p class="dia-consulta"></p>
            <?php
                include './views/calendario.php';
            ?>
        </div>

        <div class="bottom">
            <div class="left-bottom">
                <div class="perfil-imagem">
                    <img src="" alt="">
                </div>
        
                <div class="paciente">
                    <div class="nome-paciente">
                        Paciente:
                    </div>
                    <div class="nome-perfil">
                    </div>
                </div>
            </div>
            <div class="right-bottom">
                <div class="titulo-tratamento">
                    Tratamento
                </div>
                <div class="tratamento">
                </div>
            </div>
        </div>

        <div class="aviso-relatorio">
            Relatórios podem ser disponibilizados pelo médico após a consulta
        </div>
    </div>
</html>