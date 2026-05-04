<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_GET['id'];


try {


    /* primeiro remove funcionario */
    $sql = $pdo->prepare("DELETE FROM funcionarios WHERE usuario_id = ?");
    $sql->execute([$id]);


    /* depois remove usuario */
    $sql = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $sql->execute([$id]);


    header("Location: ../gerente.php?msg=gerente_excluido");
    exit;


} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
