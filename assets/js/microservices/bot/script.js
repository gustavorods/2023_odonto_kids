const baseUrl = window.location.origin;
const sendDataInput = document.querySelector(".input_prompt")
const sendDataBtn = document.querySelector(".enviar_prompt");
const messageArea = document.querySelector(".area_mensagem")

// Send Data
async function SendData() {
    const data = {message: sendDataInput.value};

    const res = await fetch(`https://2024-1-b2-bot-using-gemini-api.vercel.app/SendMessage`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const response = await res.json();
    console.log(response);  

    creat_user_message(sendDataInput.value)
    sendDataInput.value = '';

    VerifedDataReady(); 
}; 
sendDataBtn.addEventListener("click", SendData);


// Get Data 
async function GetData() {
    try {
        const res = await fetch(`https://2024-1-b2-bot-using-gemini-api.vercel.app/GetMessage`, {
            method: 'GET'
        });

        const data = await res.json();
        
        console.log("Pegando Mensagem...");
        return data.message;

    } catch (error) {
        console.error('Error fetching message:', error);
    }
}

// Check if data is ready
async function VerifedDataReady() {
    let result = await GetData();
    let lastMessage = result; // Always check the last message in the Get route, so that the bot doesn't always get the same message

    while(result == lastMessage || result == "Initial Message") {
        result = await GetData();
    }
    lastMessage = result;

    creat_bot_message(result);
}

// create bot message area 
function creat_bot_message(message) {
    const content_resposta = document.createElement('div');
    content_resposta.className = 'content_resposta';

    const resposta = document.createElement('div');
    resposta.className = 'resposta';

    const span = document.createElement('span')
    span.innerHTML = message;

    resposta.appendChild(span);

    content_resposta.appendChild(resposta);

    messageArea.appendChild(content_resposta);
}

// create user message area 
function creat_user_message(message) {
    const content_question = document.createElement('div');
    content_question.className = 'content_pergunta';

    const question = document.createElement('div');
    question.className = 'pergunta';

    const span = document.createElement('span')
    span.innerHTML = message;

    question.appendChild(span);

    content_question.appendChild(question);

    messageArea.appendChild(content_question);
}

