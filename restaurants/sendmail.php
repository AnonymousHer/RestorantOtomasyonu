<?php
// Composer autoload dosyasını dahil et
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Sunucu ayarları
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP sunucu adresi
        $mail->SMTPAuth = true;
        $mail->Username = 'damarcanq2121@gmail.com'; // Gmail adresiniz
        $mail->Password = 'qqtt arty defo jcef'; // Gmail uygulama şifreniz
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Şifreleme türü
        $mail->Port = 587; // SMTP portu

        // Alıcılar
        $mail->setFrom('damarcanq2121@gmail.com', 'ibrahim');
        $mail->addAddress('damarcanq2121@gmail.com', 'Damar');

        // İçerik
        $mail->isHTML(true);
        $mail->Subject = 'Restorant Hakkında Yorum';
        $mail->Body    = "Name: $name<br>Email: $email<br>Message: $message";

        $mail->send();
        header('Location: contact.php?status=success');
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        header('Location: contact.php?status=error');
    }
} else {
    header('Location: contact.php');
    exit;
}
?> 