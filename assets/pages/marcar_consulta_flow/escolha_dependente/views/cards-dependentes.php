<?php
    $dependentes = $dependente->listarDependentes();
?>

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

    // Função para mascarar o CPF, deixando os primeiros 3 e os dois últimos dígitos com asteriscos
    function mascaraCpf(cpf) {
        return cpf.replace(/(\d{3})\d{3}(\d{3})(\d{2})/, '***.$2.$3-**');
    }

    // Obter os dados dos dependentes
    const dependentes = <?php echo json_encode($dependentes); ?>

    // Laço que percorre os dependentes e cria os cards
    dependentes.forEach(dep => {
        const cardPaciente = criarCardsPaciente(dep.nome, dep.idade, dep.cpf, dep.foto, dep.id);
        document.querySelector('.cards').appendChild(cardPaciente);
    });
</script>