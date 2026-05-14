<?php
include '../includes/conexao.php';


$token = $_POST['token'] ?? null;
$senha = $_POST['senha'] ?? null;


/* VALIDAÇÃO BÁSICA */
if (empty($token) || empty($senha)) {
    header("Location: ../login.php?erro=reset_invalido");
    exit;
}


/* BUSCAR USUÁRIO PELO TOKEN */
$sql = "SELECT * FROM usuarios WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute(['token' => $token]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


/* VALIDAR TOKEN */
if (!$usuario) {
    header("Location: ../login.php?erro=token_invalido");
    exit;
}


/* VALIDAR EXPIRAÇÃO DO TOKEN */
if (strtotime($usuario['token_expira']) < time()) {
    header("Location: ../login.php?erro=token_expirado");
    exit;
}


/* GERAR HASH DA SENHA */
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);


/* ATUALIZAR SENHA E LIMPAR TOKEN */
$sql = "
    UPDATE usuarios 
    SET senha = :senha, 
        token = NULL, 
        token_expira = NULL 
    WHERE id_usuario = :id
";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    'senha' => $senhaHash,
    'id' => $usuario['id_usuario']
]);


/* REDIRECIONAMENTO */
header("Location: ../login.php?msg=senha_alterada");
exit;
?>