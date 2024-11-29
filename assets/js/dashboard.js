const botaoDetalhes = document.querySelectorAll('.botao-detalhes-proxima-consulta');
const detalhesProximaConsulta = document.querySelector('.detalhes-proxima-consulta');
const fade = document.getElementById("fade");

const nomeDependenteDetalhe = document.querySelector('.nome-perfil');
const tratamentoDetalhe = document.querySelector('.tratamento');
const diaconsulta = document.querySelector('.dia-consulta');

// Adiciona o evento de clique a cada elemento
botaoDetalhes.forEach(botao => {
    botao.addEventListener('click', function(event) {
        const consultaId = botao.getAttribute('data-id');

        fetch('/2023_odonto_kids/assets/php/handlers/dashboard/detalhe-proxima-consulta.php', {
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
                const consulta = data[0];
                const { data: dataConsulta, hora, nome, tratamento } = consulta;
        
                nomeDependenteDetalhe.innerHTML = nome;
                tratamentoDetalhe.innerHTML = tratamento;
        
                const dateString = dataConsulta;
                const dateObject = new Date(dateString + 'T00:00:00');
                const diaconsultaFormatado = `${formatDateToString(dateObject)} às ${formatTime(hora)}`;
                diaconsulta.innerHTML = diaconsultaFormatado;
        
                createCalendar(dateObject);
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
    modal.style.display = 'none'; // Fecha o modal
    fade.style.display = "none";
}

function abrirModal(){
    detalhesProximaConsulta.style.display = "block"
    fade.style.display = "block"
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

// Seleciona todos os botões de "Detalhes"
const botoesDetalhes = document.querySelectorAll('.detalhes-historico-consulta');

// Seleciona o modal e os elementos dentro dele
const modal = document.querySelector('.modal_detalhes_proxima_consulta');
const pDataConsulta = modal.querySelector('.data-consulta');
const pacienteConsulta = modal.querySelector('.paciente-consulta');
const prontuarioButton = modal.querySelector('#prontuario');
const relatorioButton = modal.querySelector('#relatorio');

// Adiciona o evento de clique para cada botão "Detalhes"
botoesDetalhes.forEach(botao => {
    botao.addEventListener('click', function() {
        // Encontra o card mais próximo do botão
        const card = botao.closest('.corpo-card-historico');
        
        // Dentro do card, encontra o <p> dentro da classe 'data'
        const dataElement = card.querySelector('.data p');
        const nomeElement = card.querySelector('.nome-perfil p');
        
        // Agora você pode pegar o conteúdo do <p> (que é a data)
        const dataConteudo = dataElement.textContent;
        const nomeConteudo = nomeElement.textContent;

        // Pega o data-id do botão clicado
        const dataId = botao.getAttribute('data-id');
        
        // Preenche o conteúdo do modal
        pDataConsulta.textContent = dataConteudo; // Preenche a data da consulta no modal
        pDataConsulta.setAttribute('data-id', dataId); // Adiciona o data-id ao <p>

        pacienteConsulta.textContent = nomeConteudo; // Preenche a nome pacinete no modal

        // Define o data-id nos botões de ação também
        prontuarioButton.setAttribute('data-id', dataId);
        relatorioButton.setAttribute('data-id', dataId);

        // Exibe o modal
        modal.style.display = 'block';
        fade.style.display = "block"

    });
});

// Adiciona um evento para fechar o modal quando o botão de fechar for clicado
const closeButton = modal.querySelector('.close-button');
closeButton.addEventListener('click', function() {
    modal.style.display = 'none'; // Fecha o modal
    fade.style.display = "none"
});



// Função para enviar o POST para a URL desejada com o data-id
function sendPostRequest(url, dataId) {
    // Cria um formulário HTML dinamicamente
    const form = document.createElement('form');
    form.method = 'POST';  // Define o método POST
    form.action = url;     // Define a URL de destino

    // Cria um campo oculto para o data-id
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'data-id';  // Nome do campo que será enviado
    input.value = dataId;    // Valor do campo

    // Adiciona o input ao formulário
    form.appendChild(input);

    // Adiciona o formulário ao body e envia
    document.body.appendChild(form);
    form.submit();  // Envia o formulário
}

// Adiciona um evento de clique no botão "Prontuário"
prontuarioButton.addEventListener('click', function() {
    // Pega o data-id do botão de prontuário
    const dataId = prontuarioButton.getAttribute('data-id');

    // Chama a função para enviar o POST para a URL de prontuário
    sendPostRequest('http://localhost/2023_odonto_kids/assets/pages/dashboard/views/prontuario.php', dataId);
});

// Adiciona um evento de clique no botão "Relatório"
relatorioButton.addEventListener('click', function() {
    // Pega o data-id do botão de relatório
    const dataId = relatorioButton.getAttribute('data-id');

    // Chama a função para enviar o POST para a URL de relatório
    sendPostRequest('http://localhost/2023_odonto_kids/assets/pages/dashboard/views/relatorio.php', dataId);
});
