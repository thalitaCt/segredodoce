<?php

$sql = $pdo->prepare("
SELECT *
FROM pedidos
ORDER BY data_pedido DESC
");

$sql->execute();

$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);

$produtos = $pdo->query("
SELECT *
FROM produtos
ORDER BY nome ASC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="pedidos-layout">

<!-- RESUMO -->

<div class="cards-resumo">

<div class="mini-card">

<span>Total Pedidos</span>

<h2>
<?= count($pedidos) ?>
</h2>

</div>

<div class="mini-card warning">

<span>Pedidos Pendentes</span>

<h2>

<?php
echo count(array_filter($pedidos, function($p){
    return $p['status'] == 'Pendente';
}));
?>

</h2>

</div>

<div class="mini-card success">

<span>Pedidos Entregues</span>

<h2>

<?php
echo count(array_filter($pedidos, function($p){
    return $p['status'] == 'Entregue';
}));
?>

</h2>

</div>

</div>

<!-- NOVO PEDIDO -->

<div class="card-master">

<div class="topo-secao">

<div>

<h1>Novo Pedido</h1>

<p>
Criar pedido manual para cliente
</p>

</div>

</div>

<form
action="criar_pedido_manual.php"
method="POST"
class="form-pedido">

<div class="grid-form">

<input
type="text"
name="cliente_nome"
placeholder="Nome do cliente"
required>

<input
type="email"
name="cliente_email"
placeholder="Email do cliente"
required>

<select name="produto_id" required>

<option value="">
Selecione um produto
</option>

<?php foreach($produtos as $prod): ?>

<option value="<?= $prod['id_produtos'] ?>">

<?= $prod['nome'] ?>
-
R$ <?= number_format($prod['preco'],2,',','.') ?>

</option>

<?php endforeach; ?>

</select>

<input
type="number"
name="quantidade"
placeholder="Quantidade"
min="1"
required>

<select name="forma_pagamento" required>

<option value="pix">Pix</option>

<option value="cartao">
Cartão
</option>

<option value="boleto">
Boleto
</option>

</select>

</div>

<button
type="submit"
class="btn-principal">

<i class="fa-solid fa-cart-plus"></i>

Criar Pedido

</button>

</form>

</div>

<!-- LISTA PEDIDOS -->

<div class="card-master">

<div class="topo-secao">

<div>

<h1>Pedidos</h1>

<p>
Gerencie os pedidos da confeitaria
</p>

</div>

</div>

<div class="tabela-container">

<table>

<tr>

<th>ID</th>
<th>Cliente</th>
<th>Total</th>
<th>Pagamento</th>
<th>Status Pagamento</th>
<th>Status Pedido</th>
<th>Ações</th>

</tr>

<?php foreach($pedidos as $p): ?>

<?php

$cor = match($p['status']){

    'Pedido confirmado' => 'yellow',
    'Pedido Confirmado' => 'yellow',
    'Pendente' => 'orange',
    'Em preparo' => 'blue',
    'Pronto' => 'green',
    'Entregue' => 'gray',
    'Cancelado' => 'red',
    default => 'black'
};

?>

<tr>

<td>

#<?= $p['id_pedidos'] ?>

</td>

<td>

<div class="cliente-info">

<div class="avatar-cliente">

<?= strtoupper(substr($p['cliente_nome'],0,1)) ?>

</div>

<div>

<strong>

<?= htmlspecialchars($p['cliente_nome']) ?>

</strong>

<small>

<?= $p['cliente_email'] ?>

</small>

</div>

</div>

</td>

<td>

R$
<?= number_format($p['total'],2,',','.') ?>

</td>

<td>

<?= $p['forma_pagamento'] ?>

</td>

<td>

<?php if($p['pago']): ?>

<span class="badge-pago">
Pago
</span>

<?php else: ?>

<span class="badge-pendente">
Pendente
</span>

<?php endif; ?>

</td>

<td>

<span
class="status-badge"
style="background:<?= $cor ?>">

<?= $p['status'] ?>

</span>

</td>

<td>

<form
action="atualizar_status.php"
method="POST"
class="form-status">

<input
type="hidden"
name="id"
value="<?= $p['id_pedidos'] ?>">

<select name="status">

<option
<?= $p['status']=='Pedido Confirmado'?'selected':'' ?>>

Pedido Confirmado

</option>

<option
<?= $p['status']=='Pendente'?'selected':'' ?>>

Pendente

</option>

<option
<?= $p['status']=='Em preparo'?'selected':'' ?>>

Em preparo

</option>

<option
<?= $p['status']=='Pronto'?'selected':'' ?>>

Pronto

</option>

<option
<?= $p['status']=='Entregue'?'selected':'' ?>>

Entregue

</option>

<option
<?= $p['status']=='Cancelado'?'selected':'' ?>>

Cancelado

</option>

</select>

<button
type="submit"
class="btn-atualizar">

Atualizar

</button>

</form>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</div>

</div>