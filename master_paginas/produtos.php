<?php

$produtos = $pdo->query("
SELECT *
FROM produtos
ORDER BY id_produtos DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="card-master">

<div class="topo-secao">

<div>

<h1>Produtos</h1>
<p>Gerencie os produtos da loja</p>

</div>

<button
class="btn-principal"
onclick="location.href='produtos/criar.php'">

<i class="fa-solid fa-plus"></i>
Novo Produto

</button>

</div>

<div class="tabela-container">

<table>

<tr>

<th>ID</th>
<th>Produto</th>
<th>Preço</th>
<th>Estoque</th>
<th>Ações</th>

</tr>

<?php foreach($produtos as $p): ?>

<tr>

<td>
#<?= $p['id_produtos'] ?>
</td>

<td class="produto-info">

<img
src="<?= $p['imagem'] ?>"
class="img-tabela">

<div>

<strong><?= $p['nome'] ?></strong>

<small>
<?= $p['categoria'] ?>
</small>

</div>

</td>

<td>

R$
<?= number_format($p['preco'],2,',','.') ?>

</td>

<td>

<?php if($p['estoque'] <= 5): ?>

<span class="estoque-baixo">

<?= $p['estoque'] ?>

</span>

<?php else: ?>

<?= $p['estoque'] ?>

<?php endif; ?>

</td>

<td class="acoes">

<a href="produtos/editar.php?id=<?= $p['id_produtos'] ?>">

<button class="btn-editar">

<i class="fa-solid fa-pen"></i>

</button>

</a>

<a
href="produtos/excluir.php?id=<?= $p['id_produtos'] ?>"
onclick="return confirm('Deseja excluir este produto?')">

<button class="btn-excluir">

<i class="fa-solid fa-trash"></i>

</button>

</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</div>