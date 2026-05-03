<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_GET['id'];


/* apaga cliente primeiro */
$sql = $pdo->prepare("DELETE FROM clientes WHERE usuario_id = ?");
$sql->execute([$id]);


/* depois usuário */
$sql = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
$sql->execute([$id]);


header("Location: ../gerente.php?msg=cliente_excluido");
exit;
