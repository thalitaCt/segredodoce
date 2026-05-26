<?php
session_start();
include 'includes/conexao.php';

if(
    !isset($_SESSION['tipo'])
    ||
    (
        $_SESSION['tipo'] != 'atendente'
        &&
        $_SESSION['tipo'] != 'master'
    )
){
    header("Location: login.php");
    exit;
}

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

$statusesValidos = [
    'Pedido Confirmado',
    'Pendente',
    'Em preparo',
    'Pronto',
    'Entregue',
    'Cancelado'
];

if(!$id || !in_array($status, $statusesValidos)){
    header("Location: atendente.php?msg=erro_status");
    exit;
}

$sql = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id_pedidos = ?");
$sql->execute([$status, $id]);

header("Location: atendente.php?msg=status_atualizado");
exit;
?>
