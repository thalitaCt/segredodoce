<?php
    session_start();
    
    include '../includes/conexao.php';

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM clientes WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario['email'];
            $_SESSION['nome'] = $usuario['nome'];

            if (!$usuario['verificado']) {
            header("Location: ../verificar.php?erro=nao_verificado&email=$email");
            exit;
    }

            header("Location: ../index.php?msg=login_sucesso");
            exit;
        } else {
            header("Location: ../login.php?erro=senha");
            exit;
        }
    } else {
        header ("Location: ../login.php?erro=email");
        exit;
    }

    
?> 