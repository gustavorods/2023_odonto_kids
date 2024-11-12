// configurando botão voltar
document.querySelector('.botao-voltar').addEventListener("click", function(){
    allowUnload = true; // Define a variável para permitir o unload
    window.location.href = '../escolha_data_hora/escolha_data_hora.php';
});

document.getElementById('btn-confirmar').addEventListener("click", function(){
    // Fazer a requisição AJAX para buscar os tratamentos
    fetch('/2023_odonto_kids/assets/php/handlers/escolha_tratamento/buscarTratamentos.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Verifica o que foi retornado pelo PHP
            resultados = data; // Preenche o array 'resultados' com os dados do PHP
        })
        .catch(error => {
            console.error('Erro ao carregar tratamentos:', error);
        });    
    window.location.href = '../../dashboard/dashboard.php';
})