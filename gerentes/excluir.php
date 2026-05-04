<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'admin'){
    header("Location: ../login.php");
    exit;
}


$id = $_GET['id'];


try {

    $sql = $pdo->prepare("DELETE FROM funcionarios WHERE usuario_id = ?");
    $sql->execute([$id]);


    $sql = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $sql->execute([$id]);


    header("Location: ../admin.php?msg=gerente_excluido");
    exit;


} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
