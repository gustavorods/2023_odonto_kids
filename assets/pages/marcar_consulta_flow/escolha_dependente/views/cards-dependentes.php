<script>
    function criarCardsPaciente(nome, idade, cpf, fotoUrl, id_paciente) {
        const card = document.createElement('div');
        card.classList.add('card');

        card.innerHTML = `
            <img src="${fotoUrl}" alt="Foto de ${nome}">
            <p class="nome"><span>Nome:</span> ${nome}</p>
            <p class="idade"><span>Idade:</span> ${idade}</p>
            <p class="cpf"><span>CPF:</span> ${mascaraCpf(cpf)}</p>
        `;

        return card;
    }

    // Função para mascarar o CPF
    function mascaraCpf(cpf) {
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    }

    // Exemplo de uso
    const cardPaciente = criarCardsPaciente('Julio Vasconcelos', 11, '12345678901', 'IMG/crianca3.jpg', 3);

    // Supondo que você queira adicionar o card ao container
    document.querySelector('.cards').appendChild(cardPaciente);
    
</script>