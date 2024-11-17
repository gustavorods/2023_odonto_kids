<?php
    session_start();

    // Importando e inicializando a classe com os metodos necessarios
    include_once '../php/sexo.php';
    include_once '../php/dependente.php';
    $sexo_instancia = new sexo();
    $dep_instancia = new Dependente();

    // Pegando os sexos do banco de dados
    $result_sexo = $sexo_instancia->getAllSexo();

    // Lógica de cadastro
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Dependentes</title>
    <link rel="icon" type="image/png" href="../img/geral/Logo.svg">
    <link rel="stylesheet" href="../css/Dependente/Cadastrar_Dependente.css">
    <link rel="stylesheet" href="../css/Dependente/Cadastrar_DependenteRespnsiva.css">

</head>

<style>
/*------Desing Normal-----*/
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&display=swap');
@import '../css/geral/header_seta_voltar.css';

body {
    background-color: #F8F8FF;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
}

.Container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 100%;
}

.Titulo-Visu {
    font-family: 'Inter';
    font-size: 33px;
    justify-content: center;
    align-items: center;
    display: flex;
    margin-top: 30px;
}

.Card-Depe {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 60%;
    margin: 20px;
    padding: 20px;
    border-radius: 10px;
    background-color: #FFFFFF;
}

.Card-Depe h1 {
    margin-left: 25px;
    margin-bottom: 25px;
}

.Foto-Input img {
    width: 190px;
    height: 190px;
    border-radius: 50%;
    object-fit: cover;
}

.Foto-Input input[type="file"] {
    position: absolute;
    width: 190px;
    height: 190px;
    opacity: 0;
    cursor: pointer;
}

.Foto-Input {
    position: relative;
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.Form-Input,
.Form-Input2 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 45%;
    /* Ajusta o tamanho para metade da largura */
}

.form_input {
    background-color: #D9D9D9;
    margin-bottom: 25px;
    padding: 12px;
    width: 270px;
    border-radius: 10px;
}

.Depe_Form2 {
    display: flex;
    justify-content: space-between;
    /* Espaçamento entre as duas colunas */
    width: 100%;
}


.form_input,
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 10px;
    background-color: #D9D9D9;
}

.form_input,
select {
    box-sizing: border-box;
}

.Form-Input,
.Form-Input2 {
    display: flex;
    flex-direction: column;
    gap: 15px;
    /* Espaçamento entre os campos */
}

.Form-Input {
    margin-left: 70px;
}

.Form-Input2 {
    display: flex;
    flex-direction: column;
    gap: 15px;
    /* Espaçamento entre os campos */
    margin-left: 70px;
    margin-bottom: 15px;
    /* Espaçamento entre os inputs e o botão */
    width: 45%;
}

.Buttom-container {
    display: flex;
    justify-content: center;
    margin-top: 70px;
    /* Espaço entre o formulário e o botão */
}

.btnEnv {
    cursor: pointer;
    width: 190px;
    height: 40px;
    border-radius: 12px;
    background-color: #0681F3;
    font-family: 'Inter';
    font-weight: bold;
    color: #FFFFFF;
    font-size: 20px;
}

.Buttom-container:hover .btnEnv {
    background-color: #005bb5;
}

.error-message {
    color: red;
    font-size: 0.9em;
    margin-top: 5px;
    display: block;
}

/*----Responsividade-----*/
/* Responsividade básica para telas DeskTops */
@media screen and (max-width: 1025px) {
    .Card-Depe {
        width: 100%;
    }

    .Form-Input,
    .Form-Input2 {
        margin-right: 0px;
        /* Remove margens laterais excessivas */
    }
    .form_input,
    select {
        width: 80%; /* Aumenta a largura dos inputs */
        height: 50px; /* Aumenta a altura */
        font-size: 18px; /* Melhora a legibilidade */
        padding: 10px; /* Ajusta o espaçamento interno */
    }
}

@media screen and (max-width: 768px) {
    .Card-Depe {
        width: 95%;
    }

    .Depe_Form2 {
        flex-direction: column;
        align-items: center;
    }

    .Form-Input,
    .Form-Input2 {
        width: 100%;
        margin-left: 0;
    }

    .btnEnv {
        width: 100%;
    }
}

