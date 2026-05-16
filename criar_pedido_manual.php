<?php
session_start();
include 'includes/conexao.php';

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'atendente'){
    header("Location: login.php");
    exit;
}

$cliente_nome = trim($_POST['cliente_nome']);
$cliente_email = trim($_POST['cliente_email']);
$produto_id = $_POST['produto_id'];
$quantidade = (int) $_POST['quantidade'];
$forma = $_POST['forma_pagamento'] ?? 'pix';

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {

    // BUSCAR PRODUTO
    $sql = $pdo->prepare("SELECT nome, preco, estoque FROM produtos WHERE id_produtos = ?");
    $sql->execute([$produto_id]);
    $produto = $sql->fetch(PDO::FETCH_ASSOC);

    if(!$produto){
        throw new Exception("Produto não encontrado");
    }

    if($quantidade <= 0){
        throw new Exception("Quantidade inválida");
    }

    if($produto['estoque'] < $quantidade){
        throw new Exception("Estoque insuficiente");
    }

    $produto_nome = $produto['nome'];
    $preco = $produto['preco'];

    $total = $quantidade * $preco;

    // pagamento (boleto não marca como pago automaticamente)
    $pago = ($forma === 'boleto') ? false : true;

    // STATUS ATUALIZADO
    $status = 'Pedido Confirmado';

    // INSERIR PEDIDO
    $sql = $pdo->prepare("
        INSERT INTO pedidos
        (cliente_nome, cliente_email, total, status, forma_pagamento, pago, data_pedido)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");

    $sql->execute([
        $cliente_nome,
        $cliente_email,
        $total,
        $status,
        $forma,
        $pago
    ]);

    $pedido_id = $pdo->lastInsertId();

    // ITEM DO PEDIDO
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

    // ATUALIZAR ESTOQUE
    $sql = $pdo->prepare("
        UPDATE produtos
        SET estoque = estoque - ?
        WHERE id_produtos = ?
    ");

    $sql->execute([
        $quantidade,
        $produto_id
    ]);

    header("Location: atendente.php?msg=pedido_criado");
    exit;

} catch(Exception $e){
    echo "Erro: " . $e->getMessage();
    exit;
}
?>
