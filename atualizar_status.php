<?php
include 'includes/conexao.php';


$id = $_POST['id'];
$status = $_POST['status'];


$sql = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id_pedidos = ?");
$sql->execute([$status, $id]);


header("Location: atendente.php");
exit;
