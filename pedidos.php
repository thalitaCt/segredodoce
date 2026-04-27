<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/stylePedidos.css">
    <title>Pedidos</title>
</head>
<body>

<?php if(isset($_GET['msg'])): ?>
<div class="alerta">
<?php
if ($_GET['msg'] == 'feito') echo "Pedido realizado com sucesso!";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<?php

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?erro=login");
    exit;
}

include 'includes/conexao.php';
include 'includes/navbar.php';

$email = $_SESSION['usuario'];

$sql = $pdo->prepare("
SELECT * FROM pedidos
WHERE cliente_email = ?
ORDER BY id_pedidos DESC
");

$sql->execute([$email]);

$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">

<h1 id="tittle">Meus Pedidos</h1>

<?php foreach($pedidos as $p): ?>

<div class="pedido">

<h3>Pedido #<?= $p['id_pedidos']; ?></h3>

<p>Total: R$ <?= number_format($p['total'],2,',','.'); ?></p>

<p>Status: <?= $p['status']; ?></p>

<p>Data: <?= $p['data_pedido']; ?></p>

</div>

<hr>

<?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
    
</body>
</html>
