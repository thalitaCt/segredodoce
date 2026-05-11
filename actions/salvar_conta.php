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
$regiao = $_POST['regiao'];


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
    estado = ?,
    regiao = ?
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
    $regiao,
    $idUsuario
]);

$_SESSION['nome'] = $nome;

// Nome vazio
if (empty($nome)) {
    header("Location: minha_conta.php?erro=nome_vazio");
    exit;
}

if (empty($cep)) {
    header("Location: minha_conta.php?erro=cep_vazio");
    exit;
}

// Telefone vazio
if (empty($telefone)) {
    header("Location: minha_conta.php?erro=telefone_vazio");
    exit;
}

if (strlen($telefone) != 11) {
    header("Location: minha_conta.php?erro=telefone_invalido");
    exit;
}


// CEP inválido
if (!empty($cep) && strlen(preg_replace('/\D/', '', $cep)) != 8) {
    header("Location: minha_conta.php?erro=cep_invalido");
    exit;
}


// Região não selecionada
if (empty($regiao)) {
    header("Location: minha_conta.php?erro=regiao_vazia");
    exit;
}

// SUCESSO (aqui você salva no banco antes)
header("Location: minha_conta.php?msg=salvo");
exit;

?>