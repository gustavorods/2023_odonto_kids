<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="/2023_odonto_kids/assets/css/dashboard_medico/dashboard_medico.css">
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
    $consulta_id = $_SESSION['id_consulta'];
    // var_dump($consulta_id);
    $consulta->setId($consulta_id);
    $relatorio = $consulta->recuperar_relatorio();
    // var_dump($relatorio)
?>

<body>
    <!--Navbar-->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <div id="div-logo">
                <h1>Odonto kids</h1>
                <img src="../../../img/geral/Logo.svg" alt="Odonto Kids logo">
            </div>
        </div>
    </nav>

    <div class="formulario">
        <h1>Relatório Médico</h1>
        
        <form action="" method="POST">
            <label for="texto">Digite o relatório:</label><br>
            <textarea maxlength="500" id="texto" name="texto" required><?php echo htmlspecialchars($relatorio); ?></textarea><br><br>

            <input type="submit" value="Enviar">

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['texto']) && !empty($_POST['texto'])) {
                        $relatorio_post = $_POST['texto'];
                        
                        // Verifique se o valor do relatório foi alterado
                        if ($relatorio_post !== $relatorio) {
                            $consulta->setRelatorio($relatorio_post);
                            $resultado = $consulta->enviar_relatorio();
                        } else {
                            // Se não houve alteração, não envie o relatório
                            $resultado = true;  // Consideramos que não há erro
                        }
                    } else {
                        echo "Por favor, preencha o campo do relatório.";
                    }
                }
            ?>
        </form>

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
