<?php
session_start();
include 'includes/conexao.php';


if ($_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}


$gerentes = $pdo->query("
SELECT u.id_usuario, u.email, f.nome, f.telefone
FROM usuarios u
JOIN funcionarios f ON f.usuario_id = u.id_usuario
WHERE u.tipo = 'gerente'
")->fetchAll(PDO::FETCH_ASSOC);
?>


<h2>Gerenciar Gerentes</h2>


<a href="criar_gerente.php">+ Novo Gerente</a>


<table border="1" width="100%" cellpadding="8">
<tr>
    <th>Nome</th>
    <th>Email</th>
    <th>Telefone</th>
    <th>Ações</th>
</tr>


<?php foreach($gerentes as $g): ?>
<tr>
    <td><?= $g['nome'] ?></td>
    <td><?= $g['email'] ?></td>
    <td><?= $g['telefone'] ?></td>
    <td>
        <a href="editar_gerente.php?id=<?= $g['id_usuario'] ?>">Editar</a>
        <a href="excluir_gerente.php?id=<?= $g['id_usuario'] ?>">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
