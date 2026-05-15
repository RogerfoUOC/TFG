<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

function enviarAlertaMail($destinatari, $alert_id, $sensor, $localitzacio, $condicio, $valor, $valorSensor, $unitat) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '*****@gmail.com';
        $mail->Password   = '*****************';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('*****@gmail.com', 'Sistema d\'alertes TFG');
        $mail->addAddress($destinatari);

        $mail->isHTML(true);
        $mail->Subject = "TwinSense - Alerta #$alert_id disparada";
        $mail->Body    = "<p>S'ha detectat una condició d'alerta:</p>
                          <p><strong>$sensor $localitzacio</strong> és <strong>$condicio</strong> a <strong>$valor$unitat</strong></p>
                          <p>Valor registrat: <strong>$valorSensor$unitat</strong></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>