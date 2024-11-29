<?php
    session_start(); // Inicia a sessão

    $session_medico_id = $_SESSION['medico_id'] ?? null;
    $cookie_medico_id = $_COOKIE['medico_id'] ?? null;

    if (empty($cookie_medico_id) && empty($session_medico_id)) {
        header("Location: /2023_odonto_kids/assets/pages/login.php");
        exit;
    }

    $medico_id = !empty($cookie_medico_id) ? $cookie_medico_id : $session_medico_id;

    echo '<script>console.log('.$medico_id.')</script>';

    if (!is_numeric($medico_id) || $medico_id <= 0) {
        header("Location: /2023_odonto_kids/assets/pages/login.php");
        exit;
    }

    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "odontokids"; 

    // Criar a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verificar se o consulta_id foi enviado via POST
    if (isset($_POST['consulta_id'])) {
        $id_dependente = intval($_POST['consulta_id']);
        // var_dump($id_dependente);
    } else {
        echo "ID da consulta não fornecido!" .$id_dependente;
    }    



    // Query para obter dados do paciente e responsável (sem o histórico de consultas)
    $sql_paciente_responsavel = "
    SELECT 
        d.foto AS foto_paciente,
        d.nome AS nome_paciente,
        TIMESTAMPDIFF(YEAR, d.nasc, CURDATE()) AS idade_paciente,
        r.nome AS nome_responsavel,
        r.email AS email_responsavel,
        r.telefone AS telefone_responsavel,
        d.tel_emergencia AS telefone_emergencia
    FROM dependentes d
    JOIN responsavel r ON d.id_responsavel = r.Id
    WHERE d.id = ?;
    ";

    $stmt = $conn->prepare($sql_paciente_responsavel);
    $stmt->bind_param("i", $id_dependente);
    $stmt->execute();
    $result = $stmt->get_result();

    // Arrays para armazenar os dados
    $dados_paciente = [];
    $dados_responsavel = [];

    // Processar os resultados do paciente e responsável
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Armazenar dados do paciente
            $dados_paciente = [
                'foto' => $row['foto_paciente'],
                'nome' => $row['nome_paciente'],
                'idade' => $row['idade_paciente']
            ];

            // Armazenar dados do responsável
            $dados_responsavel = [
                'nome' => $row['nome_responsavel'],
                'email' => $row['email_responsavel'],
                'telefone' => $row['telefone_responsavel'],
                'telefone_emergencia' => $row['telefone_emergencia']
            ];
        }
    } else {
        // echo "Nenhum resultado encontrado para o paciente!";
    }

    $stmt->close();

    // -------------------------
    // Consulta para histórico de consultas

    $sql_historico_consultas = "
    SELECT 
        c.data AS consulta_dia,
        c.horario AS consulta_horario,
        t.Tratamento AS tratamento_nome,
        s.status_consulta AS status_consulta,
        c.id AS consulta_id,
        d.nome AS nome_dependente,
        d.id_sexo AS sexo_dependente  -- Adiciona o campo sexo da tabela dependentes
    FROM dependentes d
    JOIN consulta c ON c.id_dependente = d.id
    JOIN tratamento t ON c.cod_tratamento = t.Id
    JOIN status_consulta s ON c.status_consulta = s.id_status_consulta
    WHERE d.id = ?;
    ";
    

    $stmt = $conn->prepare($sql_historico_consultas);
    $stmt->bind_param("i", $id_dependente);
    $stmt->execute();
    $result_historico = $stmt->get_result();

    // Array para armazenar o histórico de consultas
    $historico_consultas = [];

    // Array associativo para traduzir meses de inglês para português
    $meses_portugues = [
        'January' => 'Janeiro',
        'February' => 'Fevereiro',
        'March' => 'Março',
        'April' => 'Abril',
        'May' => 'Maio',
        'June' => 'Junho',
        'July' => 'Julho',
        'August' => 'Agosto',
        'September' => 'Setembro',
        'October' => 'Outubro',
        'November' => 'Novembro',
        'December' => 'Dezembro'
    ];

    // Processar o histórico de consultas
    if ($result_historico->num_rows > 0) {
        while ($row = $result_historico->fetch_assoc()) {
            // Formatando a data da consulta
            $data_formatada = new DateTime($row['consulta_dia']); // Cria objeto DateTime com a data da consulta

            // Traduzir o mês para português
            $mes_ingles = $data_formatada->format('F'); // Pega o mês em inglês
            $mes_portugues = $meses_portugues[$mes_ingles]; // Traduz para português

            // Formatando a data final no formato desejado
            $consulta_dia = $data_formatada->format('d') . ' de ' . $mes_portugues; // Exemplo: 20 de Outubro

            $horario_formatado = date('H:i', strtotime($row['consulta_horario'])); // Exemplo: 10:00

            // Armazenar histórico de consultas com a data e hora formatadas
            $historico_consultas[] = [
                'consulta_id' => $row['consulta_id'],
                'sexo' => $row['sexo_dependente'],
                'nome_dependente' => $row['nome_dependente'],
                'dia' => $consulta_dia,
                'horario' => $horario_formatado,
                'tratamento' => $row['tratamento_nome'],
                'status' => $row['status_consulta']
            ];
        }
    } else {
        // Caso não haja histórico de consultas, o array ficará vazio
        $historico_consultas = [];
        // echo "Nenhum histórico de consulta encontrado para o paciente!";
    }

    $stmt->close();

    // -------------------------
    // Consulta para tratamentos relacionados ao dependente

    $sql_tratamentos = "
    SELECT 
        dt.data_inicio AS tratamento_data_inicio,
        dt.previsao_termino AS tratamento_previsao_termino,
        st.status_tratamento AS status_tratamento,
        t.Tratamento AS tratamento_nome
    FROM dependente_tratamento dt
    JOIN tratamento t ON dt.id_tratamento = t.Id
    LEFT JOIN status_tratamento st ON dt.status_tratamento = st.id_status_tratamento
    WHERE dt.id_dependente = ?;
    ";

    $stmt = $conn->prepare($sql_tratamentos);
    $stmt->bind_param("i", $id_dependente); 
    $stmt->execute();
    $result_tratamentos = $stmt->get_result();

    // Array para armazenar os tratamentos
    $tratamentos = [];

    // Processar os resultados de tratamentos
    if ($result_tratamentos->num_rows > 0) {
        while ($row = $result_tratamentos->fetch_assoc()) {
            // Formatar as datas no formato dd/mm/yyyy
            $data_inicio = new DateTime($row['tratamento_data_inicio']);
            $previsao_termino = new DateTime($row['tratamento_previsao_termino']);
            
            // Armazenar os tratamentos com as datas formatadas
            $tratamentos[] = [
                'tratamento' => $row['tratamento_nome'],
                'data_inicio' => $data_inicio->format('d/m/Y'), // Formato dd/mm/yyyy
                'previsao_termino' => $previsao_termino->format('d/m/Y'), // Formato dd/mm/yyyy
                'status_tratamento' => $row['status_tratamento']
            ];
        }
    } else {
        // Caso não haja tratamentos, o array ficará vazio
        $tratamentos = [];
    }

    $stmt->close();
    $conn->close();

    // Verifica se o campo 'foto' não está vazio ou nulo
    if (!empty($dados_paciente['foto'])) {
        // Verifica o tipo da imagem
        $image_info = getimagesizefromstring($dados_paciente['foto']);
        $image_type = $image_info['mime']; // O tipo MIME (exemplo: image/jpeg, image/png, etc.)
        
        // Converte o BLOB para base64
        $foto_base64 = base64_encode($dados_paciente['foto']);
    } else {
        // Caso não tenha imagem
    }

    // Exibir os arrays
    // echo "<pre>";
    // print_r($dados_paciente);         // Exibir dados do paciente
    // print_r($dados_responsavel);      // Exibir dados do responsável
    // print_r($historico_consultas);   // Exibir histórico de consultas
    // print_r($tratamentos);           // Exibir tratamentos
    // echo "</pre>";
