<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?erro=login");
    exit;
}


include 'includes/conexao.php';


$idUsuario = $_SESSION['id'];


$sql = $pdo->prepare("
SELECT 
    u.email,
    c.nome,
    c.telefone,
    c.cep,
    c.endereco,
    c.numero,
    c.bairro,
    c.cidade,
    c.estado
FROM clientes c
JOIN usuarios u ON u.id_usuario = c.usuario_id
WHERE c.usuario_id = ?
");


$sql->execute([$idUsuario]);


$cliente = $sql->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/styleConta.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<title>Minha Conta</title>
</head>
<body>

<?php if(isset($_GET['msg'])): ?>

<div class="alerta">
<?php
if($_GET['msg'] == 'salvo'){
    echo "Dados atualizados com sucesso!";
}
?>
<span class="fechar"
onclick="this.parentElement.style.display='none'">
X
</span>
</div>

<?php endif; ?>

<?php include 'includes/navbar.php'; ?>

<div class="container">

<div class="card">

<h1>Minha Conta</h1>

<form action="actions/salvar_conta.php" method="POST">

Nome<input type="text" name="nome"
value="<?= htmlspecialchars($cliente['nome']) ?>" required>

Email<input type="email"
value="<?= htmlspecialchars($cliente['email']) ?>"
disabled>

Telefone<input type="text"
id="telefone"
name="telefone"
maxlength="15"
value="<?= htmlspecialchars($cliente['telefone']) ?>"
required>

CEP<input type="text"
id="cep"
name="cep"
maxlength="9"
value="<?= htmlspecialchars($cliente['cep']) ?>">

Endereço<input type="text"
name="endereco"
value="<?= htmlspecialchars($cliente['endereco']) ?>">

Número<input type="text"
name="numero"
value="<?= htmlspecialchars($cliente['numero']) ?>">

Bairro<input type="text"
name="bairro"
value="<?= htmlspecialchars($cliente['bairro']) ?>">

Cidade<input type="text"
name="cidade"
value="<?= htmlspecialchars($cliente['cidade']) ?>">

Estado<input type="text"
name="estado"
maxlength="2"
value="<?= htmlspecialchars($cliente['estado']) ?>">

<button type="submit">
Salvar Alterações
</button>

</form>

</div>
</div>

<?php include 'includes/footer.php'; ?>

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

document.getElementById('cep').addEventListener('input', function(e){

    let v = e.target.value.replace(/\D/g,'');

    if(v.length > 8){
        v = v.slice(0,8);
    }

    v = v.replace(/(\d{5})(\d)/,'$1-$2');

    e.target.value = v;
});

</script>

</body>
</html>
