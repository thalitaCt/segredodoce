<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_GET['id'];


$sql = $pdo->prepare("SELECT * FROM produtos WHERE id_produtos = ?");
$sql->execute([$id]);
$produto = $sql->fetch(PDO::FETCH_ASSOC);
?>


<form method="POST" action="salvar_edicao.php">
    <input type="hidden" name="id" value="<?= $produto['id_produtos'] ?>">


    <input type="text" name="nome" value="<?= $produto['nome'] ?>">
    <input type="number" name="preco" value="<?= $produto['preco'] ?>">
    <input type="number" name="estoque" value="<?= $produto['estoque'] ?>">


    <button type="submit">Salvar</button>
</form>
