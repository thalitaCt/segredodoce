<?php
session_start();
include 'includes/conexao.php';


if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'] ?? 'Usuário';



$sqlClientes = $pdo->query("SELECT COUNT(*) AS total FROM clientes");  
$totalClientes = $sqlClientes->fetch(PDO::FETCH_ASSOC)['total'];  
  
  
  
  
/* TOTAL PEDIDOS */  
$sqlPedidos = $pdo->query("SELECT COUNT(*) AS total FROM pedidos");  
$totalPedidos = $sqlPedidos->fetch(PDO::FETCH_ASSOC)['total'];  
  
  
  
  
/* TOTAL VENDIDO */  
$sqlVendas = $pdo->query("SELECT COALESCE(SUM(total),0) AS total FROM pedidos");  
$totalVendas = $sqlVendas->fetch(PDO::FETCH_ASSOC)['total'];  
  
  
  
  
/* ULTIMOS CLIENTES */  
$clientes = $pdo->query("  
    SELECT c.nome, u.email  
    FROM clientes c 
    JOIN usuarios u ON u.id_usuario = c.usuario_id 
    ORDER BY c.id_clientes DESC  
    LIMIT 5  
")->fetchAll(PDO::FETCH_ASSOC);  
  
  
  
  
/* ULTIMOS PEDIDOS */  
$pedidos = $pdo->query("  
    SELECT id_pedidos, cliente_nome, total  
    FROM pedidos  
    ORDER BY id_pedidos DESC  
    LIMIT 5  
")->fetchAll(PDO::FETCH_ASSOC);  

$totalGerentes = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo='gerente'")->fetchColumn();


/* =========================
   GERENTES
========================= */
$gerentes = $pdo->query("
SELECT f.*, u.email
FROM funcionarios f
JOIN usuarios u ON u.id_usuario = f.usuario_id
WHERE u.tipo = 'gerente'
")->fetchAll(PDO::FETCH_ASSOC);


/* =========================
   RELATÓRIOS
========================= */
$statusPedidos = $pdo->query("
SELECT status, COUNT(*) as total
FROM pedidos
GROUP BY status
")->fetchAll(PDO::FETCH_ASSOC);


/* TOP PRODUTOS */
$topProdutos = $pdo->query("
SELECT nome, SUM(quantidade) as total
FROM itens_pedido
GROUP BY nome
ORDER BY total DESC
LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);


/* VENDAS POR DIA */
$vendasDia = $pdo->query("
SELECT DATE(data_pedido) as dia, SUM(total) as total
FROM pedidos
GROUP BY dia
ORDER BY dia DESC
LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Admin</title>
<link rel="stylesheet" href="css/styleAdmin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>


<body>

<?php if(isset($_GET['msg'])): ?>


<div class="alerta">


<?php
switch($_GET['msg']){
    case 'gerente_criado':
        echo "Gerente criado com sucesso!";
        break;


    case 'gerente_editado':
        echo "Gerente atualizado com sucesso!";
        break;


    case 'gerente_excluido':
        echo "Gerente excluído com sucesso!";
        break;


    default:
        echo "Ação realizada com sucesso!";
}
?>


<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>


<?php endif; ?>


<header>

    <div class="header-esquerda">

        <div class="logo-painel">
            Segredo Doce
        </div>

        <div class="painel-titulo">
            Painel do Admin
        </div>

    </div>

    <div class="header-direita">

        <div class="usuario-box">

            <div class="usuario-avatar">
                <?= strtoupper(substr($nome,0,1)) ?>
            </div>

            <div class="usuario-info">
                <span>Olá,</span>
                <strong><?= $nome ?></strong>
            </div>

        </div>

        <a href="logout.php" class="btn-sair">
            Sair
        </a>

    </div>

</header>

<div class="container">

<!-- ================= DASHBOARD ================= -->
<div class="cards">  
    
<div class="card">  
<h3>Clientes</h3>  
<p><?= $totalClientes ?></p>  
</div>  

<div class="card">  
<h3>Pedidos</h3>  
<p><?= $totalPedidos ?></p>  
</div>  

<div class="card">  
<h3>Total Vendido</h3>  
<p>R$ <?= number_format($totalVendas,2,',','.') ?></p>  
</div>

</div>  

<div class="grid">  
    
<div class="box">  

<h2>Últimos Clientes</h2>  

<?php foreach($clientes as $c): ?> 
    
<div class="item">  
<strong><?= $c['nome'] ?></strong><br>  
<?= $c['email'] ?>  
</div>  
<?php endforeach; ?>  
</div>  

<div class="box">  

<h2>Últimos Pedidos</h2>  

<?php foreach($pedidos as $p): ?>  
    
<div class="item">  
Pedido #<?= $p['id_pedidos'] ?><br>  
<?= $p['cliente_nome'] ?><br>  
<strong>R$ <?= number_format($p['total'],2,',','.') ?></strong>  
</div>

<?php endforeach; ?>  
</div>  
</div> 


<!-- ================= GERENTES ================= -->
<section>
<div class="card-gerente">
    <h2>Gerentes</h2>


    <div class="top-actions">
        <button onclick="location.href='gerentes/criar.php'">Cadastrar Gerente</button>
    </div>


    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Cargo</th>
            <th>Ações</th>
        </tr>


        <?php foreach($gerentes as $g): ?>
        <tr>
            <td><?= $g['nome'] ?></td>
            <td><?= $g['email'] ?></td>
            <td><?= $g['cargo'] ?></td>
            <td>
                <a href="gerentes/editar.php?id=<?= $g['usuario_id'] ?>"><button>Editar</button></a>
                <a href="gerentes/excluir.php?id=<?= $g['usuario_id'] ?>"><button>Excluir</button></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


</section>


<!-- ================= RELATÓRIOS ================= -->
<section>
<div class="card-relatorio">
    <h2>Relatórios</h2>


    <div class="relatorios-grid">

        <!-- STATUS -->
        <div class="box-relatorio">
            <h3>Pedidos por Status</h3>


            <?php foreach($statusPedidos as $s): ?>
                <div class="linha">
                    <span><?= $s['status'] ?></span>
                    <strong><?= $s['total'] ?></strong>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- TOP PRODUTOS -->
        <div class="box-relatorio">
            <h3>Produtos Mais Vendidos</h3>


            <?php foreach($topProdutos as $p): ?>
                <div class="linha">
                    <span><?= $p['nome'] ?></span>
                    <strong><?= $p['total'] ?></strong>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- VENDAS POR DIA -->
        <div class="box-relatorio">
            <h3>Vendas por Dias</h3>


            <?php foreach($vendasDia as $v): ?>
                <div class="linha">
                    <span><?= date('d/m', strtotime($v['dia'])) ?></span>
                    <strong>R$ <?= number_format($v['total'],2,',','.') ?></strong>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
</div>
</section>
            </div>

</body>
</html>
