<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->load();

function enviar_email_suporte($nome, $email, $senha) {
    $mail = new PHPMailer(true);
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usando TLS

    // Template HTML para o corpo do e-mail
    $htmlBody = '<!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Suporte Odonto Kids</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: auto;
                    background: #ffffff;
                    border-radius: 8px;
                    padding: 20px;
                    border: 2px solid #007bff;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: #333;
                    font-size: 24px;
                    margin-bottom: 10px;
                }
                h2 {
                    color: #555;
                    font-size: 18px;
                    margin-bottom: 20px;
                }
                .label {
                    font-weight: bold;
                    color: #333;
                }
                .data {
                    font-size: 16px;
                    color: #555;
                    margin-bottom: 15px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Bem-vindo à Odonto Kids :)</h1>
                <h2>Olá <span>' . $nome . '</span>, use esses dados para acessar sua conta:</h2>
                
                <p><span class="label">Email:</span> <span class="data">' . $email . '</span></p>
                <p><span class="label">Senha:</span> <span class="data">' . $senha . '</span></p>
            </div>
        </body>
        </html>
        ';

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST']; 
        $mail->SMTPAuth   = $_ENV['SMTP_AUTH'];
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASSWORD'];
        $mail->Port       = $_ENV['SMTP_PORT']; // Porta para SSL

        // Remetente e destinatário
        $mail->setFrom($_ENV['SMTP_USER'], 'Odonto Kids');
        $mail->addAddress($email, $email);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Suporte Odonto Kids';
        $mail->Body    = $htmlBody;
        $mail->AltBody = 'Email: ' . $email . 'Senha: ' . $senha;

        $mail->send();

        return "Email enviado" . $nome;
    } catch (Exception $e) {
        echo "Falha no envio do e-mail: {$mail->ErrorInfo}";
    }
}

// Exemplo de uso
// enviar_email_suporte('', '', '');
?>