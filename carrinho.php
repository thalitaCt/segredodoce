<?php 
    session_start();
    include 'includes/conexao.php';

    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    if (isset($_GET['aumentar'])) {
    $id = $_GET['aumentar'];

    $sql = $pdo->prepare("SELECT estoque FROM produtos WHERE id_produtos = ?");
    $sql->execute([$id]);
    $produtoBD = $sql->fetch(PDO::FETCH_ASSOC);

    if (isset($_SESSION['carrinho'][$id])) {

        $qtdAtual = $_SESSION['carrinho'][$id]['quantidade'];
        $estoque = $produtoBD['estoque'] ?? 0;

        if ($qtdAtual < $estoque) {
            $_SESSION['carrinho'][$id]['quantidade']++;
        }
    }

    header("Location: carrinho.php");
    exit;
}


    if(isset($_GET['remover'])) {
        $id = $_GET['remover'];

        if(isset($_SESSION['carrinho'][$id])) {
        if ($_SESSION['carrinho'][$id]['quantidade'] > 1) {
            $_SESSION['carrinho'][$id]['quantidade']--;
        } else {
            unset($_SESSION['carrinho'][$id]);
        }
    }

    header("Location: carrinho.php");
    exit;
    }

    if (isset($_GET['removerTudo'])) {
        $id = $_GET['removerTudo'];
        unset($_SESSION['carrinho'][$id]);

        header("Location: carrinho.php");
        exit;
    }

    if(isset($_GET['limpar'])) {
        $_SESSION['carrinho'] = [];

        header("Location: carrinho.php");
        exit;
    }

    $carrinho = $_SESSION['carrinho'];
    $total = 0;
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/styleCarrinho.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

    <h1>Seu Carrinho</h1>

    <?php if (empty($carrinho)):  ?> 
        <p>Seu carrinho está vazio</p> 
    <?php else: ?>

        <div class="carrinho-container">

         <div class="produtos">

        <?php foreach ($carrinho as $id => $produto): ?>

            <?php
            $sql = $pdo->prepare("SELECT estoque FROM produtos WHERE id_produtos = ?");
            $estoque = $sql->fetchColumn();
            ?>

            <?php

            if (!isset($_SESSION['carrinho'][$id]['quantidade'])) {
                $_SESSION['carrinho'][$id]['quantidade'] = 1;
            }

            $qtde = $_SESSION['carrinho'][$id]['quantidade'];
            $totalItem = $produto['preco'] * $qtde;
            $total += $totalItem;
            ?>

            <div class="item">

                <img src="<?php  echo $produto['imagem']; ?>">

                <div class="nome">
                <?php echo $produto['nome']; ?>
        </div>

            <div class="preco">
        R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
        </div>
            
        <div class="quantidade">

            <a href="carrinho.php?remover=<?php echo $id; ?>">-</a>

            <span>
                <?php echo $qtde; ?>
            </span>

            <?php if($qtde < $produto['estoque']): ?>
            <a href="carrinho.php?aumentar=<?php echo $id; ?>">+</a>
            <?php else: ?>
                <span class="bloqueado">+</span>
            <?php endif; ?>
        </div>

        <div class="total">
            R$ <?php echo number_format($totalItem, 2, ',', '.'); ?>
        </div>

        <div class="remover">
            <a href="carrinho.php?removerTudo=<?php echo $id; ?>">X</a>
        </div>
        </div>

            <?php endforeach; ?>

        </div>

        <div class="resumo">
            <h2>Resumo do Pedido</h2>

            <p><span>Subtotal:</span> R$ <?php echo number_format($total, 2, ',', '.'); ?></p>

            <p><span>Frete:</span>Será calculado</p>

            <p id="linha"> </p>

            <p> 
                <strong>Total parcial:</strong> R$ <?php echo number_format($total, 2, ',', '.'); ?>
                
        </p>

            <button id="finalizar"><a href="frete.php">Finalizar Compra</a></button>
        </div>
        </div>

            <a href="carrinho.php?limpar=true"><button id="limpar">Limpar Carrinho</button></a>

            <?php endif; ?>

</body>
</html>