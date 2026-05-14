<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleCadastro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Cadastro</title>
</head>

<body>

<?php if(isset($_GET['msg'])): ?>
<div class="alerta-sucesso">
    <?php
    if ($_GET['msg'] == 'cadastro_ok') echo "Cadastro realizado com sucesso!";
    ?>
    <span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>


<?php if (isset($_GET['erro'])): ?>
<div class="alerta">
    <?php
    if ($_GET['erro'] == 'email_existente') echo "E-mail já cadastrado";
    if ($_GET['erro'] == 'telefone_invalido') echo "Telefone inválido";
    if ($_GET['erro'] == 'senha_diferente') echo "As senhas não coincidem";
    if ($_GET['erro'] == 'geral') echo "Erro ao cadastrar";
    ?>
    <span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>


<?php include 'includes/navbar.php'; ?>

<div class="form">

    <form action="actions/processa_cadastro.php" method="POST">

        <h2 class="titulo">Cadastrar</h2>

        <div class="input-box">
            <input type="text" name="nome" placeholder="Nome" required>
        </div>

        <div class="input-box">
            <input type="text" id="telefone" name="telefone" placeholder="Telefone" maxlength="15" required>
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder="E-mail" required>
        </div>

        <div class="input-box">
            <input type="password" name="senha" placeholder="Senha" required>
        </div>

        <div class="input-box">
            <input type="password" name="confirmar_senha" placeholder="Confirmar senha" required>
            <small id="msgSenha"></small>
        </div>

        <button type="submit">Cadastrar</button>

        <p>Já tem uma conta? <a href="login.php">Login</a></p>

    </form>

</div>


<script>
// máscara telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g,'');

    if (v.length > 11) v = v.slice(0, 11);

    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
    v = v.replace(/(\d{5})(\d{4})$/,"$1-$2");

    e.target.value = v;
});


// validação de senha em tempo real
const senha = document.querySelector('input[name="senha"]');
const confirmar = document.querySelector('input[name="confirmar_senha"]');
const msg = document.getElementById('msgSenha');
const botao = document.querySelector('button');

function verificarSenha() {

    if (!senha.value || !confirmar.value) {
        msg.textContent = "";
        botao.disabled = false;
        return;
    }

    if (senha.value === confirmar.value) {
        msg.textContent = "✔ Senhas coincidem";
        msg.style.color = "green";
        botao.disabled = false;
    } else {
        msg.textContent = "✖ Senhas não coincidem";
        msg.style.color = "red";
        botao.disabled = true;
    }
}

senha.addEventListener('input', verificarSenha);
confirmar.addEventListener('input', verificarSenha);
</script>

</body>
</html>
