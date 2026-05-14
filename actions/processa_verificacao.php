<?php
include '../includes/conexao.php';


/* =========================
   PEGAR DADOS
========================= */


$email = $_POST['email'] ?? null;
$codigo = $_POST['codigo'] ?? null;


/* =========================
   VALIDAÇÃO BÁSICA
========================= */


if (empty($email) || empty($codigo)) {
    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}


/* limpa espaços */
$codigo = trim($codigo);


/* =========================
   BUSCAR USUÁRIO
========================= */


$sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


/* =========================
   VALIDAR USUÁRIO
========================= */


if (!$usuario) {
    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}


/* =========================
   VALIDAR CÓDIGO
========================= */


if ((string)$usuario['codigo_verificacao'] !== (string)$codigo) {
    header("Location: ../verificar.php?email=$email&erro=codigo");
    exit;
}


/* =========================
   ATUALIZAR CONTA
========================= */


$sql = "UPDATE usuarios 
        SET verificado = TRUE, 
            codigo_verificacao = NULL 
        WHERE email = :email";


$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


/* =========================
   REDIRECIONAR
========================= */


header("Location: ../login.php?msg=verificado");
exit;
?>