<?php
    include '../includes/conexao.php';

    $email = $_POST['email'];
    $codigo = $_POST['codigo'];

    $sql = "SELECT * FROM clientes WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $usuario['codigo_verificacao'] == $codigo) {
        $sql = "UPDATE clientes SET verificado = true, codigo_verificacao = NULL WHERE email = :email";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        header("Location: ../login.php?msg=verificado");
        exit;
    } else {
        header("Location: ../verificar.php?email=$email&erro=codigo");
        exit;
    }
?>