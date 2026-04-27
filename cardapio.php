<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleCardapio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Produtos</title>
</head>
<body>

<?php if (isset($_GET['msg'])): ?>
    
<div class="alerta" id="alerta">

<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>

<span><?php echo $_GET['nome']; ?> adicionado ao Carrinho</span>
    </div>

    <?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'estoque') echo "Produto sem estoque";
if ($_GET['erro'] == 'produto') echo "Produto não encontrado";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<?php
session_start();
include 'includes/conexao.php';

    $sql = $pdo->query("SELECT * FROM produtos ORDER BY id_produtos");
    $produtos = $sql->fetchAll();
?>
    <?php include 'includes/navbar.php'; ?>
        <h2 class="titulo">Nossos Produtos</h2>

        <div class="produtos">

<?php foreach($produtos as $p): ?>
            <div class="produto <?php if($p['estoque'] <= 0) echo 'sem-estoque'; ?>">
                <img src="<?= $p['imagem']; ?>">
                <h2><?= $p['nome']; ?></h2>

            <div class="info">

                 <div class="esquerda">
                <p><?= $p['descricao']; ?></p>
                <span>R$ <?= number_format($p['preco'],2,",","."); ?></span>
                <h3>Estoque: <?= $p['estoque']; ?></h3>
            </div>

            <div class="direita">

                <h3 class="categoria <?= strtolower(str_replace(' ', '-',$p['categoria'])); ?>"><?= $p['categoria']; ?></h3>
                <div class="estrelas">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                </div>

            </div>

            </div>

<form action="actions/add.php" method="POST">
<input type="hidden" name="id" value="<?= $p['id_produtos']; ?>">

<?php if($p['estoque'] > 0): ?>

<button type="submit" class="btn-carrinho">
<a href="cardapio.php"><i class="fa-solid fa-basket-shopping"></i></a></button>
            
<?php else: ?>
<button disabled>Esgotado</button>
<?php endif; ?>
</form>
        </div>
<?php endforeach; ?>

    </div>
        
    <?php include 'includes/footer.php'; ?>
</body>
</html>