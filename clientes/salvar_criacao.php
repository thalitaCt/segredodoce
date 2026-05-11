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
$telefone = preg_replace('/\D/', '', $_POST['telefone']);
$endereco = $_POST['endereco'];


/* 🔴 VALIDAÇÃO DE EMAIL (ANTES DE INSERIR) */
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


    /* cria usuário */
    $sql = $pdo->prepare("
        INSERT INTO usuarios (email, senha, tipo, verificado)
        VALUES (?, ?, 'cliente', true)
        RETURNING id_usuario
    ");


    $sql->execute([$email, $senha]);
    $usuario_id = $sql->fetchColumn();


    /* cria cliente */
    $sql = $pdo->prepare("
        INSERT INTO clientes (usuario_id, nome, telefone, endereco)
        VALUES (?, ?, ?, ?)
    ");


    $sql->execute([$usuario_id, $nome, $telefone, $endereco]);


    header("Location: ../gerente.php?msg=cliente_criado");
    exit;


} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
