<?php
include '../includes/conexao.php';
session_start();


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_POST['id'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];
$estoque = $_POST['estoque'];


$sql = $pdo->prepare("
UPDATE produtos 
SET nome=?, preco=?, estoque=? 
WHERE id_produtos=?
");


$sql->execute([$nome, $preco, $estoque, $id]);


header("Location: ../gerente.php?msg=produto_editado");
exit;
