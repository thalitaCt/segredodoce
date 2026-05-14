<?php
session_start();
include 'includes/conexao.php';


if(!isset($_SESSION['usuario'])){
    header("Location: login.php?erro=login");
    exit;
}


if(!isset($_GET['pedido'])){
    header("Location: pedidos.php");
    exit;
}


$pedidoId = intval($_GET['pedido']);


$sql = $pdo->prepare("


SELECT *
FROM pedidos
WHERE id_pedidos = ?
AND cliente_email = ?


");


$sql->execute([
    $pedidoId,
    $_SESSION['usuario']
]);


$pedido = $sql->fetch(PDO::FETCH_ASSOC);


if(!$pedido){
    header("Location: pedidos.php");
    exit;
}


/* ITENS DO PEDIDO */


$itens = $pdo->prepare("


SELECT *
FROM itens_pedido
WHERE pedido_id = ?


");


$itens->execute([$pedidoId]);


$listaItens = $itens->fetchAll(PDO::FETCH_ASSOC);


/* STATUS PAGAMENTO */


$statusPagamento = $pedido['pago']
? 'Pago'
: 'Pendente';


/* ÍCONE PAGAMENTO */


$iconePagamento = 'fa-clock';


if($pedido['pago']){
    $iconePagamento = 'fa-circle-check';
}


/* STATUS PEDIDO */


$statusPedido = strtolower($pedido['status']);


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>


<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">


<title>Pedido Confirmado</title>


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>


@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


:root{
    --rosa:#ff877d;
    --rosa2:#ee5350;
    --bege2:#fff4ee;
    --marrom3:#421d14;
    --verde:#00a00d;
    --branco:#fff;
    --cinza:#777;
}


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins;
}


body{
    background:var(--bege2);
    padding:30px 15px;
}


.container{
    max-width:1000px;
    margin:auto;
}


.topo{
    background:var(--branco);
    padding:35px;
    border-radius:20px;
    text-align:center;
    margin-bottom:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}


.icone{
    width:90px;
    height:90px;
    background:rgba(0,160,13,0.1);
    color:var(--verde);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    font-size:40px;
    margin-bottom:20px;
}


.topo h1{
    color:var(--marrom3);
    font-size:34px;
    margin-bottom:10px;
}


.topo p{
    color:var(--cinza);
    font-size:16px;
}


.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}


.card{
    background:var(--branco);
    border-radius:18px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}


.card h2{
    color:var(--marrom3);
    margin-bottom:20px;
    font-size:24px;
}


.infoPedido{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
    padding-bottom:15px;
    border-bottom:1px solid #eee;
}


.infoPedido:last-child{
    border:none;
    margin-bottom:0;
    padding-bottom:0;
}


.label{
    color:var(--cinza);
    font-size:14px;
}


.valor{
    color:var(--marrom3);
    font-weight:600;
    text-align:right;
}


.status{
    display:flex;
    align-items:center;
    gap:10px;
    color:var(--verde);
    font-weight:600;
}


.item{
    display:flex;
    justify-content:space-between;
    gap:15px;
    padding:15px 0;
    border-bottom:1px solid #eee;
}


.item:last-child{
    border:none;
}


.item h3{
    color:var(--marrom3);
    font-size:17px;
    margin-bottom:5px;
}


.item p{
    color:var(--cinza);
    font-size:14px;
}


.preco{
    color:var(--rosa2);
    font-weight:700;
    white-space:nowrap;
}


.timeline{
    display:flex;
    flex-direction:column;
    gap:25px;
}


.etapa{
    display:flex;
    gap:15px;
}


.numero{
    min-width:40px;
    height:40px;
    border-radius:50%;
    background:var(--rosa);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}


.etapa h4{
    color:var(--marrom3);
    margin-bottom:5px;
}


.etapa p{
    color:var(--cinza);
    font-size:14px;
}


.botoes{
    display:flex;
    gap:15px;
    margin-top:25px;
    flex-wrap:wrap;
}


.btn{
    flex:1;
    min-width:220px;
    padding:14px;
    border:none;
    border-radius:12px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
    text-decoration:none;
    text-align:center;
}


.btn-rosa{
    background:var(--rosa);
    color:white;
}


.btn-rosa:hover{
    background:var(--rosa2);
}


.btn-branco{
    background:white;
    border:2px solid var(--rosa);
    color:var(--rosa2);
}


.btn-branco:hover{
    background:var(--bege2);
}


