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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>
@import url("https://fonts.googleapis.com/css2?family=Yeseva+One&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

:root {
  --bege: #ffedcd;
  --bege2: #fff4ee;
  --bege3: #eacab6;
  --marrom: #7d5147;
  --marrom2: #833c2c;
  --marrom3: #421d14;
  --rosa: #ff877d;
  --rosa2: #ee5350;
  --verde: #347141;
  --branco: #ffffff;
  --preto: #000000;
  --preto2: #1b1b1b;
  --amarelo: #fde047;
  --amarelo2: #facc15;
}

body{
    margin:0;
    font-family:Poppins;
    background:#fff4ee;
}


header{
    background:#ff877d;
    color:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
}

.card-gerente{
    background:white;
    padding:20px;
    margin-bottom:25px;
    border-radius:10px;
    box-shadow:0 0 8px rgba(0,0,0,0.1);
}


.card-gerente h2{
    font-size: 22pt;
    text-align:center;
    text-decoration: underline;
    text-decoration-color:#facc15;
    margin-bottom:15px;
}


/* TABELAS */
table{
    width:100%;
    border-collapse: collapse;
    margin-top:10px;
    background:white;
}


th, td{
    border:1px solid #eee;
    padding:10px;
    text-align:center;
}


th{
    background:#ffedcd;
}


button{
    background:#ff877d;
    color:white;
    border:none;
    padding:6px 10px;
    border-radius:6px;
    cursor:pointer;
    margin:2px;
}


button:hover{
    background:#ee5350;
}

.container {
    margin: 30px;
}


.top-actions{
    display:flex;
    justify-content:flex-end;
    margin-bottom:10px;
}


.top-actions button{
    padding:10px 15px;
    font-weight:bold;
}

.alerta {
  font-family: Poppins;
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: rgb(0, 160, 13);
  color: var(--branco);
  padding: 25px 33px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  gap: 15px;
  z-index: 9999;
  font-weight: 650;
}

.alerta .fechar {
  color: var(--branco);
  font-size: 15px;
  padding: 3px;
  border-radius: 8px;
  font-weight: 700;
  position: absolute;
  top: 8px;
  right: 10px;
  cursor: pointer;
}

/* LISTA */
.item2{
    background:white;
    padding:10px;
    margin:5px 0;
    border-radius:8px;
}

.admin-container{
    max-width:1200px;
    margin:auto;
    padding:30px;
}


.titulo{
    color: var(--rosa);
    margin-bottom:25px;
}


.cards{
    margin-top: 30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}


.card{
    background:#fff;
    border-radius:14px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}


.card h3{
    margin:0 0 10px 0;
    color: var(--rosa);
}


.card p{
    font-size:28px;
    margin:0;
    font-weight:bold;
}


.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}


.box{
    background:#fff;
    padding:20px;
    border-radius:14px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}


.box h2{
    color: var(--rosa);
    margin-top:0;
}


.item{
    padding:10px 0;
    border-bottom:1px solid #eee;
}

.relatorios-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
    gap:20px;
}


.box-relatorio{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}


.box-relatorio h3{
    margin-bottom:15px;
    color:#421d14;
    font-size:18px;
}


.linha{
    display:flex;
    justify-content:space-between;
    padding:8px 0;
    border-bottom:1px solid #eee;
}


.linha:last-child{
    border-bottom:none;
}


.destaque{
    font-size:26px;
    font-weight:bold;
    color:#ff877d;
    text-align:center;
}

</style>
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
    <div>Admin</div>
    <div>Olá, <?= $nome ?> | <a href="logout.php" style="color:white;">Sair</a></div>
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
            <h3>Últimos Dias</h3>


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