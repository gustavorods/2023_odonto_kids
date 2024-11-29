const startHour = 8;
const endHour = 17;
const interval = 30 * 60 * 1000; // Intervalo de 30 minutos em milissegundos
let selectedTime = null; // Variável para armazenar o horário selecionado
let selectedButton = null; // Variável para armazenar o botão selecionado

const timeGrid = document.getElementById("timeGrid");

// Função para formatar horário no formato HH:mm
function formatTime(date) {
    return date.toTimeString().slice(0, 5);
}

// Função para gerar horários e criar botões
function generateTimeSlots() {
    const startTime = new Date();
    startTime.setHours(startHour, 0, 0, 0);

    const endTime = new Date();
    endTime.setHours(endHour, 0, 0, 0);

    while (startTime < endTime) {
        const currentTime = formatTime(startTime);

        // Pausa entre 12:00 e 13:00
        if (startTime.getHours() !== 12) {
            const timeButton = document.createElement("button");
            timeButton.classList.add("time-btn");
            timeButton.textContent = currentTime;

            // Evento de clique para capturar o horário selecionado
            timeButton.addEventListener("click", () => {
                // Se já houver um horário selecionado, resetamos o estilo
                if (selectedButton) {
                    selectedButton.style.backgroundColor = ''; // Resetando a cor do botão anterior
                    selectedButton.style.color = ''; // Resetando a cor do texto
                }
                
                selectedTime = currentTime;
                selectedButton = timeButton;
                
                // Atualiza o estilo do botão selecionado
                timeButton.style.backgroundColor = '#3977d4';
                timeButton.style.color = 'white';
            });

            timeGrid.appendChild(timeButton);
        }

        // Incrementa o horário em 30 minutos
        startTime.setTime(startTime.getTime() + interval);
    }
}

generateTimeSlots();

// Função chamada ao clicar no botão de enviar
document.getElementById("submitBtn").addEventListener("click", function() {
    const dateInput = document.getElementById("dateInput").value;

    // Verifica se a data foi preenchida
    if (!dateInput) {
        alert("Por favor, selecione uma data.");
        return;
    }

    // Verifica se o horário foi selecionado
    if (!selectedTime) {
        alert("Por favor, selecione um horário.");
        return;
    }

    const selectedDate = new Date(dateInput);
    const dataAtual = new Date();

    // Define as horas para zero para comparação apenas de dia/mês/ano
    selectedDate.setHours(0, 0, 0, 0);
    dataAtual.setHours(0, 0, 0, 0);

    // Verifica se a data selecionada é anterior a hoje
    if (selectedDate < dataAtual) {
        alert("O dia da consulta tem que ser superior a hoje");
        return;
    }

    // Verifica se é um dia da semana (segunda a sexta-feira)
    const dayOfWeek = selectedDate.getDay();
    if (dayOfWeek === 5 || dayOfWeek === 6) { // 0 é domingo e 6 é sábado
        alert("Selecione um dia útil (de segunda a sexta-feira).");
        return;
    }

    // Lógica de limitar certas datas, não finalizada ***não descomentar
    // const tratamento = sessionStorage.getItem('tratamento')
    // // Realiza o envio com a função fetch
    // fetch('/2023_odonto_kids/assets/php/handlers/escolha_data_hora/consultasMarcadas.php', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json'
    //     },
    //     body: JSON.stringify({ tratamento_nome: tratamento})
    // })
    // .then(response => {
    //     // console.log("Dados enviados:", { tratamento_nome: tratamento }) // debug
    //     if (!response.ok) {
    //         throw new Error('Erro na requisição: ' + response.status);
    //     }
    //     // console.log(response) // debug
    //     return response.json();
    // })// Espera a resposta como JSON
    // .then(data => {
    //     // console.log(data) // debug
    // })
    // .catch(error => {
    //     console.error('Erro:', error);
    // });
    
    sessionStorage.setItem('data', dateInput);
    sessionStorage.setItem('hora', selectedTime);
    allowUnload = true; // Define a variável para permitir o unload
    window.location.href = '../confirmar/confirmar.php';
});

// configurando botão voltar
document.querySelector('.botao-voltar').addEventListener("click", function(){
    allowUnload = true; // Define a variável para permitir o unload
    window.location.href = '../escolha_tratamento/escolha_tratamento.php';
});