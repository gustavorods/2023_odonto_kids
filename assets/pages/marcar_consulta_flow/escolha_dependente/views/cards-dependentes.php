<?php
    $id_responsavel = $_SESSION['responsavel_id'];
    // echo "<script>console.log('Responsável ID: $id_responsavel');</script>";
    $dependente->setIdResponsavel($id_responsavel);
    $dependentes = $dependente->listarDependentes();
?>

<script>
    function criarCardsPaciente(nome, idade, cpf, fotoUrl, id_paciente) {
        const card = document.createElement('div');
        card.classList.add('card');

        // Adiciona uma função de clique ao card
        card.addEventListener('click', function() {
            // Armazena o id_paciente na sessão
            sessionStorage.setItem('id_paciente', id_paciente);
            sessionStorage.setItem('nome', nome);

            allowUnload = true; // Define a variável para permitir o unload

            // Redireciona para a página escolha_tratamento.html
            window.location.href = '../escolha_tratamento/escolha_tratamento.php';
        }); 

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
    const dependentes = <?php echo json_encode($dependentes); ?>;
    // console.log(dependentes);
    
    const cardsContainer = document.querySelector('.cards');

    if (dependentes.length === 0) {
        // Se não houver dependentes, adiciona um aviso dentro do contêiner de cards
        const aviso = document.createElement('div');
        aviso.classList.add('aviso');
        aviso.innerHTML = "Você ainda não possui nenhum dependente cadastrado";
        cardsContainer.appendChild(aviso);
    } else {
        // Se houver dependentes, cria os cards para cada dependente
        dependentes.forEach(dep => {
            const cardPaciente = criarCardsPaciente(dep.nome, dep.idade, dep.cpf, dep.foto, dep.id);
            cardsContainer.appendChild(cardPaciente);
        });
    }
</script>
