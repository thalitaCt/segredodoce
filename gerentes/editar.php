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

<?php if(isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'telefone_invalido') echo "Número de celular inválido. Use DDD + número (ex: 21999999999).";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<div class="form-card">
<h2>Editar Gerente</h2>

<form method="POST" action="salvar_edicao.php">

<input
type="hidden"
name="id"
value="<?= $g['usuario_id'] ?>">

<div class="form-grid funcionario-grid">

<div class="input-group">
<label>Nome</label>

<input
type="text"
name="nome"
value="<?= $g['nome'] ?>"
required>
</div>

<div class="input-group">
<label>Email</label>

<input
type="email"
name="email"
value="<?= $g['email'] ?>"
required>
</div>

<div class="input-group">
<label>Telefone</label>

<input
type="text"
id="telefone"
name="telefone"
maxlength="15"
value="<?= $g['telefone'] ?>"
required>
</div>

<div class="input-group">
<label>Cargo</label>

<input
type="text"
name="cargo"
value="<?= $g['cargo'] ?>"
readonly>
</div>

<div class="input-group">
<label>Salário</label>

<input
type="number"
step="0.01"
name="salario"
value="<?= $g['salario'] ?>"
required>
</div>

</div>

<button type="submit">
Salvar alterações
</button>

</form>
</div>

<script>
        document.getElementById('telefone').addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g,'');

        if (v.length > 11) v = v.slice(0, 11);

        v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
        v = v.replace(/(\d{5})(\d{4})$/,"$1-$2");

        e.target.value = v;
});

    </script>

</body>
</html>
