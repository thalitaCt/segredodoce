<?php
include '../includes/conexao.php';
session_start();


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = preg_replace('/\D/', '', $_POST['telefone']);
$endereco = $_POST['endereco'];


/* atualiza usuario */
$sql = $pdo->prepare("UPDATE usuarios SET email=? WHERE id_usuario=?");
$sql->execute([$email, $id]);


/* atualiza cliente */
$sql = $pdo->prepare("
UPDATE clientes 
SET nome=?, telefone=?, endereco=? 
WHERE usuario_id=?
");


$sql->execute([$nome, $telefone, $endereco, $id]);

if (strlen($telefone) != 11) {
    header("Location: salvar_edicao.php?erro=telefone_invalido");
    exit;
}


header("Location: ../gerente.php?msg=cliente_editado");
exit;
