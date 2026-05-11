<?php
session_start();
include '../includes/conexao.php';


if(empty($_SESSION['carrinho'])){
    header("Location: ../carrinho.php");
    exit;
}


$carrinho = $_SESSION['carrinho'];
$total = 0;


foreach($carrinho as $item){
    $total += $item['preco'] * $item['quantidade'];
}

$frete = $_SESSION['frete'] ?? 0;


$totalFinal = $total + $frete;


$endereco = $_SESSION['endereco_pedido'] ?? [];

$forma = $_POST['forma_pagamento'] ?? 'pix';
$pago = ($forma === 'boleto') ? 'false' : 'true';

$sql = $pdo->prepare("
INSERT INTO pedidos
(
cliente_email,
cliente_nome,
total,
frete,
endereco_entrega,
regiao,
status,
pago,
forma_pagamento,
data_pedido
)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
");


$sql->execute([
    $_SESSION['usuario'],
    $_SESSION['nome'],
    $totalFinal,
    $frete,
    $endereco['endereco'] . ', ' .
    $endereco['numero'] . ' - ' .
    $endereco['bairro'] . ' - ' .
    $endereco['cidade'] . '/' .
    $endereco['estado'],
    $endereco['regiao'] ?? null,
    'Pendente',
    $pago,
    $forma
]);



$pedido_id = $pdo->lastInsertId();


foreach($carrinho as $id => $item){

    $sql = $pdo->prepare("
    INSERT INTO itens_pedido
    (pedido_id, produto_id, nome, quantidade, preco)
    VALUES (?, ?, ?, ?, ?)
    ");


    $sql->execute([
        $pedido_id,
        $id,
        $item['nome'],
        $item['quantidade'],
        $item['preco']
    ]);

    $sql = $pdo->prepare("
    UPDATE produtos
    SET estoque = estoque - ?
    WHERE id_produtos = ?
    ");

    $sql->execute([
        $item['quantidade'],
        $id
    ]);
}

$_SESSION['carrinho'] = [];

unset($_SESSION['frete']);
unset($_SESSION['endereco_pedido']);

header("Location: ../pedidos.php?msg=feito");
exit;
?>
