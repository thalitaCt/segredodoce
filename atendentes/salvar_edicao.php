<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$telefone = preg_replace('/\D/', '', $_POST['telefone']);
$salario = $_POST['salario'];


try {


    /* atualiza usuario */
    $sql = $pdo->prepare("
        UPDATE usuarios
        SET email = ?
        WHERE id_usuario = ?
    ");
    $sql->execute([$email, $id]);


    /* atualiza funcionario */
    $sql = $pdo->prepare("
        UPDATE funcionarios
        SET nome = ?, cargo = ?, telefone = ?, salario = ?
        WHERE usuario_id = ?
    ");


    $sql->execute([$nome, $cargo, $telefone, $salario, $id]);


    header("Location: ../gerente.php?msg=gerente_editado");
    exit;


} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
