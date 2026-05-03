<?php
session_start();
include '../includes/conexao.php';


$id = $_GET['id'];


$sql = $pdo->prepare("
SELECT c.*, u.email
FROM clientes c
JOIN usuarios u ON u.id_usuario = c.usuario_id
WHERE c.usuario_id = ?
");


$sql->execute([$id]);
$cliente = $sql->fetch(PDO::FETCH_ASSOC);
?>


<form method="POST" action="salvar_edicao.php">


<input type="hidden" name="id" value="<?= $cliente['usuario_id'] ?>">


<input type="text" name="nome" value="<?= $cliente['nome'] ?>">
<input type="email" name="email" value="<?= $cliente['email'] ?>">
<input type="text" name="telefone" value="<?= $cliente['telefone'] ?>">
<input type="text" name="endereco" value="<?= $cliente['endereco'] ?>">


<button type="submit">Salvar</button>


</form>
