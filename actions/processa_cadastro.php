<?php
    include '../includes/conexao.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $nome = $_POST['nome'];
    $telefone = preg_replace('/\D/', '',$_POST['telefone']);
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $codigo = rand(100000, 999999);

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        header("Location: ../cadastro.php?erro=email_existente");
        exit;
    }

    try {
    $pdo->beginTransaction();

    $sql = "INSERT INTO usuarios (email, senha, tipo, codigo_verificacao, verificado)
    VALUES (?, ?, 'cliente', ?, false)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $senha, $codigo]);

    $id_usuario = $pdo->lastInsertId('usuarios_id_usuario_seq');

    $sql = "INSERT INTO clientes (usuario_id, nome, telefone, endereco)
    VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario, $nome, $telefone, $endereco]);

    $pdo->commit();

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
        $mail->Subject = 'Verificação de conta';

        $mail->Body = "<h2>Seu código de verificação</h2>
        <p>Olá, $nome</p>
        <p>Seu código é:</p>
        
        <h1 style='letter-spacing:5px;'>$codigo</h1>
        
        <p>Digite esse código no site para ativar sua conta.</p>";

        $mail->send();
    } catch (Exception $e) {

    } header("Location: ../verificar.php?email=$email");
      exit;
    }  catch(PDOException $e) {
        header("Location: ../cadastro.php?erro=geral");
        exit;
    }
?>
