<?php

$atendentes = $pdo->query("
SELECT f.*, u.email
FROM funcionarios f
JOIN usuarios u
ON u.id_usuario = f.usuario_id
WHERE u.tipo = 'atendente'
ORDER BY f.nome ASC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="card-master">

<div class="topo-secao">

<div>

<h1>Atendentes</h1>
<p>Gerencie os funcionários da loja</p>

</div>

<button
class="btn-principal"
onclick="location.href='atendentes/criar.php'">

<i class="fa-solid fa-user-plus"></i>
Novo Atendente

</button>

</div>

<div class="tabela-container">

<table>

<tr>

<th>Funcionário</th>
<th>Email</th>
<th>Cargo</th>
<th>Ações</th>

</tr>

<?php foreach($atendentes as $a): ?>

<tr>

<td>

<div class="cliente-info">

<div class="avatar-funcionario">

<?= strtoupper(substr($a['nome'],0,1)) ?>

</div>

<div>

<strong><?= $a['nome'] ?></strong>

<small>
ID: <?= $a['usuario_id'] ?>
</small>

</div>

</div>

</td>

<td><?= $a['email'] ?></td>

<td>

<span class="badge-cargo">

<?= $a['cargo'] ?>

</span>

</td>

<td class="acoes">

<a href="atendentes/editar.php?id=<?= $a['usuario_id'] ?>">

<button class="btn-editar">

<i class="fa-solid fa-pen"></i>

</button>

</a>

<a
href="atendentes/excluir.php?id=<?= $a['usuario_id'] ?>"
onclick="return confirm('Deseja excluir este atendente?')">

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