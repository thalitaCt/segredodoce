<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="form-card">
<h2>Cadastrar Atendente</h2>

<form method="POST" action="salvar_criacao.php">

<input type="text" name="nome" placeholder="Nome" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="senha" placeholder="Senha" required>

<input type="text" name="cargo" placeholder="Cargo" value="Recepcionista" required>
<input type="text" name="telefone" placeholder="Telefone" required>
<input type="number" step="0.01" name="salario" placeholder="Salário" required>

<button type="submit">Criar Atendente</button>

</form>
</div>

</body>
</html>