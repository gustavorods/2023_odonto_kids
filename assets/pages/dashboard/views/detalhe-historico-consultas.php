<style>
    .modal_detalhes_proxima_consulta {
        width: 350px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
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
        padding: 0 0 13px;
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
        padding: 3px 10px;
        background: #e8f4ff;
        border: 1px solid #007bff;
        border-radius: 8px;
        color: #007bff;
        font-size: 14px;
        cursor: pointer;
    }

    .paciente-detalhes{
        display: flex;
        flex-wrap: nowrap;
    }


    .paciente-detalhes span{
        margin-right: 5px;
        font-weight: 600;
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
            <div class="paciente-detalhes"><span>Paciente: </span><p class="paciente-consulta">a</p></div>

            <div class="action-buttons">
                <button class="action" id="prontuario">
                    <span>Prontuário</span>
                </button>
            </div>
            <div class="action-buttons">
                <button class="action" id="relatorio">
                    <span>Relatório</span>
                </button>
            </div>
        </div>
    </div>
</html>
