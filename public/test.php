<?php
require_once '../app/bootstrap.php'; // Adjust path to your bootstrap file
$result = Email::sendPasswordResetEmail('sankavithayaparan@example.com', 'Test User', 'test123token');
echo $result ? 'Email sent' : 'Email failed';
?>