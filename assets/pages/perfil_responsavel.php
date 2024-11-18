<?php
session_start();

// Importando e inicializando as classes necessárias
include_once '../php/metodos_principais.php';
include_once '../php/sexo.php';
include_once '../php/responsavel.php';

// Inicializando as instâncias das classes
$metodos_principais = new metodos_principais();
$sexo = new sexo();
$responsavel = new responsavel();

// Pegando todos os dados do médico
$dados_user = $metodos_principais->obter_dados_do_user($_SESSION['user']['tabela'], $_SESSION['user']['id']);

// Lógica para alterar foto de perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_POST['btnAtualizarFoto'])) {
        $responsavel->setId($_SESSION['user']['id']);
        
        // Verifique se a imagem foi carregada corretamente
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            // Converta a imagem para binário
            $imagem = file_get_contents($_FILES['foto_perfil']['tmp_name']);
            
            // Chame o método de alteração da foto, passando a imagem em binário
            $responsavel->alterarFoto($imagem);
        } else {
            echo "Erro ao carregar a imagem.";
        }

        header("Location:perfil_responsavel.php"); 
        exit(); 
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil responsável</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/perfil_responsavel/estilo.css">
    <link rel="stylesheet" href="../css/perfil_responsavel/perfilR.css">
</head>
<body>
    <!-- Navbar -->
    <div class="collapse" id="navbarToggleExternalContent" data-bs-theme="dark">
        <div class="bg-primary p-4 itens-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="odontokids/home">Home</a>
                </li>
                <hr class="linha">

                <li class="nav-item">
                    <a class="nav-link active" href="#">Serviços</a>
                </li>
                <hr class="linha">

                <li class="nav-item">
                    <a class="nav-link active" href="#">Sobre nós</a>
                </li>
                <hr class="linha">

                <li class="nav-item">
                    <a class="nav-link active" href="#">Contato</a>
                </li>
            </ul>
        </div>
    </div>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent"
                aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div id="div-logo">
                <h1>Odonto kids</h1>
                <img src="../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>
             <!-- Botão para abrir o pop-up -->
             <button id="openPopup">
             <?php
                if($dados_user['foto'] == null) {
                    ?>
                    <img src="../img/perfil_medico/perfil_anonimo_icon.png" alt="Imagem de Perfil" height="32px" width="32px" style="border-radius: 50%; border: 1px solid white">
                    <?php
                } else {
                    ?>
                    <img 
                    src="data:image/jpeg;base64,<?php echo base64_encode($dados_user['foto']); ?>" 
                    alt="Imagem de Perfil" 
                    height="32px" 
                    width="32px" 
                    style="border-radius: 50%; border: 1px solid white">
                    <?php
                }
             ?>
            </button>
            
             <!-- O pop-up lateral -->
            <div id="popup" class="popup">
                <div class="popup-header">
                    <div class="popup-title">
                     <?php
                     echo $dados_user['nome']
                     ?>
                    </div>
                    <button id="closePopup" class="popup-close">✕</button>
                </div>
                    <div class="popup-content">
                    <ul>
                        <li><a href="#"><span>Agendamentos</span></a></li>
                        <li><a href="#"><span>Prontuários</span></a></li>
                        <li><a href="perfilR.php"><span>Minha Conta</span></a></li>
                        <hr>
                        <li><a href="#"><span>Sair</span></a></li>
                    </ul>
                </div>
            </div>
    </div>
 </nav>

 <!--CONTEUDO-->
 <div class="container">
        <h3 class="titulo"><?php echo $dados_user['nome'] ?></h3> 
        <header>
            <form id="foto-perfil" method="post" enctype="multipart/form-data">
                <?php
                    if($dados_user['foto'] == null) {
                        ?>
                        <img src="../img/perfil_medico/perfil_anonimo_icon.png" alt="Imagem de Perfil" style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid gray">
                        <?php
                    } else {
                        ?>
                        <img 
                        src="data:image/jpeg;base64,<?php echo base64_encode($dados_user['foto']); ?>" 
                        alt="Imagem de Perfil" 
                        height="32px" 
                        width="32px" 
                        style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid gray">
                        <?php
                    }
                ?>
                <br><br>
                <!--<label for="novaFoto">Alterar foto de perfil:</label>
                <input type="file" name="novaFoto" id="novaFoto" accept="image/*">-->
                <button type="submit" class="btn3" name="btnAtualizarFoto">
                    <i class="fas fa-upload"></i> Atualizar Foto
                    <input type="file" name="foto_perfil">
                </button>
                <button type="submit" class="btn2" name="btnRemoverFoto">
                    <i class="fas fa-trash-alt"></i> Remover Foto
                </button>
            </form>
        </header>
        
        <!-- Seção de abas de navegação  -->
        <div class="nav-tabs">
            <div class="nav-tab" data-tab="dados">Dados e Privacidade</div>
            <div class="nav-tab active" data-tab="config">Editar Perfil</div>
            <div class="nav-tab" data-tab="dependentes">Cadastrar Dependentes</div>
            <div class="nav-tab" data-tab="viewdepend">Dependentes</div>
        </div>


            <!-- Dados e Privacidade -->
              <div class="tab-content">
                <!-- ABA DE privacidade -->
                <div class="content" id="dados">
                    <div class="content-header">
                        <div class="title">Dados e Privacidade</div>
                    </div>
                    <br><br>
                    <!-- informações sobre privacidade -->
                    <p>Informações pessoais que você salvou na conta, como seu aniversário ou endereço de e-mail, e opções para gerenciá-las. Esses dados são particulares, não serão publicados!
                    A sua privacidade e a segurança dos seus dados são extremamente importantes para nós. No nosso sistema de agendamento, coletamos e armazenamos apenas as informações necessárias para garantir um atendimento eficiente e seguro. Isso inclui dados como nome, informações de contato, dados de agendamento e, quando aplicável, informações sobre dependentes.
