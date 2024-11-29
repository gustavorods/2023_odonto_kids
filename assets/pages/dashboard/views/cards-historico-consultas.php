<style>
    .historico-consulta{
        margin: 30px 50px;
    }

    .historico-consulta h1{
        font-weight: 1000;
        font-size: 16pt;
        margin: 20px 0px;
    }

    .cards-historico-consulta{
        width: 700px;
    }

    .girl{
        background-color: #FBD2FF;
    }

    .boy{
        background-color: #D2EAFF;
    }

    .card-historico{
        margin: 20px 0px;
        border-radius: 15px;
        border: 0px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.315);
        padding: 10px 40px;
    }

    .corpo-card-historico{
        margin-left: 10px;
    }

    .line{
        width: 3px;
        height: 144px;
        position: absolute;
        transform: translate(-8px, -10px);
    }

    .boy .line{
        background: #0681F3;
    }

    .girl .line{
        background: #E336DC;
    }

    .data-status{
        display: flex;
        justify-content: space-between;
        font-weight: 1000;
        font-size: 13pt;
    }

    .data-status .data{
        color: #636363;
    }

    .boy .data-status .status{
        color: #2E81C9;
    }

    .girl .data-status .status{
        color: #FF55F8;
    }

    .left-container{
        display: flex;
        align-items: baseline;
    }

    .tipo-consulta{
        font-weight: 1000;
        font-size: 15pt;
        margin-top: 3px;
        line-height: 2px;
    }

    .tipo-endereco .endereco{
        font-size: 12pt;
        font-weight: bold;
        color: #636363;
    }

    .perfil-detalhes{
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
    }

    .perfil-detalhes .perfil-imagem img{
        height: 40px;
        width: 40px;
        object-fit: cover;
        border-radius: 100px;    
        border: 2px solid;
        margin-right: 4px;
    }

    .perfil-detalhes .botao-detalhes .detalhes-historico-consulta{
        background-color: #0681F3;
        padding: 8px 20px;
        border-radius: 8px;
        color: white;
    }

    .girl .perfil-detalhes .botao-detalhes .detalhes-historico-consulta{
        background-color: #FF55F8;
    }

    .boy .perfil-detalhes .botao-detalhes .detalhes-historico-consulta{
        background-color: #0681F3;
    }

    .boy .perfil-detalhes .perfil-imagem img{
        border-color: #0681F3;
    }

    .girl .perfil-detalhes .perfil-imagem img{
        border-color: #E336DC;
    }

    .nome-perfil{
        font-size: 12pt;
        font-weight: bold;
        color: #636363;
    }
    
    .aviso-cancelada {
        display: none;
    }

    .cancelada-ausente {
        background-color: #ffd4d4;
    }

    .cancelada-ausente .status {
        color: #8b0000;
    }

    .cancelada-ausente .line {
        background: red;
    }

    .cancelada-ausente .aviso-cancelada .cancelada {
        display: block;
        line-height: 0px;
        color: #9b0000;
        font-size: 11pt;
    }

    .cancelada-ausente .detalhes-historico-consulta {
        display: none;
    }    

    .aviso-ausente {
        display: none;
    }   

    .botao-detalhes h1{
        display: none;
    }
    
    .cancelada-ausente .botao-detalhes h1 {
        line-height: 0px;
        color: #8b0000;
        font-size: 11pt;
        display: block;
    }
</style>
<?php
    $historicoConsultasOrganizadas = $metodos_dashboard->listar_historico_consultas();
    // var_dump($historicoConsultasOrganizadas);
?>

<div class="cards-historico-consulta">
    <?php foreach ($historicoConsultasOrganizadas as $consulta): ?>
        <?php
            // Extrai as variáveis da consulta
            $dia = $consulta['dia'];
            $mes = $consulta['mes'];
            $horario = $consulta['horario'];
            $status = $consulta['status'];
            $tratamento = $consulta['tratamento'];
            $dependente = $consulta['dependente'];
            $id_dependente = $consulta['id_dependente'];
            $sexo = $consulta['sexo'];
            $id = $consulta['id'];

            // Definindo a classe e mensagem de aviso com base no status da consulta
            $avisoMessage = "";
            $cardClass = "";

            switch ($status) {
                case "Realizada":
                    if ($sexo === "Masculino") {
                        $cardClass = 'boy';
                    } else if ($sexo === "Feminino") {
                        $cardClass = 'girl';
                    }
                    break;
                default:
                    $cardClass = 'cancelada-ausente';
                    if ($status === "Cancelada") {
                        $avisoMessage = "";
                    } else {
                        $avisoMessage = "Você não compareceu a essa consulta";
                    }
                    break;
            }

            // Consulta para pegar a foto do dependente
            $foto = '/2023_odonto_kids/assets/img/geral/foto_perfil_teste.png'; // URL padrão

            // Conexão com o banco de dados
            $conn = new mysqli('localhost', 'root', '', 'odontokids'); // Atualize os dados conforme seu banco de dados

            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Consultando a foto do dependente pelo ID
            $stmt = $conn->prepare("SELECT foto FROM dependentes WHERE id = ?");
            $stmt->bind_param("i", $id_dependente);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Verifica se a foto existe e converte para base64
                if (!empty($row['foto'])) {
                    $foto = 'data:image/jpeg;base64,' . base64_encode($row['foto']);
                }
            }

            $stmt->close();
            $conn->close();
        ?>

        <div class="card-historico <?php echo $cardClass; ?>">
            <div class="line"></div>

            <div class="corpo-card-historico">
                <div class="data-status">
                    <div class="data">
                        <p><?php echo $dia . ' de ' . $mes . ' às ' . $horario; ?></p>
                    </div>
                    
                    <div class="status">
                        <?php echo $status; ?>
                    </div>
                </div>

                <div class="tipo-consulta">
                    <div>
                        <p><?php echo $tratamento; ?></p>
                    </div>
                </div>

                <div class="perfil-detalhes">
                    <div class="left-container">
                        <div class="perfil-imagem">
                            <img src="<?php echo $foto; ?>" alt="Foto de perfil de <?php echo $dependente; ?>">
                        </div>

                        <div class="nome-perfil">
                            <p><?php echo $dependente; ?></p>
                        </div>
                    </div>

                    <div class="botao-detalhes">
                        <h1 class="aviso"><?php echo $avisoMessage; ?></h1> <!-- Mensagem de aviso aqui -->
                        <button class="detalhes-historico-consulta" data-id="<?php echo $id; ?>">
                            Detalhes
                        </button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>