.totalFinal{
    font-size:26px;
    color:var(--rosa2);
    font-weight:700;
}


@media(max-width:850px){


    .grid{
        grid-template-columns:1fr;
    }


    .topo h1{
        font-size:28px;
    }
}


@media(max-width:500px){


    body{
        padding:15px;
    }


    .topo,
    .card{
        padding:20px;
    }


    .item{
        flex-direction:column;
    }


    .botoes{
        flex-direction:column;
    }
}


</style>
</head>


<body>


<div class="container">


<div class="topo">


<div class="icone">
<i class="fa-solid fa-circle-check"></i>
</div>


<h1>Pedido Confirmado!</h1>


<p>
Obrigado pela sua compra.
Seu pedido foi recebido e será preparado em breve.
</p>


</div>


<div class="grid">


<!-- ESQUERDA -->


<div>


<div class="card">


<h2>Informações do Pedido</h2>


<div class="infoPedido">


<div>
<p class="label">Número do Pedido</p>
<p class="valor">
PED-<?= str_pad($pedido['id_pedidos'], 5, '0', STR_PAD_LEFT); ?>
</p>
</div>


<div>
<p class="label">Data</p>
<p class="valor">
<?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?>
</p>
</div>


</div>


<div class="infoPedido">


<div>
<p class="label">Pagamento</p>


<p class="valor">
<?= strtoupper($pedido['forma_pagamento']) ?>
</p>
</div>


<div>
<p class="label">Status</p>


<p class="status">
<i class="fa-solid <?= $iconePagamento ?>"></i>
<?= $statusPagamento ?>
</p>
</div>


</div>


<div class="infoPedido">


<div>
<p class="label">Entrega</p>


<p class="valor">
<?= $pedido['regiao'] ?>
</p>
</div>


<div>
<p class="label">Pedido</p>


<p class="valor">
<?= $pedido['status'] ?>
</p>
</div>


</div>


</div>


<div class="card" style="margin-top:20px;">


<h2>Itens do Pedido</h2>


<?php foreach($listaItens as $item): ?>


<div class="item">


<div>


<h3>
<?= htmlspecialchars($item['nome']) ?>
</h3>


<p>
Quantidade:
<?= $item['quantidade'] ?>
</p>


</div>


<div class="preco">


R$
<?= number_format(
$item['preco'] * $item['quantidade'],
2,
',',
'.'
); ?>


</div>


</div>


<?php endforeach; ?>


</div>


</div>


<!-- DIREITA -->


<div>


<div class="card">


<h2>Status do Pedido</h2>


<div class="timeline">


<div class="etapa">


<div class="numero">
1
</div>


<div>


<h4>Pedido Confirmado</h4>


<p>
Seu pedido foi recebido com sucesso.
</p>


</div>


</div>


<div class="etapa">


<div class="numero">
2
</div>


<div>


<h4>Aguardando Preparação</h4>


<p>
Estamos separando seus produtos.
</p>


</div>


</div>


<div class="etapa">


<div class="numero">
3
</div>


<div>


<h4>Preparando Envio</h4>


<p>
Seu pedido será enviado em breve.
</p>


</div>


</div>


<div class="etapa">


<div class="numero">
4
</div>


<div>


<h4>Entrega</h4>


<p>
Seu pedido será entregue no endereço informado.
</p>


</div>


</div>


</div>


</div>


<div class="card" style="margin-top:20px;">


<h2>Resumo Financeiro</h2>


<div class="infoPedido">


<p class="label">
Subtotal + Frete
</p>


<p class="valor totalFinal">


R$
<?= number_format(
$pedido['total'],
2,
',',
'.'
); ?>


</p>


</div>


<div class="infoPedido">


<p class="label">
Frete
</p>


<p class="valor">


R$
<?= number_format(
$pedido['frete'],
2,
',',
'.'
); ?>


</p>


</div>


<div class="infoPedido">


<p class="label">
Endereço
</p>


<p class="valor">


<?= htmlspecialchars($pedido['endereco_entrega']) ?>


</p>


</div>


</div>


</div>


</div>


<div class="botoes">


<a href="cardapio.php"
class="btn btn-branco">


<i class="fa-solid fa-cart-shopping"></i>
Continuar Comprando


</a>


<a href="pedidos.php"
class="btn btn-rosa">


<i class="fa-solid fa-box"></i>
Ver Meus Pedidos


</a>


</div>


</div>


</body>
</html>