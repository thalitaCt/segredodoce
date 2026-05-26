<?php

$clientes = $pdo->query("
SELECT c.*, u.email
FROM clientes c
JOIN usuarios u
ON u.id_usuario = c.usuario_id
ORDER BY c.nome ASC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="card-master">

<div class="topo-secao">

<div>

<h1>Clientes</h1>
<p>Gerencie os clientes cadastrados</p>

</div>

<button
class="btn-principal"
onclick="location.href='clientes/criar.php'">

<i class="fa-solid fa-user-plus"></i>
Novo Cliente

</button>

</div>

<div class="tabela-container">

<table>

<tr>

<th>Cliente</th>
<th>Email</th>
<th>Telefone</th>
<th>Cidade</th>
<th>Ações</th>

</tr>

<?php foreach($clientes as $c): ?>

<tr>

<td>

<div class="cliente-info">

<div class="avatar-cliente">

<?= strtoupper(substr($c['nome'],0,1)) ?>

</div>

<div>

<strong><?= $c['nome'] ?></strong>

<small>
ID: <?= $c['usuario_id'] ?>
</small>

</div>

</div>

</td>

<td><?= $c['email'] ?></td>

<td><?= $c['telefone'] ?></td>

<td>

<?= $c['cidade'] ?? '---' ?>

</td>

<td class="acoes">

<a href="clientes/editar.php?id=<?= $c['usuario_id'] ?>">

<button class="btn-editar">

<i class="fa-solid fa-pen"></i>

</button>

</a>

<a
href="clientes/excluir.php?id=<?= $c['usuario_id'] ?>"
onclick="return confirm('Deseja excluir este cliente?')">

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