<br><br>
                    Como usamos seus dados:
                    <ul>
                    <li>Agendamentos e Atendimento: Utilizamos as informações fornecidas para processar os agendamentos, confirmar consultas, e garantir que o atendimento seja realizado conforme solicitado.</li>
                    <li>Comunicações: Seus dados de contato (como e-mail e telefone) serão usados para enviar confirmações de agendamento, lembretes e atualizações importantes.</li>
                    <li>Segurança e Suporte: Seus dados são armazenados de maneira segura, com acesso restrito aos profissionais responsáveis pelo seu atendimento, garantindo a confidencialidade e a integridade das informações.</li>
                    </ul>
                    Não compartilhamos suas informações pessoais com terceiros sem o seu consentimento, exceto quando necessário para cumprir com obrigações legais ou fornecer o serviço de maneira adequada.
                    Em caso de dúvidas nos contate por meio de nosso canais de atendimento!
                    </p>

                    <p>Entendemos a importância da segurança da sua conta. Se você deseja alterar sua senha, basta clicar em 'Alterar senha'. A troca de senha é uma maneira simples e eficaz de proteger o acesso à sua conta e garantir que suas informações pessoais permaneçam seguras. <a href="alterarS.php">Alterar Senha</a>
                    </p>
                </div>
            </div>


            <!-- Conteúdos de cada aba -->
            <div class="tab-content">
                <!-- ABA DE Editar Perfil -->
                <div class="content" id="config">
                    <div class="content-header">
                        <div class="title">Editar Perfil</div>
                    </div>
                    <br><br>
                    <div class="sobre">
                        <h2 class="titulo">Sobre</h2>
                
                    <label for="nome">Nome completo:</label>
                    <input type="text" class="input" name="nome" id="nome" disabled value=""><br><br>
                
                    <label for="email">Email:</label> 
                    <input type="text" class="input" name="email" id="email" disabled value=""><br><br>

                    
                    <label for="cpf">CPF:</label>
                    <input type="text" class="input" name="cpf" id="cpf" disabled value=""><br><br>
            
                    <label for="tel">Telefone:</label>
                    <input type="text" class="input" name="tel" id="tel" disabled value=""><br><br>
                    
                
                    <label for="nasc">Data de nascimento:</label>
                    <input type="text" class="input" disabled value=""><br><br>
                

                    <label for="sexo">Sexo:</label>
                    <input type="text" class="input" name="sexo" id="sexo" disabled value="">
                </div>
        
