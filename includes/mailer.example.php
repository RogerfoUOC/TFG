<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

function enviarAlertaMail($destinatari, $alert_id, $sensor, $localitzacio, $condicio, $valor, $valorSensor, $unitat, $data) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '*****@gmail.com';
        $mail->Password   = '***************';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('*****@gmail.com', 'Sistema d\'alertes TFG');
        $mail->addAddress($destinatari);

        $mail->isHTML(true);
        $mail->Subject = "TwinSense - Alerta #$alert_id disparada";
        $template = file_get_contents(__DIR__ . '/template-mail.html');
        $mail->Body = str_replace(
            ['{{SENSOR}}', '{{LOCALITZACIO}}', '{{CONDICIO}}', '{{VALOR_LLINDAR}}', '{{VALOR_SENSOR}}', '{{UNITAT}}', '{{DATA}}', '{{ALERT_ID}}'],
            [$sensor, $localitzacio, $condicio, $valor, $valorSensor, $unitat, $data, $alert_id],
            $template
        );
        $mail->AltBody = "Alerta #$alert_id: $sensor $localitzacio és $condicio a $valor$unitat. Valor registrat: $valorSensor$unitat - $data";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>