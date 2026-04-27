<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    include '../includes/conexao.php';

    $email = $_POST['email'];

    $sql = "SELECT * FROM  clientes WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $token = bin2hex(random_bytes(16));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $sql = "UPDATE clientes SET token = :token, token_expira = :expira WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'token' => $token,
            'expira' => $expira,
            'email' => $email
        ]);

        $link = "http://segredodoce.onrender.com//nova_senha.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'confeitariasegredoce@gmail.com';
            $mail->Password = 'pulr odxm kcqw bkhw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom('confeitariasegredoce@gmail.com', 'Segredo Doce');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de Senha';
            
            $mail->Body = "
            <table width='100%'
            style='background:#f0f0f0; padding:20px;'>
            <tr><td align='center'>
            <table width='500'
            style='background:#fff;
            border-radius:10px; font-family:Arial;'>

        <tr>
            <td style='background:#ff877d; padding:20px; text-align:center; color:white; font-size:24px;'>
            Segredo Doce
                </td>
        </tr>

        <tr>
        <td style='padding:30px;'>

        <h2>Recuperação de Senha</h2>

        <p>Olá, {$usuario['nome']}</p>
        <p>Clique no botão abaixo para redefinir sua senha;</p>

        <div style='text-align:center; margin:30px 0;'>
        <a href='$link' style='background:#ff877d; color:white; padding:12px 25px; text-decoration:none; border-radius:5px; font-weight:bold;'>Redefinir Senha</a>

        <p style='font-size:12px; color:#777;'>
        Este link expira em 1 hora. </p>
        </td>
        </tr>

        <tr>
        <td stle='background:#f0f0f0; padding:15px; text-align:center; font-size:12px;'>
        @ 2026 SegredoDoce
        </td
        </tr>
        </table
        </td></tr>
        </table>";

        $mail->send();
        
        header("Location: ../login.php?msg=email_enviado");
        exit;
        } catch (Exception $e) {
            echo "Erro: {$mail->ErrorInfo}";
        }
    } else {
        header ("Location: ../esqueci_senha.php?erro=email");
        exit;
    }
?>