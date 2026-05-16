<?php
include '../includes/conexao.php';
session_start();


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_POST['id'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$categoria = $_POST['categoria'];
$preco = str_replace(',', '.', $_POST['preco']);
$estoque = $_POST['estoque'];
$imagem = trim($_POST['imagem']);

$imagem = 'imagens/produtos/' . $imagem;


/* atualiza produto */
$sql = $pdo->prepare("
UPDATE produtos 
SET 
nome = ?,
descricao = ?,
categoria = ?,
preco = ?,
estoque = ?,
imagem = ?
WHERE id_produtos = ?
");


$sql->execute([
    $nome,
    $descricao,
    $categoria,
    $preco,
    $estoque,
    $imagem,
    $id
]);


header("Location: ../gerente.php?msg=produto_editado");
exit;
?>