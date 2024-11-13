let data_user = document.getElementById('txt_data_nascimento');
let cpf_user = document.getElementById('txt_cpf');
let telefone_user = document.getElementById('txt_telefone');
let crm_user = document.getElementById('txt_crm');
let email_user = document.getElementById('txt_email');
let form = document.querySelector('.cadastro_form');

// Função para verificar se a data corresponde a 18 anos ou mais
function tem18OuMais(anoNascimento) {
    const nascimento = new Date(anoNascimento);
    const hoje = new Date();
    
    let idade = hoje.getFullYear() - nascimento.getFullYear();
    const diferencaMes = hoje.getMonth() - nascimento.getMonth();
    const diferencaDia = hoje.getDate() - nascimento.getDate();

    // Ajusta a idade se o aniversário ainda não ocorreu este ano
    if (diferencaMes < 0 || (diferencaMes === 0 && diferencaDia < 0)) {
        idade--;
    }
    
    return idade >= 18;
}

// Função para validar CPF (somente números e 11 dígitos)
function validarCPF(cpf) {
    return /^\d{11}$/.test(cpf);
}

// Função para validar telefone (somente números e 9 dígitos)
function validarTelefone(telefone) {
    return /^\d{9}$/.test(telefone);
}

// Função para validar CRM (5 números, 1 hífen, 1 número e 2 letras sem espaços e no máximo 10 dígitos)
function validarCRM(crm) {
    return /^\d{5}-\d{1}[A-Za-z]{2}$/.test(crm);
}

// Função para validar email (verifica se tem "@" e algo antes e depois, permitindo domínios sem ponto)
function validarEmail(email) {
    return /^[^@]+@[^@]+(\.[a-zA-Z]{2,})?$/.test(email);
}

form.addEventListener('submit', (event) => { 
    const dataInserida = data_user.value;
    const cpfInserido = cpf_user.value;
    const telefoneInserido = telefone_user.value;
    const crmInserido = crm_user.value;
    const emailInserido = email_user.value;

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
    
    // Verifica se a idade é 18 anos ou mais
    if (!tem18OuMais(dataInserida)) {
        alert("Você precisa ter 18 anos ou mais.");
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

    // Validação do CRM
    if (!validarCRM(crmInserido)) {
        alert("O CRM deve ser preenchido com 5 números, um hífen, 1 número e 2 letras (Exemplo: 12345-6 AB).");
        event.preventDefault();
        return;
    }

    // Validação do email
    if (!validarEmail(emailInserido)) {
        alert("Por favor, insira um email válido. O email deve conter '@' e algo antes e depois.");
        event.preventDefault();
        return;
    }

    // Se todas as validações passarem, o formulário será enviado automaticamente
});
