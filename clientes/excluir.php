<?php
session_start();
include '../includes/conexao.php';

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: ../gerente.php?erro=id_invalido");
    exit;
}

try {

    /* opcional: verifica se existe */
    $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = ?");
    $sql->execute([$id]);

    if($sql->rowCount() == 0){
        header("Location: ../gerente.php?erro=cliente_nao_encontrado");
        exit;
    }

    /* remove cliente */
    $sql = $pdo->prepare("DELETE FROM clientes WHERE usuario_id = ?");
    $sql->execute([$id]);

    /* remove usuário */
    $sql = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $sql->execute([$id]);

    header("Location: ../gerente.php?msg=cliente_excluido");
    exit;

} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
?>
