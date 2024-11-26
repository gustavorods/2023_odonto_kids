<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/contato/contato.css">
    <link rel="stylesheet" href="../css/contato/contato_responsivo.css"> 
    <link rel="icon" type="image/png" href="./assets/img/geral/Logo.svg">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Contato</title>
</head>
<body>

<?php
ob_start(); // Inicia o buffer de saída
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_continuar'])) {
    include_once '../php/enviar_email_suporte.php';

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $objetivo = $_POST['objetivo'];
    $mensagem = $_POST['input-mensagem'];

    // Sua lógica aqui
    enviar_email_suporte($nome, $email, $objetivo, $mensagem);   

    // Redirecionamento para evitar reenvio do formulário
    header("Location:./contato.php");
    exit();
}
ob_end_flush(); // Libera o buffer de saída
?>

    <!-- Navbar -->


    <!-- Contato -->
    <section class="contato_section">
        <div class="info">
            <p class="titulo">
                Precisa de ajuda?
            </p>
            <p class="paragrafo">
                Caso esteja perdido e precise de ajuda em algo, não hesite em nos chamar pelos meios de contato abaixo.
            </p>
            <p class="chamada">
                Sua dúvida é sempre bem-vinda!
            </p>
            <div class="botoes">
                <div class="buttom" data-link="linkDoWhatsapp">
                    <img src="../img/contato/whatsapp_icon.webp" alt="">
                    <div>
                        <p>Whatsapp</p>
                        <p>+55 (11) 99999-9999</p>
                    </div>
                </div>
                <div class="buttom" data-link="linkDoGmail">
                    <img src="../img/contato/gmail_icon.webp" alt="">
                    <div>
                        <p>Gmail</p>
                        <p>suporteodontokids@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formulário de contato -->
        <div class="centralizar">
            <div class="formulario">
                <form class="form" method="post">
                    <p class="titulo_form">...ou nos mande uma mensagem </p>
                    <div class="uni">
                        <p class="complemento">Nome completo</p>
                    </div>
                    <input type="text" class="input" data-campo="Nome" placeholder="Clique aqui para digitar" name="nome">
                    
                    <div class="double">
                        <div>
                            <div class="uni">
                                <p class="complemento">Email</p>
                            </div>
                            <input type="text" class="input-double" data-campo="Telefone" placeholder="Clique aqui para digitar" name="email">
                        </div>
                        <div>
                            <div class="uni">
                                <p class="complemento">Objetivo</p>
                            </div>
                            <input type="text" class="input-double" data-campo="Objetivo" placeholder="O que você procura?" name="objetivo">
                        </div>
                    </div>
                    
                    <div class="uni">
                        <p class="complemento" id="mensagem">Mensagem</p>
                    </div>
                    <textarea name="input-mensagem" id="" cols="30" rows="10" class="input-mensagem" placeholder="Diga-nos como podemos te ajudar. Fique à vontade para entrar em detalhes se quiser :)"></textarea>

                    <button id="botaoEnviar" class="botao-enviar" type="submit" name="btn_continuar">
                        <img class="img-arrow" src="../img/contato/right arrow.png" alt="">
                    </button>
                </form>
            </div>
        </div>
    </section>
    <!-- JS -->
    <script src="../js/contato.js"></script>
</body>
</html>
