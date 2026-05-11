<?php
session_start();


include '../includes/conexao.php';


if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit;
}


$idUsuario = $_SESSION['id'];


$nome = $_POST['nome'];


$telefone = preg_replace('/\D/', '', $_POST['telefone']);


$cep = preg_replace('/\D/', '', $_POST['cep']);


$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = strtoupper($_POST['estado']);


$sql = $pdo->prepare("
UPDATE clientes
SET
    nome = ?,
    telefone = ?,
    cep = ?,
    endereco = ?,
    numero = ?,
    bairro = ?,
    cidade = ?,
    estado = ?
WHERE usuario_id = ?
");


$sql->execute([
    $nome,
    $telefone,
    $cep,
    $endereco,
    $numero,
    $bairro,
    $cidade,
    $estado,
    $idUsuario
]);


$_SESSION['nome'] = $nome;


header("Location: ../minha_conta.php?msg=salvo");
exit;
?>