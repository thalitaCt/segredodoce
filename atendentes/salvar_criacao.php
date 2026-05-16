<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$cargo = $_POST['cargo'];
$telefone = preg_replace('/\D/', '', $_POST['telefone']);
$salario = $_POST['salario'];


/* 🔴 validação de email */
$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$sql->execute([$email]);


if($sql->rowCount() > 0){
    header("Location: criar.php?erro=email_existente");
    exit;
}

if (strlen($telefone) != 11) {
    header("Location: salvar_criacao.php?erro=telefone_invalido");
    exit;
}


try {


    /* cria usuario */
    $sql = $pdo->prepare("
        INSERT INTO usuarios (email, senha, tipo, verificado)
        VALUES (?, ?, 'atendente', true)
        RETURNING id_usuario
    ");


    $sql->execute([$email, $senha]);
    $usuario_id = $sql->fetchColumn();


    /* cria funcionario */
    $sql = $pdo->prepare("
        INSERT INTO funcionarios (usuario_id, nome, cargo, salario, telefone)
        VALUES (?, ?, ?, ?, ?)
    ");


    $sql->execute([$usuario_id, $nome, $cargo, $salario, $telefone]);


    header("Location: ../gerente.php?msg=gerente_criado");
    exit;


} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
