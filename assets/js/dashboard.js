const botaoDetalhes = document.querySelectorAll('.botao-detalhes-proxima-consulta');
const detalhesProximaConsulta = document.querySelector('.detalhes-proxima-consulta');
const fade = document.getElementById("fade");

const nomeDependenteDetalhe = document.querySelector('.nome-perfil');
const tratamentoDetalhe = document.querySelector('.tratamento');
const diaconsulta = document.querySelector('.dia-consulta');

// Adiciona o evento de clique a cada elemento
botaoDetalhes.forEach(botao => {
    botao.addEventListener('click', function(event) {
        event.preventDefault();

        const consultaId = botao.getAttribute('data-id');

        fetch('/2023_odonto_kids/assets/php/detalhe-proxima-consulta.php', {
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
            // Verifica se data não é vazio
            if (data && Array.isArray(data)) {
                data.forEach(consulta => {
                    // Desestrutura o objeto para obter cada propriedade
                    const { data: dataConsulta, hora, nome, tratamento } = consulta;

                    // console.log("Data da consulta:", dataConsulta);
                    // console.log("Hora da consulta:", hora);
                    // console.log("Nome do paciente:", nome);
                    // console.log("Tratamento:", tratamento);

                    nomeDependenteDetalhe.innerHTML = nome;
                    tratamentoDetalhe.innerHTML = tratamento;
                    
                    const dateString = dataConsulta;
                    const dateObject = new Date(dateString + 'T00:00:00');

                    const diaconsultaFormatado = `${formatDateToString(dateObject)} às ${formatTime(hora)}`;
                    diaconsulta.innerHTML = diaconsultaFormatado

                    createCalendar(dateObject)
                });
            } else {
                console.warn('Nenhuma consulta encontrada');
            }
        })
        .catch(error => {
            console.error('Erro ao acessar o banco de dados:', error);
        });


        abrirModal()
    });
});

const fechar = document.querySelector(".fechar-detalhe-proxima-consulta");

fechar.addEventListener('click', function(){
    fecharModal();
});

// Adiciona evento de clique no fade para fechar o modal
fade.addEventListener('click', function(event) {
    // Verifica se o clique foi fora do modal
    if (event.target === fade) {
        fecharModal();
    }
});

// Função para fechar o modal
function fecharModal() {
    detalhesProximaConsulta.style.display = "none";
    fade.style.display = "none";
    fade.style.backgroundColor = "rgba(0, 0, 0, 0.0)";
}

function abrirModal(){
    detalhesProximaConsulta.style.display = "block"
    fade.style.display = "block"
    fade.style.backgroundColor = "rgba(0, 0, 0, 0.6)"
}

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