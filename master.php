<?php
session_start();
include 'includes/conexao.php';

if(
    !isset($_SESSION['tipo'])
    ||
    $_SESSION['tipo'] != 'master'
){
    header("Location: login.php");
    exit;
}


/* =========================
   DADOS DASHBOARD
========================= */

/* TOTAL PRODUTOS */
$sqlProdutos = $pdo->query("
SELECT COUNT(*) AS total
FROM produtos
");

$totalProdutos =
$sqlProdutos->fetch(PDO::FETCH_ASSOC)['total'];


/* TOTAL CLIENTES */
$sqlClientes = $pdo->query("
SELECT COUNT(*) AS total
FROM clientes
");

$totalClientes =
$sqlClientes->fetch(PDO::FETCH_ASSOC)['total'];


/* TOTAL PEDIDOS */
$sqlPedidos = $pdo->query("
SELECT COUNT(*) AS total
FROM pedidos
");

$totalPedidos =
$sqlPedidos->fetch(PDO::FETCH_ASSOC)['total'];


/* FATURAMENTO */
$sqlFaturamento = $pdo->query("
SELECT SUM(total) AS total
FROM pedidos
WHERE status != 'Cancelado'
");

$faturamento =
$sqlFaturamento->fetch(PDO::FETCH_ASSOC)['total'];

if(!$faturamento){
    $faturamento = 0;
}


/* ÚLTIMOS PEDIDOS */
$sqlUltimos = $pdo->query("
SELECT
pedidos.id_pedido,
pedidos.total,
pedidos.status,
usuarios.nome
FROM pedidos

INNER JOIN usuarios
ON pedidos.usuario_id = usuarios.id

ORDER BY pedidos.id_pedido DESC
LIMIT 5
");

$ultimosPedidos =
$sqlUltimos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Master Dashboard</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<style>

:root{

    --rosa:#ff8fab;
    --rosa2:#fb6f92;

    --bege:#fff1e6;
    --bege2:#ffe5d9;

    --marrom:#6d4c41;
    --marrom2:#4e342e;

    --verde:#52b788;

    --branco:#ffffff;

    --cinza:#6b7280;

    --bg:#fff8f5;

    --sombra:
    0 10px 30px rgba(0,0,0,0.08);
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:var(--bg);
    display:flex;
    min-height:100vh;
}


/* =========================
   SIDEBAR
========================= */

.sidebar{

    width:280px;

    background:var(--branco);

    padding:30px 20px;

    box-shadow:var(--sombra);

    position:fixed;

    top:0;
    left:0;
    bottom:0;

    z-index:1000;
}

.logo{

    display:flex;
    align-items:center;
    gap:12px;

    margin-bottom:40px;
}

.logo img{
    width:60px;
    height:60px;
    border-radius:50%;
}

.logo-text h1{

    font-size:24px;

    color:var(--marrom2);
}

.logo-text span{

    color:var(--rosa2);

    font-size:13px;
}

.sidebar-menu{

    display:flex;

    flex-direction:column;

    gap:10px;
}

.sidebar-menu a{

    text-decoration:none;

    color:var(--marrom2);

    padding:15px;

    border-radius:16px;

    display:flex;

    align-items:center;

    gap:12px;

    transition:0.3s;
}

.sidebar-menu a:hover{

    background:var(--rosa);

    color:white;

    transform:translateX(5px);
}


/* =========================
   MAIN
========================= */

.main{

    flex:1;

    margin-left:280px;

    padding:30px;
}


/* =========================
   TOPBAR
========================= */

.topbar{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;
}

.topbar h2{

    color:var(--marrom2);

    font-size:32px;
}

.user{

    display:flex;

    align-items:center;

    gap:15px;

    background:white;

    padding:12px 18px;

    border-radius:18px;

    box-shadow:var(--sombra);
}

.user i{

    font-size:22px;

    color:var(--rosa2);
}


/* =========================
   CARDS
========================= */

.cards{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));

    gap:20px;

    margin-bottom:30px;
}

.card{

    background:white;

    border-radius:25px;

    padding:25px;

    box-shadow:var(--sombra);

    position:relative;

    overflow:hidden;
}

.card::before{

    content:'';

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:6px;

    background:var(--rosa2);
}

.card i{

    font-size:32px;

    color:var(--rosa2);

    margin-bottom:15px;
}

.card h3{

    font-size:16px;

    color:var(--cinza);

    margin-bottom:8px;
}

.card h1{

    font-size:34px;

    color:var(--marrom2);
}


/* =========================
   TABELA
========================= */

.area-tabela{

    background:white;

    border-radius:25px;

    padding:25px;

    box-shadow:var(--sombra);
}

.area-tabela h2{

    margin-bottom:20px;

    color:var(--marrom2);
}

table{

    width:100%;

    border-collapse:collapse;
}

table th{

    background:var(--bege2);

    color:var(--marrom2);

    padding:15px;

    text-align:left;
}

table td{

    padding:15px;

    border-bottom:
    1px solid #f1f1f1;
}


/* =========================
   STATUS
========================= */

.status{

    padding:8px 12px;

    border-radius:12px;

    color:white;

    font-size:13px;

    font-weight:600;
}

.preparando{
    background:#f59e0b;
}

.entregue{
    background:#10b981;
}

.cancelado{
    background:#ef4444;
}

.rota{
    background:#3b82f6;
}


/* =========================
   AÇÕES
========================= */

.acoes{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));

    gap:20px;

    margin-top:30px;
}

.acao{

    background:linear-gradient(
    135deg,
    var(--rosa),
    var(--rosa2)
    );

    color:white;

    padding:25px;

    border-radius:25px;

    text-decoration:none;

    box-shadow:var(--sombra);

    transition:0.3s;
}

.acao:hover{

    transform:translateY(-5px);
}

.acao i{

    font-size:32px;

    margin-bottom:15px;
}

.acao h3{

    font-size:20px;

    margin-bottom:8px;
}


/* =========================
   MOBILE
========================= */

@media(max-width:900px){

    .sidebar{

        width:100px;
    }

    .logo-text,
    .sidebar-menu span{

        display:none;
    }

    .main{

        margin-left:100px;
    }
}

@media(max-width:700px){

    body{
        flex-direction:column;
    }

    .sidebar{

        position:relative;

        width:100%;

        display:flex;

        flex-direction:column;
    }

    .main{

        margin-left:0;
    }

    .topbar{

        flex-direction:column;

        align-items:flex-start;

        gap:20px;
    }

    table{

        font-size:13px;
    }
}

</style>
</head>

<body>


<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">

        <img src="imagens/LogoSegredo.png">

        <div class="logo-text">

            <h1>Segredo Doce</h1>

            <span>Painel Master</span>

        </div>

    </div>

    <div class="sidebar-menu">

        <a href="master.php">

            <i class="fa-solid fa-chart-line"></i>

            <span>Dashboard</span>

        </a>

        <a href="gerente.php">

            <i class="fa-solid fa-box"></i>

            <span>Produtos</span>

        </a>

        <a href="gerente.php">

            <i class="fa-solid fa-users"></i>

            <span>Clientes</span>

        </a>

        <a href="atendente.php">

            <i class="fa-solid fa-bag-shopping"></i>

            <span>Pedidos</span>

        </a>

        <a href="admin.php">

            <i class="fa-solid fa-money-bill"></i>

            <span>Financeiro</span>

        </a>

        <a href="admin.php">

            <i class="fa-solid fa-user-tie"></i>

            <span>Funcionários</span>

        </a>

        <a href="logout.php">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>Sair</span>

        </a>

    </div>

</div>


<!-- MAIN -->
<div class="main">


    <!-- TOPBAR -->
    <div class="topbar">

        <h2>Dashboard Master</h2>

        <div class="user">

            <i class="fa-solid fa-user"></i>

            <span>
                Olá,
                <?= $_SESSION['nome'] ?>
            </span>

        </div>

    </div>


    <!-- CARDS -->
    <div class="cards">

        <div class="card">

            <i class="fa-solid fa-money-bill-wave"></i>

            <h3>Faturamento</h3>

            <h1>
                R$
                <?= number_format($faturamento,2,',','.') ?>
            </h1>

        </div>

        <div class="card">

            <i class="fa-solid fa-bag-shopping"></i>

            <h3>Pedidos</h3>

            <h1><?= $totalPedidos ?></h1>

        </div>

        <div class="card">

            <i class="fa-solid fa-cake-candles"></i>

            <h3>Produtos</h3>

            <h1><?= $totalProdutos ?></h1>

        </div>

        <div class="card">

            <i class="fa-solid fa-users"></i>

            <h3>Clientes</h3>

            <h1><?= $totalClientes ?></h1>

        </div>

    </div>


    <!-- TABELA -->
    <div class="area-tabela">

        <h2>Últimos Pedidos</h2>

        <table>

            <tr>

                <th>Pedido</th>

                <th>Cliente</th>

                <th>Valor</th>

                <th>Status</th>

            </tr>

            <?php foreach($ultimosPedidos as $pedido): ?>

            <tr>

                <td>
                    #<?= $pedido['id_pedido'] ?>
                </td>

                <td>
                    <?= $pedido['nome'] ?>
                </td>

                <td>

                    R$
                    <?= number_format(
                    $pedido['total'],
                    2,
                    ',',
                    '.'
                    ) ?>

                </td>

                <td>

<?php

$status = strtolower($pedido['status']);

$classe = '';

if($status == 'preparando'){
    $classe = 'preparando';
}
elseif($status == 'entregue'){
    $classe = 'entregue';
}
elseif($status == 'cancelado'){
    $classe = 'cancelado';
}
else{
    $classe = 'rota';
}

?>

<span class="status <?= $classe ?>">

<?= $pedido['status'] ?>

</span>

                </td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>


    <!-- AÇÕES -->
    <div class="acoes">

        <a href="produtos/criar.php"
        class="acao">

            <i class="fa-solid fa-plus"></i>

            <h3>Novo Produto</h3>

            <p>
                Adicionar novo item
            </p>

        </a>

        <a href="criar_pedido_manual.php"
        class="acao">

            <i class="fa-solid fa-cart-plus"></i>

            <h3>Novo Pedido</h3>

            <p>
                Criar pedido manual
            </p>

        </a>

        <a href="clientes/criar.php"
        class="acao">

            <i class="fa-solid fa-user-plus"></i>

            <h3>Novo Cliente</h3>

            <p>
                Adicionar cliente
            </p>

        </a>

        <a href="atendentes/criar.php"
        class="acao">

            <i class="fa-solid fa-user-tie"></i>

            <h3>Novo Funcionário</h3>

            <p>
                Adicionar funcionário
            </p>

        </a>

    </div>

</div>

</body>
</html>