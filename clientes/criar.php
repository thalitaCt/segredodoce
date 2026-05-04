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

<h2>Cadastrar Cliente</h2>

<form method="POST" action="salvar_criacao.php">

<input type="text" name="nome" placeholder="Nome" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="senha" placeholder="Senha" required>
<input type="text" name="telefone" placeholder="Telefone" required>
<input type="text" name="endereco" placeholder="Endereço">

<button type="submit">Criar Cliente</button>

</form>
</div>

</body>
</html>