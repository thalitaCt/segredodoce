<?php
session_start();
include '../includes/conexao.php';

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$telefone = preg_replace('/\D/', '', $_POST['telefone']);

/* VALIDA EMAIL */
$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$sql->execute([$email]);

if($sql->rowCount() > 0){
    header("Location: criar.php?erro=email_existente");
    exit;
}

if(strlen($telefone) != 11){
    header("Location: criar.php?erro=telefone_invalido");
    exit;
}

try {

    /* CRIA USUÁRIO */
    $sql = $pdo->prepare("
        INSERT INTO usuarios (email, senha, tipo, verificado)
        VALUES (?, ?, 'cliente', true)
    ");

    $sql->execute([$email, $senha]);

    $usuario_id = $pdo->lastInsertId();

    /* CRIA CLIENTE (ATUALIZADO COM SEU SISTEMA REAL) */
    $sql = $pdo->prepare("
        INSERT INTO clientes
        (usuario_id, nome, telefone, cep, endereco, numero, bairro, cidade, estado, regiao)
        VALUES (?, ?, ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
    ");

    $sql->execute([
        $usuario_id,
        $nome,
        $telefone
    ]);

    header("Location: ../gerente.php?msg=cliente_criado");
    exit;

} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
?>
