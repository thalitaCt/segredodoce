<?php 
    include '../includes/conexao.php';

    $token = $_POST['token'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM usuarios WHERE token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['token' => $token]);
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $sql = "UPDATE usuarios SET senha = :senha, token = NULL, token_expira = NULL WHERE token = :token";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'senha' => $senha,
            'token' => $token
        ]);
        header("Location: ../login.php?msg=senha_alterada");
        exit;
    } else {
        echo "Token inválido";
    }
?>