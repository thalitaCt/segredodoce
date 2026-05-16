<?php
include '../includes/conexao.php';
session_start();


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


/* DADOS */
$nome = trim($_POST['nome']);
$categoria = trim($_POST['categoria']);
$preco = str_replace(',', '.', $_POST['preco']);
$estoque = $_POST['estoque'];
$descricao = trim($_POST['descricao']);
$imagem = trim($_POST['imagem']);


/* CAMINHO PADRÃO */
$imagem = 'imagens/produtos/' . $imagem;


/* VALIDAÇÕES */
if(
    empty($nome) ||
    empty($categoria) ||
    empty($preco) ||
    empty($estoque)
){
    header("Location: criar.php?erro=campos_vazios");
    exit;
}


/* INSERT */
$sql = $pdo->prepare("
INSERT INTO produtos
(
    nome,
    categoria,
    preco,
    estoque,
    descricao,
    imagem
)

VALUES
(
    ?, ?, ?, ?, ?, ?
)
");


$sql->execute([
    $nome,
    $categoria,
    $preco,
    $estoque,
    $descricao,
    $imagem
]);

header("Location: ../gerente.php?msg=produto_criado");

exit;
?>