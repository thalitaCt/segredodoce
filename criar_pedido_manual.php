<?php
session_start();
include 'includes/conexao.php';


if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'recepcionista'){
    header("Location: login.php");
    exit;
}


$cliente_nome = $_POST['cliente_nome'];
$cliente_email = $_POST['cliente_email'];
$produto_id = $_POST['produto_id'];
$quantidade = $_POST['quantidade'];
$forma = $_POST['forma_pagamento'];

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


try {
    $pdo->beginTransaction();

    $sql = $pdo->prepare("SELECT nome, preco, estoque FROM produtos WHERE id_produtos = ?");
    $sql->execute([$produto_id]);
    $produto = $sql->fetch(PDO::FETCH_ASSOC);

    if(!$produto){
        throw new Exception("Produto não encontrado");
    }


    if($produto['estoque'] < $quantidade){
        throw new Exception("Estoque insuficiente");
    }


    $produto_nome = $produto['nome'];
    $preco = $produto['preco'];


    $total = $quantidade * $preco;


    $pago = ($forma == 'boleto') ? 'false' : 'true';

    echo "antes do insert pedido";
    exit;
    
    $sql = $pdo->prepare("
    INSERT INTO pedidos
    (cliente_nome, cliente_email, total, status, forma_pagamento, pago, data_pedido)
    VALUES (?, ?, ?, 'Pendente', ?, ?, NOW())
    ");


    $sql->execute([
        $cliente_nome,
        $cliente_email,
        $total,
        $forma,
        $pago
    ]);


    $pedido_id = $pdo->lastInsertId();


    $sql = $pdo->prepare("
    INSERT INTO itens_pedido
    (pedido_id, produto_id, nome, quantidade, preco)
    VALUES (?, ?, ?, ?, ?)
    ");


    $sql->execute([
        $pedido_id,
        $produto_id,
        $produto_nome,
        $quantidade,
        $preco
    ]);


    $sql = $pdo->prepare("
    UPDATE produtos
    SET estoque = estoque - ?
    WHERE id_produtos = ?
    ");


    $sql->execute([
        $quantidade,
        $produto_id
    ]);


    $pdo->commit();


} catch(Exception $e){
    $pdo->rollBack();
    echo "Erro: " . $e->getMessage();
    exit;
}

header("Location: recepcionista.php?msg=pedido_criado");
exit;
