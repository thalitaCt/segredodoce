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


$primeiroNome = explode(" ", trim($cliente['nome']))[0];
?>


<!DOCTYPE html>
<html lang="pt-br">


<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Minha Conta</title>


<link rel="stylesheet" href="css/styleConta.css">


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>


<body>


<?php include 'includes/navbar.php'; ?>


<div class="container">


<?php if(isset($_GET['msg'])): ?>


<div class="alerta-sucesso">


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


<div class="topo-conta">


<h1>Olá, <?= $primeiroNome; ?> 👋</h1>


<p>Gerencie suas informações pessoais e endereço</p>


</div>


<form action="actions/salvar_conta.php" method="POST">


<div class="grid-conta">


<div class="card-conta">


<h2>
<i class="fa-solid fa-user"></i>
Dados Pessoais
</h2>


<div class="form-grid">


<div class="input-group">
<label>Nome</label>


<input
type="text"
name="nome"
value="<?= htmlspecialchars($cliente['nome']) ?>"
required>
</div>


<div class="input-group">
<label>Telefone</label>


<input
type="text"
id="telefone"
name="telefone"
maxlength="15"
value="<?= htmlspecialchars($cliente['telefone']) ?>"
required>
</div>


<div class="input-group full">
<label>Email</label>


<input
type="email"
value="<?= htmlspecialchars($cliente['email']) ?>"
disabled>
</div>


</div>


</div>


<div class="card-conta">


<h2>
<i class="fa-solid fa-location-dot"></i>
Endereço
</h2>


<div class="form-grid">


<div class="input-group">
<label>CEP</label>


<input
type="text"
id="cep"
name="cep"
maxlength="9"
value="<?= htmlspecialchars($cliente['cep']) ?>">
</div>


<div class="input-group">
<label>Número</label>


<input
type="text"
name="numero"
value="<?= htmlspecialchars($cliente['numero']) ?>">
</div>


<div class="input-group full">
<label>Rua / Avenida</label>


<input
type="text"
name="endereco"
value="<?= htmlspecialchars($cliente['endereco']) ?>">
</div>


<div class="input-group">
<label>Bairro</label>


<input
type="text"
name="bairro"
value="<?= htmlspecialchars($cliente['bairro']) ?>">
</div>


<div class="input-group">
<label>Cidade</label>


<input
type="text"
name="cidade"
value="<?= htmlspecialchars($cliente['cidade']) ?>">
</div>


<div class="input-group">
<label>Estado</label>


<input
type="text"
name="estado"
maxlength="2"
value="<?= htmlspecialchars($cliente['estado']) ?>">
</div>


</div>


</div>


</div>


<button type="submit" class="botao-salvar">
Salvar Alterações
</button>


</form>


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