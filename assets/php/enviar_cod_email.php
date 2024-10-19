<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->load();

function sendEmailWithCode($recipientEmail) {
    $mail = new PHPMailer(true);
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usando TLS

    // Gera um código aleatório de 5 dígitos
    $code = sprintf('%05d', rand(0, 99999));

    // Template HTML para o corpo do e-mail
    $htmlBody = '
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Código de Verificação</title>
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
            }
            p {
                font-size: 16px;
                color: #555;
            }
            .code {
                font-size: 24px;
                font-weight: bold;
                color: #ffffff;
                background-color: #007bff;
                padding: 10px;
                border-radius: 5px;
                display: inline-block;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Código de Verificação</h1>
            <p>Seu código de verificação é:</p>
            <div class="code">' . $code . '</div>
            <p>Por favor, utilize este código para completar sua verificação.</p>
            <p>Obrigado!</p>
        </div>
    </body>
    </html>';

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
        $mail->addAddress($recipientEmail, $recipientEmail);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Codigo de Verificao';
        $mail->Body    = $htmlBody;
        $mail->AltBody = 'Seu código de verificação é: ' . $code;

        $mail->send();
        return $code;
    } catch (Exception $e) {
        echo "Falha no envio do e-mail: {$mail->ErrorInfo}";
    }
}

// Exemplo de uso
// sendEmailWithCode('gustavo.rlsilva07@gmail.com');
?>
