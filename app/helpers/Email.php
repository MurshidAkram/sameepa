<?php
// app/helpers/Email.php

// Manually include PHPMailer files
require_once dirname(__DIR__) . '/libraries/PHPMailer/src/Exception.php';
require_once dirname(__DIR__) . '/libraries/PHPMailer/src/PHPMailer.php';
require_once dirname(__DIR__) . '/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    /**
     * General method to send an email using PHPMailer
     *
     * @param string $toEmail Recipient's email address
     * @param string $toName Recipient's name (optional)
     * @param string $subject Email subject
     * @param string $htmlBody HTML email body
     * @param string $altBody Plain text email body (optional)
     * @return bool True if sent successfully, false otherwise
     */
    public static function sendEmail($toEmail, $toName = '', $subject, $htmlBody, $altBody = '') {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sameepa677@gmail.com';
            $mail->Password = 'dqyi pddf xcwv eaja';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('sameepa677@gmail.com', defined('SITENAME') ? SITENAME . ' Team' : 'Sameepa Team');
            $mail->addAddress($toEmail, htmlspecialchars($toName));

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $altBody ?: strip_tags($htmlBody);

            $mail->send();
            error_log("Email sent successfully to $toEmail");
            return true;
        } catch (Exception $e) {
            error_log("Email could not be sent to $toEmail. Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }

    /**
     * Send a password reset email
     *
     * @param string $userEmail User's email address
     * @param string $userName User's name
     * @param string $resetToken Password reset token
     * @return bool True if sent successfully, false otherwise
     */
    public static function sendPasswordResetEmail($userEmail, $userName, $resetToken) {
        // Fallback for undefined URLROOT
        $baseUrl = defined('URLROOT') ? URLROOT : 'http://localhost/sameepa';
        // Ensure no trailing slash
        $baseUrl = rtrim($baseUrl, '/');
        // Sanitize inputs
        $resetToken = htmlspecialchars($resetToken);
        $safeUserName = htmlspecialchars($userName);
        $safeSiteName = defined('SITENAME') ? htmlspecialchars(SITENAME) : 'Sameepa';
        $resetLink = $baseUrl . '/users/resetpassword/' . $resetToken;

        // Log the generated link for debugging
        error_log("Generated reset link: $resetLink");

        $subject = defined('SITENAME') ? SITENAME . ' - Password Reset Request' : 'Password Reset Request';

        $htmlBody = "
        <html>
        <head>
            <title>Password Reset</title>
        </head>
        <body>
            <p>Hello $safeUserName,</p>
            <p>We received a request to reset your password for your account at $safeSiteName.</p>
            <p>To reset your password, please click on the link below:</p>
            <p><a href='$resetLink'>Reset Password</a></p>
            <p>This link will expire in 1 hour.</p>
            <p>If you did not request a password reset, please ignore this email and your password will remain unchanged.</p>
            <p>Best regards,<br>$safeSiteName Team</p>
        </body>
        </html>
        ";

        $altBody = "Hello $safeUserName,\n\n"
            . "We received a request to reset your password for your account at $safeSiteName.\n\n"
            . "To reset your password, please visit this link: $resetLink\n\n"
            . "This link will expire in 1 hour.\n\n"
            . "If you did not request a password reset, please ignore this email and your password will remain unchanged.\n\n"
            . "Best regards,\n$safeSiteName Team";

        return self::sendEmail($userEmail, $safeUserName, $subject, $htmlBody, $altBody);
    }

    /**
     * Send account credentials email
     *
     * @param string $userEmail User's email address
     * @param string $userName User's full name
     * @param string $username Login username
     * @param string $password Login password
     * @param string $loginLink Link to the login page
     * @return bool True if sent successfully, false otherwise
     */
    public static function sendCredentialsEmail($userEmail, $userName, $username, $password, $loginLink) {
        $subject = defined('SITENAME') ? SITENAME . ' - Your Account Credentials' : 'Your Account Credentials';

        $safeUserName = htmlspecialchars($userName);
        $safeSiteName = defined('SITENAME') ? htmlspecialchars(SITENAME) : 'Sameepa';
        $safeUsername = htmlspecialchars($username);
        $safePassword = htmlspecialchars($password);
        $safeLoginLink = htmlspecialchars($loginLink);

        $htmlBody = "
        <html>
        <head>
            <title>Your $safeSiteName Account Credentials</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #BFAFF2; color: white; padding: 10px 20px; border-radius: 5px; }
                .content { padding: 20px; background-color: #f9f9f9; border-radius: 5px; }
                .credentials { background-color: #eee; padding: 15px; border-radius: 5px; margin: 15px 0; }
                .footer { font-size: 12px; color: #777; margin-top: 20px; }
                .button { display: inline-block; background-color: #BFAFF2; color: white; padding: 10px 20px; 
                          text-decoration: none; border-radius: 5px; margin: 15px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Welcome to $safeSiteName!</h2>
                </div>
                <div class='content'>
                    <p>Dear $safeUserName,</p>
                    <p>Your application has been approved! You can now log in to your $safeSiteName account using the following credentials:</p>
                    <div class='credentials'>
                        <p><strong>Username:</strong> $safeUsername</p>
                        <p><strong>Password:</strong> $safePassword</p>
                    </div>
                    <p>Please log in and change your password immediately for security reasons.</p>
                    <a href='$safeLoginLink' class='button'>Log in to $safeSiteName</a>
                    <p>If you have any questions, please don't hesitate to contact us.</p>
                    <p>Best regards,<br>The $safeSiteName Team</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $altBody = "Dear $safeUserName,\n\n"
            . "Your application has been approved! You can now log in to your $safeSiteName account using the following credentials:\n\n"
            . "Username: $safeUsername\n"
            . "Password: $safePassword\n\n"
            . "Please log in and change your password immediately for security reasons.\n\n"
            . "Log in here: $safeLoginLink\n\n"
            . "If you have any questions, please don't hesitate to contact us.\n\n"
            . "Best regards,\nThe $safeSiteName Team";

        return self::sendEmail($userEmail, $safeUserName, $subject, $htmlBody, $altBody);
    }
}