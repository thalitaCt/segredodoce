<?php
include '../includes/conexao.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = $_POST['email'];

$codigo = rand(100000,999999);

$sql = $pdo->prepare("
UPDATE usuarios
SET codigo_verificacao = ?
WHERE email = ?
");

$sql->execute([$codigo, $email]);

$mail = new PHPMailer(true);

try {
$mail->isSMTP();
$mail->Host = 'smtp.sendgrid.net';
$mail->SMTPAuth = true;
$mail->Username = 'apikey';
$mail->Password = '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';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->CharSet = 'UTF-8';

$mail->setFrom('confeitariasegredoce@gmail.com', 'Segredo Doce');
$mail->addAddress($email);

$mail->isHTML(true);

$mail->Subject = 'Novo código de verificação';

$mail->Body = "
<h2>Seu novo código</h2>
<h1>$codigo</h1>
<p>Use este código para verificar sua conta.</p>
";

$mail->send();
} catch (Exception $e) {
    echo "Erro: " . $mail->ErrorInfo;
    exit;

} header("Location: ../verificar.php?email=$email&msg=reenviado");
  exit;
?>
