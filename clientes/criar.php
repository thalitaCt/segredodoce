<?php
session_start();

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'gerente') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/styleGerente.css">
<title>Cadastrar Cliente</title>

<style>
.erro-senha{
    color:red;
    font-size:13px;
    margin-top:5px;
    display:none;
}
</style>
</head>

<body>

<?php if(isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'telefone_invalido') {
    echo "Número de celular inválido. Use DDD + número (ex: 21999999999).";
}
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<div class="form-card">

<h2>Cadastrar Cliente</h2>

<form method="POST" action="salvar_criacao.php">

    <input type="text" name="nome" placeholder="Nome" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" id="senha" name="senha" placeholder="Senha" required>

    <input type="password" id="confirmar_senha" placeholder="Confirmar senha" required>

    <div class="erro-senha" id="erroSenha">
        Senhas não coincidem
    </div>

    <input type="text" id="telefone" name="telefone" placeholder="Telefone" maxlength="15" required>

    <button type="submit" id="btnSubmit">Criar Cliente</button>

</form>

</div>

<script>
// telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g,'');

    if (v.length > 11) v = v.slice(0, 11);

    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
    v = v.replace(/(\d{5})(\d{4})$/, "$1-$2");

    e.target.value = v;
});


// senhas
const senha = document.getElementById('senha');
const confirmar = document.getElementById('confirmar_senha');
const erro = document.getElementById('erroSenha');
const btn = document.getElementById('btnSubmit');

function validarSenha(){
    if(confirmar.value !== senha.value){
        erro.style.display = "block";
        btn.disabled = true;
        btn.style.opacity = 0.5;
    } else {
        erro.style.display = "none";
        btn.disabled = false;
        btn.style.opacity = 1;
    }
}

senha.addEventListener('input', validarSenha);
confirmar.addEventListener('input', validarSenha);
</script>

</body>
</html>
