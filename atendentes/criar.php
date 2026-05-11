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
<h2>Cadastrar Atendente</h2>

<form method="POST" action="salvar_criacao.php">

<input type="text" name="nome" placeholder="Nome" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="senha" placeholder="Senha" required>
<input type="text" name="cargo" placeholder="Cargo" value="Recepcionista" required>
<input type="text" id="telefone" name="telefone" placeholder="Telefone" maxlength="15" required>
<input type="number" step="0.01" name="salario" placeholder="Salário" required>

<button type="submit">Criar Atendente</button>

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