<?php
include '../includes/conexao.php';
session_start();


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$nome = $_POST['nome'];
$preco = $_POST['preco'];
$estoque = $_POST['estoque'];


$sql = $pdo->prepare("
INSERT INTO produtos (nome, preco, estoque)
VALUES (?, ?, ?)
");


$sql->execute([$nome, $preco, $estoque]);


header("Location: ../gerente.php?msg=produto_criado");
exit;
