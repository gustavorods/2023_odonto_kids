<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Paciente | Odontokids</title>
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard_medico/dashboard_medico.css">
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/detalhes_paciente/detalhes_paciente.css">
</head>
<body>
    <!-- Navbar -->
    <div class="collapse" id="navbarToggleExternalContent" data-bs-theme="dark">
            <div class="bg-primary p-4 itens-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="../../index.html">Home</a>
                    </li>
                    <hr class="linha">
    
                    <li class="nav-item">
                        <a class="nav-link active" href="./servicos.html">Serviços</a>
                    </li>
                    <hr class="linha">
    
                    <li class="nav-item">
                        <a class="nav-link active" href="./time-line.html">Sobre nós</a>
                    </li>
                    <hr class="linha">
    
                    <li class="nav-item">
                        <a class="nav-link active" href="./contato.html">Contato</a>
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
                    <img src="/2023_odonto_kids/assets/img/geral/Logo.svg" alt="Odonto Kids logo">
                </div>
        
                <div id="div_perfil">
                    <a href="#">
                        <img class="foto_de_perfil_responsavel" name="img_foto_perfil_responsavel"src="/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png" alt="foto de perfil">
                    </a>
                </div>
            </div>
    </nav>
    <!-- Corpo da página -->

    <div class="container-top">
        <div class="container-foto-nome-idade">
            <img src="/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png" alt="" class="foto-perfil">
            <div class="nome-idade">
                <p class="nome">Lourenzo Alvite</p>
                <p class="idade">7 anos</p>
            </div>
        </div>

        <div class="container-dados-responsavel">
            <span>Responsável: </span><p class="nome">Hernandes</p><br>
            <span>Email: </span><p class="email">hernandes@gmail</p><br>
            <span>Telefone Responsável: </span><p class="telefone-responsavel">9 9999-9999</p><br>
            <span>Telefone Emergência: </span><p class="telefone-ermengencia">9 8888-8888</p><br>
        </div>
    </div>

    <div class="corpo-pagina">
        <div class="historico">
            <h1>HISTÓRICO DE CONSULTAS:</h1>
            <div class="cards">



                <div class="card-historico">
                    <div class="line"></div>
                    <div class="corpo-card-historico">
                        <div class="data-status">
                            <div class="data">
                                <p>Dia de Exemplo às 10:00</p>
                            </div>
                            <div class="status">Realizada</div>
                        </div>
                        <div class="tipo-consulta">
                            <p>Tratamento Exemplo</p>
                        </div>
                        <div class="perfil-detalhes">
                            <div class="left-container">
                                <div class="perfil-imagem">
                                    <img src="/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png" alt="">
                                </div>
                                <div class="nome-perfil">
                                    <p>Nome Dependente</p>
                                </div>
                            </div>
                            <div class="botao-detalhes">
                                <button class="detalhes-historico-consulta">Detalhes</button>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>

        <div class="tratamentos">
            <h1>TRATAMENTOS:</h1>
            <div class="filtros">
                <div class="em-andamento filho">Em andamento</div>
                <div class="aguardando filho">Aguardando</div>
                <div class="concluido filho">Concluido</div>
                <div class="pendentefilho filho">Pendente</div>
            </div>
            <div class="cards">
                <div class="card-tratamento">
                    <div class="card-header">
                        <h3>Ortodontia</h3>
                        <span class="status">Em andamento</span>
                    </div>
                    <div class="card-body">
                        <p>Data de início: 07/02/2024</p>
                        <p>Previsão de término: 07/02/2027</p>
                    </div>
                </div>                
            </div>
        </div>
    </div>

    <script src="/2023_odonto_kids/assets/js/detalhes_paciente.js"></script>
</body>
</html>
