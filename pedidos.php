<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?erro=login");
    exit;
}


include 'includes/conexao.php';
include 'includes/navbar.php';


$email = $_SESSION['usuario'];


$sql = $pdo->prepare("
SELECT *
FROM pedidos
WHERE cliente_email = ?
ORDER BY id_pedidos DESC
");


$sql->execute([$email]);


$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Meus Pedidos</title>


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<link rel="stylesheet" href="css/stylePedidos.css">


</head>
<body>


<?php if(isset($_GET['msg'])): ?>


<div class="alerta">


<?php


if ($_GET['msg'] == 'feito'){
    echo "Pedido realizado com sucesso!";
}


else{
    echo "Operação realizada com sucesso!";
}


?>


<span class="fechar"
onclick="this.parentElement.style.display='none'">
X
</span>


</div>


<?php endif; ?>


<div class="container">


<h1 id="tittle">
Meus Pedidos
</h1>


<?php if(count($pedidos) > 0): ?>


<?php foreach($pedidos as $p): ?>


<?php


$codigoPedido = 'SD-' . str_pad($p['id_pedidos'], 5, '0', STR_PAD_LEFT);


$status = strtolower($p['status']);


$statusClasse = 'status-pendente';


if($status == 'preparando'){
    $statusClasse = 'status-preparando';
}


elseif($status == 'enviado'){
    $statusClasse = 'status-enviado';
}


elseif($status == 'entregue'){
    $statusClasse = 'status-entregue';
}


?>


<div class="pedido-card">


<div class="pedido-topo">


<div>


<h2>


<i class="fa-solid fa-box"></i>


Pedido <?= $codigoPedido; ?>


</h2>


<span class="data-pedido">


<i class="fa-solid fa-calendar"></i>


<?= date('d/m/Y H:i', strtotime($p['data_pedido'])) ?>


</span>


</div>


<div class="status-box">


<span class="status-pagamento <?= $p['pago'] ? 'pago' : 'pendente' ?>">


<i class="fa-solid fa-credit-card"></i>


<?= $p['pago'] ? 'Pago' : 'Pendente' ?>


</span>


<span class="status-pedido <?= $statusClasse ?>">


<i class="fa-solid fa-truck"></i>


<?= $p['status']; ?>


</span>


</div>


</div>


<div class="pedido-grid">


<div class="info">


<span>


<i class="fa-solid fa-money-bill-wave"></i>


Total


</span>


<p>


R$ <?= number_format($p['total'],2,',','.'); ?>


</p>


</div>


<div class="info">


<span>


<i class="fa-solid fa-truck-fast"></i>


Frete


</span>


<p>


<?= $p['frete'] !== null
? 'R$ ' . number_format($p['frete'],2,',','.')
: 'Não informado'
?>


</p>


</div>


<div class="info">


<span>


<i class="fa-solid fa-credit-card"></i>


Pagamento


</span>


<p>


<?= ucfirst($p['forma_pagamento']); ?>


</p>


</div>


<div class="info">


<span>


<i class="fa-solid fa-location-dot"></i>


Região


</span>


<p>


<?= !empty($p['regiao'])
? $p['regiao']
: 'Não informado'
?>


</p>


</div>


</div>


<div class="entrega-box">


<h4>


<i class="fa-solid fa-map-location-dot"></i>


Endereço de entrega


</h4>


<p>


<?= !empty($p['endereco_entrega'])
? $p['endereco_entrega']
: 'Não informado'
?>


</p>


</div>


</div>


<?php endforeach; ?>


<?php else: ?>


<div class="sem-pedidos">


<i class="fa-solid fa-box-open"></i>


<h2>
Você ainda não possui pedidos.
</h2>


<p>
Quando fizer uma compra ela aparecerá aqui.
</p>


<a href="cardapio.php">


<button>
Ir para o cardápio
</button>


</a>


</div>


<?php endif; ?>


</div>


<?php include 'includes/footer.php'; ?>


</body>
</html>