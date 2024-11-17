// configurando botão voltar
document.querySelector('.botao-voltar').addEventListener("click", function(){
    allowUnload = true; // Define a variável para permitir o unload
    window.location.href = '../escolha_data_hora/escolha_data_hora.php';
});

document.getElementById('btn-confirmar').addEventListener("click", function(){
    const hora = sessionStorage.getItem('hora');
    const data = sessionStorage.getItem('data');
    const dependente = sessionStorage.getItem('id_paciente');
    const tratamento = sessionStorage.getItem('tratamento');

    // Criar um objeto com os dados
    const dados = {
        hora: hora,
        data: data,
        dependente: dependente,
        tratamento: tratamento
    };

    fetch('/2023_odonto_kids/assets/php/handlers/confirmar_consulta/confirmar_consulta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados) // Envia o objeto como JSON
    })
    .then(response => response.json()) // ou response.text(), dependendo da resposta
    .then(data => {
        // Verifica se o status é sucesso
        if (data.status === "sucesso") {
            allowUnload = true; // Define a variável para permitir o unload

            // Redireciona para o dashboard
            window.location.href = '../../dashboard/dashboard.php';
        } else {
            // Exibe um alerta caso haja falha
            alert('Falha ao agendar a consulta: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao comunicar com o servidor');
    });
    
})