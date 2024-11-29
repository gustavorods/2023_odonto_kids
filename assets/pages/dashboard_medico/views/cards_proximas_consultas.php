<style>    
    .card {
        width: 200px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.315);
        overflow: hidden;
        border: none;
        text-align: center;
    }
    
    .card-header {
        background-color: #007bff;
        color: #fff;
        font-size: 14px;
        border: none;
        font-weight: bold;
        font-size: 15pt;
        padding: 4px 0;
    }
    
    .card-body {
        padding: 0px 0px 14px 0px;
        background-color: #F6F6F6;
    }
    
    .card-body h2 {
        font-size: 16px;
        margin: 10px 0 5px;
        color: #333;
    }
    
    .card-body p {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }
    
    .card-body button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .card-body button:hover {
        background-color: #0056b3;
    }
</style>

<?php 
    $proximas_consulta = $listar_consulta->listarProximasConsultas();
?>

<html>
    <div id="cards-proximas-consultas">
    </div>

    <!-- Passando os dados do PHP para o JavaScript -->
    <script>
        // Passando o array PHP para o JavaScript
        const proximasConsultas = <?php echo json_encode($proximas_consulta); ?>;

        function formatarData(data) {
            const meses = [
                'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ];

            // Converte a string de data para um objeto Date
            const dataObj = new Date(data);

            // Garante que a hora seja configurada para meia-noite (00:00:00)
            dataObj.setHours(0, 0, 0, 0);

            // Adiciona 1 dia à data
            dataObj.setDate(dataObj.getDate() + 1);

            // Obtém o dia e o mês
            const dia = dataObj.getDate(); // Obtém o dia
            const mes = meses[dataObj.getMonth()]; // Obtém o mês (no array de meses)

            // Retorna a data no formato "22 DE OUTUBRO" (se o dia original era 21, por exemplo)
            return `${dia} DE ${mes.toUpperCase()}`;
        }


        // Função para criar o card dinamicamente
        function criarCard(dia, nome, tratamento, consulta_id) {
            // Montar o HTML do card com os parâmetros passados
            const dataFormatada = formatarData(dia);

            const cardHTML = `
                <div class="card">
                    <div class="card-header">
                        ${dataFormatada}
                    </div>
                    <div class="card-body">
                        <h2>${nome}</h2>
                        <p>${tratamento}</p>
                        <button class="detalhes_proxima_consulta" data_id="${consulta_id}">Detalhes</button>
                    </div>
                </div>
            `;

            // Encontrar a div com o id 'cards-proximas-consultas' e adicionar o novo card
            const cardsContainer = document.querySelector('#cards-proximas-consultas');
            cardsContainer.innerHTML += cardHTML;  // Adiciona o novo card dentro da div
        }

        // Criar cards para todas as consultas
        proximasConsultas.forEach(consulta => {
            criarCard(consulta.data, consulta.nome_dependente, consulta.nome_tratamento, consulta.id);
        });
    </script>
</html>
