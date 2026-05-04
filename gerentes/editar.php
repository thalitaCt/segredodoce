<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'admin'){
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
$g = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php if(isset($_GET['msg'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'email_existente') echo "E-mail já cadastrado";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<div class="form-card">
<h2>Editar Gerente</h2>

<form method="POST" action="salvar_edicao.php">

<input type="hidden" name="id" value="<?= $g['usuario_id'] ?>">

<input type="text" name="nome" value="<?= $g['nome'] ?>" required>
<input type="email" name="email" value="<?= $g['email'] ?>" required>
<input type="text" name="cargo" value="<?= $g['cargo'] ?>" required>
<input type="text" name="telefone" value="<?= $g['telefone'] ?>" required>
<input type="number" step="0.01" name="salario" value="<?= $g['salario'] ?>" required>

<button type="submit">Salvar alterações</button>
</form>
</div>


</body>
</html>