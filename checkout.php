<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleCheckout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Checkout</title>
</head>
<body>

<?php
include 'includes/navbar.php';

if(empty($_SESSION['carrinho'])){
    header("Location: carrinho.php");
    exit;
}

$total = 0;

foreach($_SESSION['carrinho'] as $item){
    $total += $item['preco'] * $item['quantidade'];
}
?>

<h1 id="tittle">Checkout</h1>

<div class="card">

<p>Cliente: <?= $_SESSION['nome']; ?></p>

<p>Total: R$ <?= number_format($total,2,',','.'); ?></p>

<form action="actions/finalizar.php" method="POST">

<label>Forma de pagamento:</label>

<select name="forma_pagamento">
    <option value="pix">Pix</option>
    <option value="cartao">Cartão</option>
    <option value="boleto">Boleto</option>
</select>

<br>

<button type="submit">Confirmar Pedido</button>

</form>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
