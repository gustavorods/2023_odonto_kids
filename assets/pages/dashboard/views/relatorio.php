<?php
// Verifica se o valor 'data-id' foi enviado via POST
if (isset($_POST['data-id'])) {
    // Obtém o valor do 'data-id' enviado no POST
    $dataId = $_POST['data-id'];

    // Agora você pode usar o $dataId em sua lógica
    // echo "O data-id enviado é: " . htmlspecialchars($dataId);
} else {
    echo "O data-id não foi enviado!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard_medico/dashboard_medico.css">
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/relatorio/relatorio.css">
    <!-- <link rel="stylesheet" href="../css/servicos/servicos_responsivo.css"> -->
    <link rel="icon" type="image/png" href="/2023_odonto_kids/assets/img/geral/Logo.svg">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Relatório | Odontokids</title>
    <style>
        @import '../../../css/geral/header_somente_logo.css';


        h1 {
            color: #333;
            text-align: center;
        }

        form {
            margin: 20px 0 0 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            resize:none;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }   
        
        .formulario{
            margin: 20px;
        }
    </style>
</head>

<script>

</script>

<?php
    session_start();
    
    include '../../../php/consultas.php';

    $consulta = new Consulta();
    $consulta_id = $_POST['data-id'];
    // var_dump($consulta_id);
    $consulta->setId($consulta_id);
    $relatorio = $consulta->recuperar_relatorio();
    // var_dump($relatorio)
?>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-dark">
            <div class="container-fluid">

                <div class="voltar" onclick=window.history.back();>
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

    <div class="formulario">
        <h1>Relatório Médico</h1>
        
            <textarea maxlength="500" id="texto" name="texto" disabled><?php echo htmlspecialchars($relatorio); ?></textarea><br><br>


    </div>
<script>
    <?php if (isset($resultado)): ?>
        <?php if ($resultado): ?>
            alert("Relatório enviado com sucesso!");
            window.location.href = '../dashboard_medico.php';  // Redireciona para a página principal após sucesso
        <?php else: ?>
            alert("Erro ao enviar o relatório. Tente novamente.");
        <?php endif; ?>
    <?php endif; ?>
</script>
</body>
</html>