?>


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
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
</head>
<body>       
    <nav class="navbar navbar-dark">
            <div class="container-fluid">

                <div class="voltar" onclick="window.location.href='../dashboard_medico.php'">
                    <img src="/2023_odonto_kids/assets/img/login/seta_voltar.svg" alt="">
                </div>                
                <div id="div-logo">
                    <h1>Odonto kids</h1>
                    <img src="/2023_odonto_kids/assets/img/geral/Logo.svg" alt="Odonto Kids logo">
                </div>
        
                <!-- <div id="div_perfil">
                    <a href="#">
                        <img class="foto_de_perfil_responsavel" name="img_foto_perfil_responsavel"src="/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png" alt="foto de perfil">
                    </a>
                </div> -->
            </div>
    </nav>
    <!-- Corpo da página -->

    <div class="container-top">
        <div class="container-foto-nome-idade">
            <?php
            $foto_src = !empty($foto_base64) ? 'data:' . $image_type . ';base64,' . $foto_base64 : '/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png';

            echo '<img src="' . $foto_src . '" alt="Foto do paciente" class="foto-perfil">';
            ?>
            <div class="nome-idade">
                <p class="nome"><?php echo $dados_paciente['nome'] ?></p>
                <p class="idade"><?php echo $dados_paciente['idade'] ?> Anos</p>
            </div>
        </div>

        <div class="container-dados-responsavel">
            <span>Responsável: </span><p class="nome"><?php echo $dados_responsavel['nome'] ?></p><br>
            <span>Email: </span><p class="email"><?php echo $dados_responsavel['email'] ?></p><br>
            <span>Telefone Responsável: </span><p class="telefone-responsavel"><?php echo $dados_responsavel['telefone'] ?></p><br>
            <span>Telefone Emergência: </span><p class="telefone-ermengencia"><?php echo $dados_responsavel['telefone_emergencia'] ?></p><br>
        </div>
    </div>

    <div class="corpo-pagina">
        <div class="historico">
            <h1>HISTÓRICO DE CONSULTAS:</h1>
            <div class="cards">
                <?php
                    if (empty($historico_consultas)) {
                        // Se não houver consultas, exibe o placeholder
                        echo '<div class="place_holder">Nenhuma consulta foi realizada.</div>';
                    } else {
                        // Se houver consultas, exibe as consultas
                        foreach ($historico_consultas as $consulta) {
                            extract($consulta);
                            
                            // Verifica se o status é "Cancelada"
                            $status_cancelada = ($status == 'Cancelada' || $status == 'Ausente');
                            $class_cancelada = $status_cancelada ? 'cancelada' : '';
                            $botao_detalhes_display = $status_cancelada ? 'none' : 'block';
                            $sexo_classe = ($sexo == 2) ? 'girl' : 'boy';
                        
                            // Modifica a URL das imagens dependendo do sexo
                            $relatorio_img = ($sexo == 2) ? '/2023_odonto_kids/assets/img/dashboard_medico/relatorio2.png' : '/2023_odonto_kids/assets/img/dashboard_medico/relatorio.png';
                            $prontuario_img = ($sexo == 2) ? '/2023_odonto_kids/assets/img/dashboard_medico/prontuario2.png' : '/2023_odonto_kids/assets/img/dashboard_medico/prontuario.png';
                        ?>
                            <div class="card-historico <?php echo $class_cancelada; ?> <?php echo $sexo_classe; ?>">
                                <div class="line <?php echo $class_cancelada; ?>"></div>
                                <div class="corpo-card-historico">
                                    <div class="data-status">
                                        <div class="data">
                                            <p><?php echo $dia ?> às <?php echo $horario ?></p>
                                        </div>
                                        <div class="status <?php echo $class_cancelada; ?>"><?php echo $status; ?></div>
                                    </div>
                                    <div class="tratamento-detalhes">
                                        <div class="tipo-consulta">
                                            <p><?php echo $tratamento ?></p>
                                        </div>
                                        <div class="botoes-acao">
                                            <div class="relatorio">
                                                <a href="#" class="detalhes-consulta" data-id="<?php echo $consulta_id; ?>" data-type="relatorio">
                                                    <img src="<?php echo $relatorio_img; ?>" alt="Relatório">
                                                </a>
                                            </div>
                                            <div class="prontuario">
                                                <a href="#" class="detalhes-consulta" data-id="<?php echo $consulta_id; ?>" data-type="prontuario">
                                                    <img src="<?php echo $prontuario_img; ?>" alt="Prontuário">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }                     
                    }
                ?>
            </div>
        </div>

        <div class="tratamentos">
            <h1>TRATAMENTOS:</h1>
            <div class="filtros">
                <div class="em_andamento filho" onclick="filtrarPorStatus('Em andamento', this)">Em andamento</div> 
                <div class="aguardando filho" onclick="filtrarPorStatus('Aguardando', this)">Aguardando</div>
                <div class="concluido filho" onclick="filtrarPorStatus('Concluido', this)">Concluído</div>
                <div class="pendente filho" onclick="filtrarPorStatus('Pendente', this)">Pendente</div>
                <div class="todos filho ativo" onclick="filtrarPorStatus('Todos', this)">Todos</div>
            </div>
            <div class="cards">
                <?php if (empty($tratamentos)) : ?>
                    <div class="place_holder">Nenhum tratamento encontrado.</div>
                <?php else : ?>
                    <?php foreach ($tratamentos as $tratamento) : ?>
                        <div class="card-tratamento" data-status="<?php echo $tratamento['status_tratamento']; ?>">
                            <div class="card-header">
                                <h3><?php echo $tratamento['tratamento'] ?></h3>
                                <span class="status"><?php echo $tratamento['status_tratamento'] ?></span>
                            </div>
                            <div class="card-body">
                                <p>Data de início: <?php echo $tratamento['data_inicio'] ?></p>
                                <p>Previsão de término: <?php echo $tratamento['previsao_termino'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/2023_odonto_kids/assets/js/detalhes_paciente.js"></script>
</body>
</html>
