<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo json_encode(['error' => 'Las contraseñas no coinciden']);
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;          // Autenticación SMTP activada
        $mail->Username = 'beelbonacossa@gmail.com';  // Tu correo electrónico
        $mail->Password = '';         // Tu contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Habilitar cifrado TLS
        $mail->Port = 587;  // Puerto TCP para conexión SMTP

        // Configuración del correo de origen y destino
        $mail->setFrom('beelbonacossa@gmail.com', '<No Responder>');  // Dirección de correo de origen
        $mail->addAddress($email, $nombre . ' ' . $apellido);     // Agregar destinatario

        // Contenido del correo electrónico
        $mail->isHTML(true);  // Formato HTML
        $mail->Subject = 'Confirmación de Registro';  // Asunto del correo
        $mail->Body = 'Haz clic en el siguiente enlace para confirmar tu registro: <a href="http://localhost/tp1/confirmar.php?email=' . urlencode($email) . '">Confirmar Registro</a>';  // Cuerpo del correo en HTML
        $mail->AltBody = 'Haz clic en el siguiente enlace para confirmar tu registro: http://localhost/tp1/confirmar.php?email=' . urlencode($email);  // Texto plano alternativo

        // Enviar el correo electrónico
        $mail->send();
        echo json_encode(['mensaje' => 'Correo de confirmación enviado correctamente.']);
    } catch (Exception $e) {
        echo json_encode(['error' => "Error al enviar el correo: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>