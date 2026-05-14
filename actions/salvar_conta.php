<?php
session_start();
include '../includes/conexao.php';

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit;
}

$idUsuario = $_SESSION['id'];

$nome = trim($_POST['nome']);
$telefone = preg_replace('/\D/', '', $_POST['telefone']);
$cep = preg_replace('/\D/', '', $_POST['cep']);
$endereco = trim($_POST['endereco']);
$numero = trim($_POST['numero']);
$bairro = trim($_POST['bairro']);
$cidade = trim($_POST['cidade']);
$estado = strtoupper(trim($_POST['estado']));
$regiao = trim($_POST['regiao']);

/* =========================
   VALIDAÇÕES IMPORTANTES
========================= */

if(strlen($telefone) != 11){
    header("Location: ../minha_conta.php?erro=telefone_invalido");
    exit;
}

if(strlen($cep) != 8){
    header("Location: ../minha_conta.php?erro=cep_invalido");
    exit;
}

$estadosValidos = [
"AC","AL","AP","AM","BA","CE","DF","ES","GO","MA",
"MT","MS","MG","PA","PB","PR","PE","PI","RJ","RN",
"RS","RO","RR","SC","SP","SE","TO"
];

if(!in_array($estado, $estadosValidos)){
    header("Location: ../minha_conta.php?erro=estado_invalido");
    exit;
}

$regioesValidas = [
"Centro",
"Zona Sul",
"Zona Norte",
"Zona Oeste",
"Entrega Externa"
];

if(!in_array($regiao, $regioesValidas)){
    header("Location: ../minha_conta.php?erro=regiao_invalida");
    exit;
}

/* =========================
   ATUALIZA NO BANCO
========================= */

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

header("Location: ../minha_conta.php?msg=salvo");
exit;
?>
