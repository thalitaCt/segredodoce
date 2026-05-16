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

<div class="form-grid funcionario-grid">

<div class="input-group">
<label>Nome</label>

<input
type="text"
name="nome"
placeholder="Nome completo"
required>
</div>

<div class="input-group">
<label>Email</label>

<input
type="email"
name="email"
placeholder="email@exemplo.com"
required>
</div>

<div class="input-group">
<label>Telefone</label>

<input
type="text"
id="telefone"
name="telefone"
placeholder="(21) 99999-9999"
maxlength="15"
required>
</div>

<div class="input-group">
<label>Cargo</label>

<input
type="text"
name="cargo"
value="Atendente"
readonly>
</div>

<div class="input-group">
<label>Salário</label>

<input
type="number"
step="0.01"
name="salario"
placeholder="0,00"
required>
</div>

<div class="input-group">
<label>Senha</label>

<input
type="password"
id="senha"
name="senha"
placeholder="Senha"
required>
</div>

<div class="input-group">
<label>Confirmar senha</label>

<input
type="password"
id="confirmarSenha"
placeholder="Confirmar senha"
required>

<div class="erro-senha" id="erroSenha">
As senhas não coincidem
</div>

</div>

</div>

<button type="submit" id="btnSubmit">
Cadastrar
</button>

</form>
</div>

<script>

document.getElementById('telefone').addEventListener('input', function(e){

    let v = e.target.value.replace(/\D/g,'');

    if(v.length > 11){
        v = v.slice(0,11);
    }

    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");

    v = v.replace(/(\d{5})(\d{4})$/, "$1-$2");

    e.target.value = v;

});



const senha = document.getElementById('senha');
const confirmarSenha =
document.getElementById('confirmarSenha');
const erroSenha =
document.getElementById('erroSenha');
const btn =
document.getElementById('btnSubmit');


function validarSenha(){

    if(confirmarSenha.value !== senha.value){

        erroSenha.style.display = 'block';
        btn.disabled = true;
        btn.style.opacity = '0.5';

    } else {

        erroSenha.style.display = 'none';
        btn.disabled = false;
        btn.style.opacity = '1';

    }

}

senha.addEventListener('input', validarSenha);

confirmarSenha.addEventListener('input', validarSenha);

</script>

</body>
</html>