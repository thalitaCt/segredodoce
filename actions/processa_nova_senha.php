<?php
include '../includes/conexao.php';


/* =========================
   VALIDAR DADOS
========================= */


$token = $_POST['token'] ?? null;
$senha = $_POST['senha'] ?? null;
$senha_confirmar = $_POST['senha_confirmar'] ?? null;


if (empty($token) || empty($senha)) {
    header("Location: ../login.php?erro=token_invalido");
    exit;
}


/* =========================
   CONFIRMAR SENHAS
========================= */


if ($senha !== $senha_confirmar) {
    header("Location: ../nova_senha.php?token=$token&erro=senhas_diferentes");
    exit;
}


/* =========================
   CRIPTOGRAFAR SENHA
========================= */


$senhaHash = password_hash($senha, PASSWORD_DEFAULT);


/* =========================
   VALIDAR TOKEN
========================= */


$sql = "SELECT * FROM usuarios WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute(['token' => $token]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$usuario) {
    header("Location: ../login.php?erro=token_invalido");
    exit;
}


/* =========================
   ATUALIZAR SENHA
========================= */


$sql = "UPDATE usuarios 
        SET senha = :senha, 
            token = NULL, 
            token_expira = NULL 
        WHERE token = :token";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    'senha' => $senhaHash,
    'token' => $token
]);


/* =========================
   REDIRECIONAR
========================= */


header("Location: ../login.php?msg=senha_alterada");
exit;
?>