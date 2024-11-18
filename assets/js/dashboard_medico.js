const modal_detalhes_proxima_consulta = document.querySelector('.modal_detalhes_proxima_consulta');
const botao_detalhes_proxima_consulta = document.querySelectorAll('.detalhes_proxima_consulta');
const fade = document.getElementById('fade');


//elementos card detalhe proxima consulta
const dataConsulta = document.querySelector('.data-consulta');
const status_nome = document.querySelector('.status-nome');
const nome_dependente = document.getElementById('nome-dependente');
const ver_mais = document.getElementById('ver-mais');
const tratamento = document.querySelector('.tratamento');
botao_detalhes_proxima_consulta.forEach(botao => {
    botao.addEventListener('click', function(event) {
        const consultaId = botao.getAttribute('data_id');
        // console.log(consultaId)
        $.ajax({
            url: '/2023_odonto_kids/assets/php/handlers/dashboard_medico/consulta_id.php',  // O arquivo PHP que processará os dados
            type: 'POST',
            data: { id_consulta: consultaId },  // Passa o valor de id_consulta
            success: function(response) {
                // console.log('Resposta do servidor:', response);
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });    

        document.getElementById('relatorio').addEventListener("click", function(){
            window.location.href = '/2023_odonto_kids/assets/pages/dashboard_medico/views/relatorio.php';
        })

        document.getElementById('prontuario').addEventListener("click", function(){
            window.location.href = '/2023_odonto_kids/assets/pages/dashboard_medico/views/prontuarios.php';
        })
        
        fetch('/2023_odonto_kids/assets/php/handlers/dashboard_medico/detalhes_proxima_consulta.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ consulta_id: consultaId})
        })
        .then(response => {
            // console.log("Dados enviados:", { consulta_id: consultaId }) // para debug
            if (!response.ok) {
                throw new Error('Erro na requisição: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            // Verifica se data não é vazio e tem pelo menos um item
            if (data && data.length > 0) {
                const consulta = data[0]     
                // console.log(consulta)
                const dateString = consulta.data
                const dateObject = new Date(dateString + 'T00:00:00')
                const diaconsultaFormatado = `${formatDateToString(dateObject)} às ${formatTime(consulta.horario)}`
                
                dataConsulta.innerHTML = diaconsultaFormatado
                status_nome.innerHTML = consulta.status_consulta
                nome_dependente.innerHTML = consulta.nome_dependente
                ver_mais.setAttribute('consulta_id', consulta.id_dependente)
                tratamento.innerHTML = consulta.Tratamento
                
            } else {
                console.warn('Nenhuma consulta encontrada');
            }
        })
        .catch(error => {
            console.error('Erro ao acessar o banco de dados:', error);
        });
        
        abrirModal();
    });
});

function formatDateToString(date) {
    const daysOfWeek = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
    const monthsOfYear = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

    const dayOfWeek = daysOfWeek[date.getDay()]; // Dia da semana
    const dayOfMonth = date.getDate(); // Dia do mês
    const month = monthsOfYear[date.getMonth()]; // Mês
    const year = date.getFullYear(); // Ano

    return `${dayOfWeek}, dia ${dayOfMonth} de ${month}`;
}

function formatTime(timeString) {
    const [hours, minutes] = timeString.split(':'); // Divide a string
    return `${hours}:${minutes}`; // Retorna apenas horas e minutos
}

document.querySelector('.close-button').addEventListener("click", fecharModal)

function abrirModal(){
    modal_detalhes_proxima_consulta.style.display = "block";
    fade.style.display = "block";
}

function fecharModal(){
    modal_detalhes_proxima_consulta.style.display = "none";
    fade.style.display = "none";
}

// Adiciona evento de clique no fade para fechar o modal
fade.addEventListener('click', function(event) {
    // Verifica se o clique foi fora do modal
    if (event.target === fade) {
        fecharModal();
    }
});