<br><br>
<hr>
            <h2 class="titulo">Alterar informações de contato</h2>
            <p>Os dados como nome, endereço e outros detalhes pessoais são fundamentais para a correta identificação e registro dentro do sistema, e qualquer alteração nesses dados pode afetar o relacionamento e a correspondência com os registros da plataforma. Já o e-mail e o telefone são informações de contato direto, que podem ser atualizadas sem comprometer a estrutura básica do perfil, desde que o novo e-mail ou telefone esteja válido para garantir que as notificações e comunicações sejam corretamente enviadas. Caso queira alterar algum dado clique em 'Alterar informações'.</p>
<br>
                <button type="button" class="btn3">Alterar Informações</button>
<br><br><br>
            <!-- Pop-up para alterar informações -->
            <div class="editar-tela" style="display: none;">
                <div class="editar-content">
                    <h4>Alterar Informações de Contato</h4>
                    <br>
                    <!-- Formulário de edição -->
                    <form action="perfilR.php" method="post">
                        <label for="edit-email">Email:</label>
                        <input type="email" class="input" name="email" id="edit-email" required value=""><br><br>

                        <label for="edit-telefone">Telefone:</label>
                        <input type="tel" class="input" name="telefone" id="edit-telefone" required value=""><br><br>

                        <button type="submit" class="btn3" name="btnalterar">Salvar Alterações</button>
                        <button type="button" class="btn3" >Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
     <!-- ABA DE Cadastrar Dependentes -->
     <div class="content" id="dependentes">
                <div class="content-header">
                    <div class="title">Cadastrar Dependente</div>
                </div><br>
                <p>Fazendo o cadastro da sua criança e disponibilizando suas informações médicas aqui, permiti que você:
                    <ul>
                        <li>Acesso Rápido a Informações Médicas: Permite que médicos e outros profissionais de saúde tenham acesso imediato ao histórico médico da criança, incluindo alergias, vacinas, medicamentos em uso, condições crônicas, entre outros dados relevantes, facilitando o atendimento em emergências ou consultas.</li><br>
                        
                        <li>Agendamento e Gestão de Consultas: Facilita o agendamento de consultas e o acompanhamento de tratamentos, exames e vacinas, garantindo que todas as necessidades médicas da criança sejam gerenciadas de maneira eficiente.</li><br>
                        
                        <li>Comunicação com Profissionais de Saúde: Possibilita uma comunicação mais direta e rápida com os profissionais de saúde, permitindo o envio de atualizações, relatórios médicos ou pedidos de informação.</li><br>
                        
                        <li>Acesso a Documentos Médicos: Facilita o acesso a documentos médicos importantes, como prescrições, laudos de exames e relatórios médicos, que podem ser necessários em diferentes situações, como viagens, mudanças de escola ou acompanhamento por especialistas.</li>
                    </ul>
                </p>
                <button type="submit" class="btn3">Cadastrar</button>
        </div>

        <!-- ABA DE dependentes -->
        <div class="content" id="viewdepend">
            <div class="content-header">
            <div class="title">Dependentes</div>
            </div>
            <br>
            <!-- Listar todos os dependentes do responsavel-->
    </div>



</div>

<br><br><br><br><br><br><br><br><br>
<!--FOOTER-->
<section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>Endereço</h3>
            <p>Endereço: 619 Albuquerque Travessa - Tucano, PI / 60960-761<br>CNPJ: n° 87.313.818/0001-42</p>
        </div>
        <div class="box">
            <h3>E-mail</h3>
            <a href="#" class="link">OdontoKids@gmail.com</a>
            <a href="#" class="link">SuporteOdontoKids@hotmail.com</a>
        </div>
        <div class="box">
            <h3>Ligue</h3>
            <p>+55 0000-0000</p>
            <p>+55 0000-0000</p>
        </div>
    </div>
    <div class="credit">Copyright © 2023 Odonto Kids LTDA</div>
</section>

<script src="../js/perfilAbas.js"></script>
<script src="../js/popupPerfil.js"></script>
</body>
</html>