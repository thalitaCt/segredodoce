<?php
include '../includes/conexao.php';


$email = $_POST['email'] ?? null;
$codigo = $_POST['codigo'] ?? null;


/* VALIDAÇÃO BÁSICA */
if (empty($email) || empty($codigo)) {
    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}


/* BUSCAR USUÁRIO */
$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


/* VERIFICAÇÃO */
if (
    $usuario &&
    isset($usuario['codigo_verificacao']) &&
    (string)$usuario['codigo_verificacao'] === (string)$codigo
) {


    /* ATUALIZAR USUÁRIO */
    $sql = "
        UPDATE usuarios 
        SET verificado = 1, 
            codigo_verificacao = NULL 
        WHERE email = :email
    ";


    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);


    header("Location: ../login.php?msg=verificado");
    exit;


} else {


    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}
?>