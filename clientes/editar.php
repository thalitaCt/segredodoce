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

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php if(isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'email_existente') echo "E-mail já cadastrado";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<div class="form-card">

<h2>Editar Cliente</h2>

<form method="POST" action="salvar_edicao.php">

<input type="hidden" name="id" value="<?= $cliente['usuario_id'] ?>">

<input type="text" name="nome" value="<?= $cliente['nome'] ?>">
<input type="email" name="email" value="<?= $cliente['email'] ?>">
<input type="text" name="telefone" value="<?= $cliente['telefone'] ?>">
<input type="text" name="endereco" value="<?= $cliente['endereco'] ?>">

<button type="submit">Salvar</button>

</form>
</div>

</body>
</html>