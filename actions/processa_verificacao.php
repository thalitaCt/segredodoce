<?php
include '../includes/conexao.php';


$email = $_POST['email'] ?? null;
$codigo = $_POST['codigo'] ?? null;


if (empty($email) || empty($codigo)) {
    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}


$codigo = trim($codigo);


$sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$usuario) {
    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}


if ((string)$usuario['codigo_verificacao'] !== (string)$codigo) {
    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}


$sql = "UPDATE usuarios 
        SET verificado = TRUE, 
            codigo_verificacao = NULL 
        WHERE email = :email";


$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


header("Location: ../login.php?msg=verificado");
exit;
?>