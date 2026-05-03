<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_GET['id'] ?? null;


if($id){
    $sql = $pdo->prepare("DELETE FROM produtos WHERE id_produtos = ?");
    $sql->execute([$id]);
}


header("Location: ../gerente.php?msg=produto_excluido");
exit;
