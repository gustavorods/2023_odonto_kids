<style>
    .modal_detalhes_proxima_consulta {
        width: 350px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 0 20 20;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        display: none;
    }

    .modal_detalhes_proxima_consulta .modal_detalhes_proxima_consulta-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding: 13 0 10;
        border-bottom: 2px solid #000000;
    }

    .modal_detalhes_proxima_consulta .modal_detalhes_proxima_consulta-header h1 {
        font-size: 23px;
        margin: 0;
    }

    .modal_detalhes_proxima_consulta .close-button {
        background: none;
        border: none;
        font-size: 40px;
        line-height: 0;
        cursor: pointer;
    }

    .modal_detalhes_proxima_consulta .modal_detalhes_proxima_consulta-body .data-consulta {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }

    .modal_detalhes_proxima_consulta .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 15px;
    }

    .modal_detalhes_proxima_consulta .action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 3px 10px;
        background: #e8f4ff;
        border: 1px solid #007bff;
        border-radius: 8px;
        color: #007bff;
        font-size: 14px;
        cursor: pointer;
    }

    .modal_detalhes_proxima_consulta .action .icon img {
        height: 42px;
    }

    .modal_detalhes_proxima_consulta .status {
        font-size: 14px;
        margin-bottom: 10px;
    }

    .modal_detalhes_proxima_consulta .status-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .modal_detalhes_proxima_consulta .status-btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
    }

    .modal_detalhes_proxima_consulta .status-btn.realizada {
        background: #007bff;
        color: #fff;
    }

    .modal_detalhes_proxima_consulta .status-btn.ausente {
        background: #d3d3d3;
        color: #333;
    }

    .modal_detalhes_proxima_consulta .status-btn.cancelar {
        background: #ff4d4d;
        color: #fff;
    }

    .modal_detalhes_proxima_consulta .info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal_detalhes_proxima_consulta .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .modal_detalhes_proxima_consulta .info-text p {
        margin: 0;
        font-size: 14px;
    }

    .modal_detalhes_proxima_consulta .info-text a {
        color: #007bff;
        text-decoration: none;
        font-size: 12px;
    }
    
</style>
<html>
    <div class="modal_detalhes_proxima_consulta">
        <div class="modal_detalhes_proxima_consulta-header">
            <h1>Consulta</h1>
            <button class="close-button">×</button>
        </div>
        <div class="modal_detalhes_proxima_consulta-body">
            <p class="data-consulta"></p>

            <div class="action-buttons">
                <button class="action">
                    <span>Adicionar Relatório</span>
                    <i class="icon"><img src="../../img/dashboard_medico/olho.png" alt=""></i>
                </button>
                <button class="action">
                    <span>Adicionar Prontuário</span>
                    <i class="icon"><img src="../../img/dashboard_medico/olho.png" alt=""></i>
                </button>
            </div>

            <p class="status"><strong>Status: </strong><texto class="status-nome"></texto></p>

            <div class="status-buttons">
                <button class="status-btn realizada">Realizada</button>
                <button class="status-btn ausente">Ausente</button>
                <button class="status-btn cancelar">Cancelar Consulta</button>
            </div>

            <div class="info">
                <img src="user-avatar.png" alt="Foto do paciente" class="avatar">
                <div class="info-text">
                    <p><strong id="nome-dependente"></strong> <a href="#" data_id="" id="ver-mais">Ver Mais</a></p>
                    <p><strong>Tratamento: </strong><texto class="tratamento"></texto></p>
                </div>
            </div>
        </div>
    </div>
</html>
