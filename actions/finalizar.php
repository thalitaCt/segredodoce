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


/* STATUS PAGAMENTO */


if($forma == 'boleto'){


    $pago = false;


}
else{


    $pago = true;


}


/* STATUS PEDIDO */


$statusPedido = 'Pedido confirmado';


/* ENDEREÇO FORMATADO */


$enderecoCompleto =
$endereco['endereco'] . ', ' .
$endereco['numero'] . ' - ' .
$endereco['bairro'] . ' - ' .
$endereco['cidade'] . '/' .
$endereco['estado'];


/* INSERIR PEDIDO */


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


    $enderecoCompleto,


    $endereco['regiao'] ?? null,


    $statusPedido,


    $pago,


    $forma


]);


/* ID PEDIDO */


$pedido_id = $pdo->lastInsertId();


/* ITENS PEDIDO */


foreach($carrinho as $id => $item){


    /* VERIFICAR ESTOQUE */


    $verifica = $pdo->prepare("
    SELECT estoque
    FROM produtos
    WHERE id_produtos = ?
    ");


    $verifica->execute([$id]);


    $produto = $verifica->fetch(PDO::FETCH_ASSOC);


    if(!$produto || $produto['estoque'] < $item['quantidade']){


        header("Location: ../carrinho.php?erro=estoque");
        exit;


    }


    /* INSERIR ITEM */


    $sqlItem = $pdo->prepare("
    INSERT INTO itens_pedido
    (
    pedido_id,
    produto_id,
    nome,
    quantidade,
    preco
    )
    VALUES (?, ?, ?, ?, ?)
    ");


    $sqlItem->execute([


        $pedido_id,


        $id,


        $item['nome'],


        $item['quantidade'],


        $item['preco']


    ]);


    /* DIMINUIR ESTOQUE */


    $update = $pdo->prepare("
    UPDATE produtos
    SET estoque = estoque - ?
    WHERE id_produtos = ?
    ");


    $update->execute([


        $item['quantidade'],


        $id


    ]);


}


/* LIMPAR CARRINHO */


$_SESSION['carrinho'] = [];


unset($_SESSION['frete']);
unset($_SESSION['endereco_pedido']);


/* REDIRECT */


header("Location: ../confirmacao.php?pedido=$pedido_id");


exit;
?>