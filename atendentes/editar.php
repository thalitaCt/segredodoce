<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_GET['id'];


$sql = $pdo->prepare("
SELECT f.*, u.email
FROM funcionarios f
JOIN usuarios u ON u.id_usuario = f.usuario_id
WHERE f.usuario_id = ?
");


$sql->execute([$id]);
$atendente = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="form-card">
<h2>Editar Atendente</h2>

<form method="POST" action="salvar_edicao.php">

<input type="hidden" name="id" value="<?= $atendente['usuario_id'] ?>">

<input type="text" name="nome" value="<?= $atendente['nome'] ?>" required>
<input type="email" name="email" value="<?= $atendente['email'] ?>" required>
<input type="text" name="cargo" value="<?= $atendente['cargo'] ?>" required>
<input type="text" name="telefone" value="<?= $atendente['telefone'] ?>" required>
<input type="number" step="0.01" name="salario" value="<?= $atendente['salario'] ?>" required>

<button type="submit">Salvar alterações</button>
</form>
</div>


</body>
</html>
