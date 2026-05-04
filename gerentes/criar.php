<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="form-card">

<h2>Cadastrar Gerente</h2>

<form action="salvar_criacao.php" method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="telefone" placeholder="Telefone">
    <input type="text" name="cargo" placeholder="Cargo" value="Gerente" required>
    <input type="number" step="0.01" name="salario" placeholder="Salário" required>
    <input type="password" name="senha" placeholder="Senha" required>

    <button type="submit">Cadastrar</button>
</form>
</div>

</body>
</html>