let data_user = document.getElementById('txt_date');
let cpf_user = document.getElementById('txt_cpf');
let telefone_user = document.getElementById('txt_telEmer');
let form = document.querySelector('.Depe_Form2');

// Função para verificar se a idade nunca é maior que o dia atual
function idadeValida(anoNascimento) {
    const nascimento = new Date(anoNascimento);
    const hoje = new Date();

    let idade = hoje.getFullYear() - nascimento.getFullYear();
    const diferencaMes = hoje.getMonth() - nascimento.getMonth();
    const diferencaDia = hoje.getDate() - nascimento.getDate();

    // Ajusta a idade se o aniversário ainda não ocorreu este ano
    if (diferencaMes < 0 || (diferencaMes === 0 && diferencaDia < 0)) {
        idade--;
    }

    return idade <= hoje.getFullYear();
}

// Função para validar CPF (somente números e 11 dígitos)
function validarCPF(cpf) {
    return /^\d{11}$/.test(cpf);
}

// Função para validar telefone (somente números e 9 dígitos)
function validarTelefone(telefone) {
    return /^\d{9}$/.test(telefone);
}

form.addEventListener('submit', (event) => {
    const dataInserida = data_user.value;
    const cpfInserido = cpf_user.value;
    const telefoneInserido = telefone_user.value;

    // Validação: verifica se a data está vazia ou se é uma data futura/hoje
    if (!dataInserida) {
        alert("Por favor, insira uma data de nascimento.");
        event.preventDefault();
        return;
    }

    if (new Date(dataInserida) >= new Date()) {
        alert("A data que você inseriu é hoje ou uma data futura.");
        event.preventDefault();
        return;
    }

    // Verifica se a idade é válida (não maior que o dia atual)
    if (!idadeValida(dataInserida)) {
        alert("A data de nascimento não pode indicar uma idade maior que o ano atual.");
        event.preventDefault();
        return;
    }

    // Validação do CPF
    if (!validarCPF(cpfInserido)) {
        alert("O CPF deve conter exatamente 11 dígitos numéricos.");
        event.preventDefault();
        return;
    }

    // Validação do telefone
    if (!validarTelefone(telefoneInserido)) {
        alert("O telefone deve conter exatamente 9 dígitos numéricos.");
        event.preventDefault();
        return;
    }

    // Se todas as validações passarem, o formulário será enviado automaticamente
});
