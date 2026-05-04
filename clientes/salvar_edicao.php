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
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];

$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$sql->execute([$email]);


if($sql->rowCount() > 0){
    header("Location: editar.php?id=$id&&erro=email_existente");
    exit;
}


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


header("Location: ../gerente.php?msg=cliente_editado");
exit;
