<?php
session_start();
include 'includes/conexao.php';


if ($_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}


/* VENDAS */
$totalVendas = $pdo->query("SELECT COALESCE(SUM(total),0) FROM pedidos")->fetchColumn();


/* STATUS */
$status = $pdo->query("
SELECT status, COUNT(*) as total
FROM pedidos
GROUP BY status
")->fetchAll(PDO::FETCH_ASSOC);
?>


<h2>Relatórios Financeiros</h2>


<h3>Total vendido: R$ <?= number_format($totalVendas,2,',','.') ?></h3>


<h3>Pedidos por status</h3>


<ul>
<?php foreach($status as $s): ?>
    <li><?= $s['status'] ?>: <?= $s['total'] ?></li>
<?php endforeach; ?>
</ul>