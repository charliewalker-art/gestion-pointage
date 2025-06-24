<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendor/PHPMailer/src/Exception.php';
require './vendor/PHPMailer/src/PHPMailer.php';
require './vendor/PHPMailer/src/SMTP.php';

function sendEmail($email, $nomEmploye, $nomExpediteur) {
    $body = "Bonjour $nomEmploye,\n\n"
          . "Nous avons constaté votre absence aujourd'hui sans notification préalable. "
          . "Merci de nous contacter rapidement pour nous en expliquer la raison.\n\n"
          . "Cordialement,\n$nomExpediteur";

    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nymendrikaantsa@gmail.com';
        $mail->Password   = 'jyffxdgcqeivwjvu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        
        
        $mail->setFrom('nymendrikaantsa@gmail.com', $nomExpediteur);
        $mail->addAddress($email, $nomEmploye);

        
        
        
        $mail->isHTML(false);
        $mail->Subject = 'Absence non justifiée';
        $mail->Body    = $body;
        $mail->AltBody = $body;
        $mail->CharSet = 'UTF-8';

        $mail->send();
        echo 'Message envoyé avec succès';
    } catch (Exception $e) {
        // Enregistrer l'erreur dans un fichier de log pour analyse
        file_put_contents('error_log.txt', date('Y-m-d H:i:s') . " - Erreur Mailer: " . $mail->ErrorInfo . PHP_EOL, FILE_APPEND);
        
        // Afficher un message générique à l'utilisateur
        echo "Impossible d'envoyer l'email. Veuillez réessayer plus tard.";
    }
}
?>