@media screen and (max-width: 480px) {
    .Card-Depe {
        width: 100%;
        padding: 15px;
    }

    .Titulo-Visu {
        font-size: 28px;
    }

    .Foto-Input img {
        width: 150px;
        height: 150px;
    }

    .form_input,
    select {
        width: 100%;
        padding: 10px;
    }

    .btnEnv {
        width: 100%;
        height: 45px;
        font-size: 18px;
    }
}
@media screen and (max-width: 414px) {
    .Card-Depe {
        width: 95%;
        padding: 15px;
    }
    
    .Titulo-Visu {
        font-size: 26px; 
        text-align: center;
    }

    .form_input,
    select {
        width: 100%;
        padding: 10px;
    }
    /* Ajuste da imagem */
    .Foto-Input img {
        width: 140px;
        height: 140px;
    }

    .Foto-Input input[type="file"] {
        width: 140px;
        height: 140px;
    }

    .btnEnv {
        width: 100%; 
        height: 45px;
        font-size: 18px;
    }

    .Form-Input, .Form-Input2 {
        margin-left: 0; 
        gap: 10px; 
        width: 100%; 
    }

    .Depe_Form2 {
        flex-direction: column; 
        align-items: center; 
    }
}

</style>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a href="javascript:history.back()"><img src="../img/cadastro/seta_voltar.svg" alt="seta de voltar branca" class="navbar_seta_voltar"></a>
            <div id="div-logo">
                <h1>Odonto kids</h1>
                <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>
            <div></div>
        </div>
    </nav>

    <div class="Container">

        <div class="Card-Depe">
            <h1 class="Titulo-Visu">Cadastrar Dependente</h1>

            <form class="Depe_Form2" method="post" enctype="multipart/form-data">
                <div class="Foto-Input">
                    <!-- Campo de upload -->
                    <input type="file" name="Foto" id="Foto" onchange="loadImagePreview(event)">
                    <!-- Imagem de pré-visualização -->
                    <img src="../img/perfil_medico/perfil_anonimo_icon.png" alt="Foto de perfil anônima" id="image-preview">
                </div>
                <!--Lado Esquerdo-->
                <div class="Form-Input">
                    <div class="input_form">
                        <!-- Nome -->
                        <label for="txt_nome" name="txt_nome" class="input_label">Nome Completo</label>
                    </div>
                    <input type="text" name="txt_nome" id="txt_nome" class="form_input" placeholder="Clique aqui para digitar" required value="">

                    <div class="input_form">
                        <!-- CPF -->
                        <label for="txt_cpf" class="input_label">CPF</label>
                    </div>
                    <input type="number" name="txt_cpf" id="txt_cpf" class="form_input" placeholder="Clique aqui para digitar" required value="">

                    <div class="input_form">
                        <!-- Data de Nascimento -->
                        <label for="txt_date" class="input_label">Data de Nascimento</label>
                    </div>
                    <input type="date" name="txt_date" id="txt_date" class="form_input" placeholder="Clique aqui para digitar" required value="">

                    <div class="input_form">
                        <!-- Responsável -->
                        <label for="txt_resp" class="input_label">Telefone de Emergencia</label>
                    </div>
                    <input type="number" name="txt_telEmer" id="txt_telEmer" class="form_input" placeholder="Clique aqui para digitar" required value="">
                </div>

                <!--Lado Direito-->
                <div class="Form-Input2">
                    <div class="input_form">
                        <!-- Campos de formulário -->
                        <label for="txt_sexo" class="input_label">Sexo</label>
                        <select name="txt_sexo" class="opt_sexo" id="txt_sexo" required>
                            <!-- Opções -->
                            <?php
                            if(!empty($result_sexo)) {
                                foreach ($result_sexo as $sexo_item) {
                                    $selected = ($sexo_item['sexo'] == $sexo) ? 'selected' : '';
                                    echo "<option value='{$sexo_item['sexo']}' $selected>{$sexo_item['sexo']}</option>";
                                }   
                            }
                            ?> 
                        </select>
                    </div>

                    <div class="input_form">
                        <label for="txt_endeco" class="input_label_endeco">Endereço</label>
                        <input type="text" name="txt_endeco" id="txt_endeco" class="form_input" placeholder="Clique aqui para digitar" required>
                    </div>

                    <!-- Adicionando o botão diretamente abaixo -->
                    <div class="Buttom-container">
                        <input type="submit" name="btnEnv" class="btnEnv" value="Cadastrar">
                    </div>
                </div>
            </form>

        </div>
    </div>

    

</body>
<script src="../js/cadastro_dependentes.js"></script>
</html>

<script>
    
 // Função para carregar e atualizar a pré-visualização da imagem
 function loadImagePreview(event) {
    const output = document.getElementById('image-preview');

    // Verifica se o arquivo foi selecionado
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();

        // Lê o arquivo como uma URL de dados e define como a fonte da imagem
        reader.onload = function(e) {
            output.src = e.target.result; // Atualiza o `src` da imagem
        };

        // Lê o arquivo selecionado
        reader.readAsDataURL(event.target.files[0]);
    }
}
//Mensagem de erro:
const respInput = document.getElementById("txt_resp_nome");
const errorSpan = document.getElementById("error-resp");

respInput.addEventListener("input", () => {
    errorSpan.textContent = ""; // Remove a mensagem de erro ao digitar
});
</script>