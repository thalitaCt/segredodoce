<?php
session_start();
include 'includes/conexao.php';


if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 'admin') {
    header("Location: index.php");
    exit;
}


/* TOTAL CLIENTES */
$sqlClientes = $pdo->query("SELECT COUNT(*) AS total FROM clientes");
$totalClientes = $sqlClientes->fetch(PDO::FETCH_ASSOC)['total'];


/* TOTAL PEDIDOS */
$sqlPedidos = $pdo->query("SELECT COUNT(*) AS total FROM pedidos");
$totalPedidos = $sqlPedidos->fetch(PDO::FETCH_ASSOC)['total'];


/* TOTAL VENDIDO */
$sqlVendas = $pdo->query("SELECT COALESCE(SUM(total),0) AS total FROM pedidos");
$totalVendas = $sqlVendas->fetch(PDO::FETCH_ASSOC)['total'];


/* ULTIMOS CLIENTES */
$clientes = $pdo->query("
    SELECT nome, email
    FROM clientes
    ORDER BY id_clientes DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);


/* ULTIMOS PEDIDOS */
$pedidos = $pdo->query("
    SELECT id_pedidos, cliente_nome, total
    FROM pedidos
    ORDER BY id_pedidos DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/styleAdmin.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<title>Painel Admin</title>
<style>
    
</style>
</head>
<body>


<div class="admin-container">


<h1 class="titulo">Painel Administrativo</h1>


<div class="cards">


<div class="card">
<h3>Clientes</h3>
<p><?= $totalClientes ?></p>
</div>


<div class="card">
<h3>Pedidos</h3>
<p><?= $totalPedidos ?></p>
</div>


<div class="card">
<h3>Total Vendido</h3>
<p>R$ <?= number_format($totalVendas,2,',','.') ?></p>
</div>


</div>


<div class="grid">


<div class="box">
<h2>Últimos Clientes</h2>


<?php foreach($clientes as $c): ?>
<div class="item">
<strong><?= $c['nome'] ?></strong><br>
<?= $c['email'] ?>
</div>
<?php endforeach; ?>


</div>


<div class="box">
<h2>Últimos Pedidos</h2>


<?php foreach($pedidos as $p): ?>
<div class="item">
Pedido #<?= $p['id_pedidos'] ?><br>
<?= $p['cliente_nome'] ?><br>
<strong>R$ <?= number_format($p['total'],2,',','.') ?></strong>
</div>
<?php endforeach; ?>


</div>


</div>


</div>


</body>
</html>