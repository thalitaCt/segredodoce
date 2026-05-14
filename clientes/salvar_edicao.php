<?php
include '../includes/conexao.php';
session_start();

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];

$telefone = preg_replace('/\D/', '', $_POST['telefone']);

$cep = preg_replace('/\D/', '', $_POST['cep'] ?? '');
$endereco = $_POST['endereco'] ?? '';
$numero = $_POST['numero'] ?? '';
$bairro = $_POST['bairro'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$estado = $_POST['estado'] ?? '';
$regiao = $_POST['regiao'] ?? '';

/* VALIDAÇÃO ANTES DE SALVAR */
if (strlen($telefone) != 11) {
    header("Location: editar.php?id=$id&erro=telefone_invalido");
    exit;
}

/* atualiza usuario */
$sql = $pdo->prepare("UPDATE usuarios SET email=? WHERE id_usuario=?");
$sql->execute([$email, $id]);

/* atualiza cliente COMPLETO */
$sql = $pdo->prepare("
UPDATE clientes 
SET 
    nome=?,
    telefone=?,
    cep=?,
    endereco=?,
    numero=?,
    bairro=?,
    cidade=?,
    estado=?,
    regiao=?
WHERE usuario_id=?
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
    $id
]);

header("Location: ../gerente.php?msg=cliente_editado");
exit;
?>
