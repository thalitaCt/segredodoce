<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <?php if(isset($_GET['msg'])): ?>
<div class="alerta-sucesso">
<?php
if ($_GET['msg'] == 'email_enviado') echo "Email enviado!<br>Verifique sua caixa de entrada";
if ($_GET['msg'] == 'senha_alterada') echo "Senha alterada com sucesso";
if ($_GET['msg'] == 'verificado') echo "Conta verificada com sucesso! <br>Faça login";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'email') echo "Email não encontrado";
if ($_GET['erro'] == 'senha') echo "Senha incorreta";
if ($_GET['erro'] == 'login') echo "Faça login ou crie uma conta para comprar produtos";
if ($_GET['erro'] == 'nao_verificado') echo "Verifique seu email antes de entrar";
if ($_GET['erro'] == 'token_invalido') echo "Link expirado, tente novamente com outro link";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<?php include 'includes/navbar.php'; ?>

<div class="form">

    <form action="actions/processa_login.php" method="POST">
            <h2 class="titulo">Login</h2>

        <div class="input-box"><input type="email" name="email" placeholder="Email" required></div>
        <div class="input-box senha-box">
    <input type="password" id="senha" name="senha" placeholder="Senha" required>
    <i class="fa-solid fa-eye olho" onclick="toggleSenha('senha', this)"></i>
</div>
        <p class="link senha"><a href="esqueci_senha.php">Esqueceu a senha?</a></p>
        <button type="submit">Logar</button><br>
        <p>Não tem uma conta? <span class="link cadastro"><a href="cadastro.php">Registre-se</a></span></p>
    </form>
</div>

<script>
function toggleSenha(id, icon) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>
</body>
</html>
