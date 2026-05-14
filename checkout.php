<?php
session_start();


if(empty($_SESSION['carrinho'])){
    header("Location: carrinho.php");
    exit;
}


include 'includes/conexao.php';
include 'includes/navbar.php';


$total = 0;


foreach($_SESSION['carrinho'] as $item){
    $total += $item['preco'] * $item['quantidade'];
}


$frete = $_SESSION['frete'] ?? 0;


$totalFinal = $total + $frete;


$endereco = $_SESSION['endereco_pedido'] ?? null;


if(!$endereco){
    header("Location: frete.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" href="css/styleCheckout.css">


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<title>Checkout</title>
</head>


<body>


<div class="checkout-container">


<h1 id="tittle">Finalizar Compra</h1>


<!-- ETAPAS -->


<div class="steps">


<div class="step concluido">
<i class="fa-solid fa-check"></i>
<span>Entrega</span>
</div>


<div class="linha ativa"></div>


<div class="step ativo">
<i class="fa-solid fa-credit-card"></i>
<span>Pagamento</span>
</div>


</div>


<div class="checkout-grid">


<!-- PAGAMENTO -->


<div class="pagamento-card">


<h2>Forma de Pagamento</h2>


<form action="actions/finalizar.php" method="POST">


<div class="metodos">


<label class="metodo ativo" id="pix-card">


<input
type="radio"
name="forma_pagamento"
value="pix"
checked
hidden>


<div class="metodo-topo">
<i class="fa-brands fa-pix"></i>
<h3>PIX</h3>
</div>


<p>Transferência instantânea</p>


</label>


<label class="metodo" id="cartao-card">


<input
type="radio"
name="forma_pagamento"
value="cartao"
hidden>


<div class="metodo-topo">
<i class="fa-solid fa-credit-card"></i>
<h3>Cartão</h3>
</div>


<p>Crédito ou débito</p>


</label>


<label class="metodo" id="boleto-card">


<input
type="radio"
name="forma_pagamento"
value="boleto"
hidden>


<div class="metodo-topo">
<i class="fa-solid fa-barcode"></i>
<h3>Boleto</h3>
</div>


<p>Pagamento bancário</p>


</label>


</div>


<!-- PIX -->


<div class="pagamento-box" id="pix-box">


<div class="pix-area">


<div class="qr-code">
<i class="fa-solid fa-qrcode"></i>
</div>


<p class="pix-texto">
Escaneie o QR Code com o aplicativo do seu banco.
</p>


<div class="pix-chave">
<strong>Chave PIX:</strong><br>
contato@segredodoce.com
</div>


</div>


</div>


<!-- CARTÃO -->


<div class="pagamento-box hidden" id="cartao-box">


<div class="input-group">


<div class="input-box">
<label>Número do cartão</label>


<input
type="text"
placeholder="0000 0000 0000 0000">
</div>


</div>


<div class="duplo">


<div class="input-box">
<label>Nome impresso</label>


<input
type="text"
placeholder="Nome do cartão">
</div>


<div class="input-box">
<label>CVV</label>


<input
type="text"
placeholder="123">
</div>


</div>


<div class="duplo">


<div class="input-box">
<label>Validade</label>


<input
type="text"
placeholder="MM/AA">
</div>


<div class="input-box">
<label>Parcelas</label>


<select>
<option>1x sem juros</option>
<option>2x sem juros</option>
<option>3x sem juros</option>
</select>
</div>


</div>


</div>


<!-- BOLETO -->


<div class="pagamento-box hidden" id="boleto-box">


<div class="boleto-area">


<i class="fa-solid fa-barcode"></i>


<p>
O boleto será gerado após a confirmação do pedido.
</p>


</div>


</div>


<button type="submit" class="btn-finalizar">
Confirmar Pedido
</button>


</form>


</div>


<!-- RESUMO -->


<div class="resumo-card">


<h2>Resumo do Pedido</h2>


<div class="resumo-linha">
<span>Subtotal</span>
<span>
R$ <?= number_format($total,2,',','.'); ?>
</span>
</div>


<div class="resumo-linha">
<span>Frete</span>
<span>
R$ <?= number_format($frete,2,',','.'); ?>
</span>
</div>


<div class="resumo-total">
<span>Total</span>
<span>
R$ <?= number_format($totalFinal,2,',','.'); ?>
</span>
</div>


<div class="endereco-box">


<h3>
<i class="fa-solid fa-location-dot"></i>
Endereço de Entrega
</h3>


<p>


<?= $endereco['endereco']; ?>,
<?= $endereco['numero']; ?>


</p>


<p>


<?= $endereco['bairro']; ?>


</p>


<p>


<?= $endereco['cidade']; ?> /
<?= $endereco['estado']; ?>


</p>


<p>


CEP:
<?= $endereco['cep']; ?>


</p>


</div>


</div>


</div>


</div>


<?php include 'includes/footer.php'; ?>


<script>


const radios = document.querySelectorAll('input[name="forma_pagamento"]');


const pixBox = document.getElementById('pix-box');
const cartaoBox = document.getElementById('cartao-box');
const boletoBox = document.getElementById('boleto-box');


const pixCard = document.getElementById('pix-card');
const cartaoCard = document.getElementById('cartao-card');
const boletoCard = document.getElementById('boleto-card');


radios.forEach(radio => {


radio.addEventListener('change', () => {


pixBox.classList.add('hidden');
cartaoBox.classList.add('hidden');
boletoBox.classList.add('hidden');


pixCard.classList.remove('ativo');
cartaoCard.classList.remove('ativo');
boletoCard.classList.remove('ativo');


if(radio.value === 'pix'){
    pixBox.classList.remove('hidden');
    pixCard.classList.add('ativo');
}


if(radio.value === 'cartao'){
    cartaoBox.classList.remove('hidden');
    cartaoCard.classList.add('ativo');
}


if(radio.value === 'boleto'){
    boletoBox.classList.remove('hidden');
    boletoCard.classList.add('ativo');
}


});


});


</script>


</body>
</html>