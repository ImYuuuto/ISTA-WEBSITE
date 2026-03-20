<?php
/**
 * mail_helper.php
 * Sends emails via Gmail SMTP using PHPMailer.
 * Requires: composer require phpmailer/phpmailer
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendPasswordResetEmail(string $toEmail, string $resetLink): bool
{
    $configPath = __DIR__ . '/../../config/mail_config.php';
    if (!file_exists($configPath)) {
        error_log('Mail config not found. Copy config/mail_config.example.php to config/mail_config.php');
        return false;
    }

    $config = require $configPath;
    if (empty($config['smtp_username']) || empty($config['smtp_password']) || strpos($config['smtp_username'], 'your-email') !== false) {
        error_log('Mail config not configured. Edit config/mail_config.php with your Gmail credentials.');
        return false;
    }

    $vendorPath = __DIR__ . '/../../vendor/autoload.php';
    if (!file_exists($vendorPath)) {
        error_log('Composer dependencies not installed. Run: composer install');
        return false;
    }

    require_once $vendorPath;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $config['smtp_host'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['smtp_username'];
        $mail->Password   = $config['smtp_password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $config['smtp_port'] ?? 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($config['from_email'] ?? $config['smtp_username'], $config['from_name'] ?? 'Établissement');
        $mail->addAddress($toEmail);
        $mail->Subject = 'Réinitialisation de votre mot de passe';
        $mail->isHTML(true);
        $mail->Body = '
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 500px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #0a2540;">Réinitialisation du mot de passe</h2>
        <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
        <p>Cliquez sur le lien ci-dessous pour définir un nouveau mot de passe :</p>
        <p style="margin: 25px 0;">
            <a href="' . htmlspecialchars($resetLink) . '" style="background-color: #2ecc71; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Réinitialiser mon mot de passe</a>
        </p>
        <p style="font-size: 12px; color: #666;">Ce lien expire dans 1 heure. Si vous n\'avez pas demandé cette réinitialisation, ignorez cet email.</p>
        <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
        <p style="font-size: 11px; color: #999;">Établissement OFPPT</p>
    </div>
</body>
</html>';
        $mail->AltBody = "Réinitialisation du mot de passe. Cliquez sur ce lien : " . $resetLink;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mail send failed: ' . $mail->ErrorInfo);
        return false;
    }
}
