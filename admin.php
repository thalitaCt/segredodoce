<?php
session_start();
include 'includes/conexao.php';


if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'] ?? 'Usuário';


/* =========================
   AÇÕES (CRIAR GERENTE)
========================= */

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cargo = $_POST['cargo'];
    $salario = $_POST['salario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);


    /* cria usuário */
    $sql = $pdo->prepare("
    INSERT INTO usuarios (email, senha, tipo)
    VALUES (?, ?, 'gerente')
    ");
    $sql->execute([$email, $senha]);


    $usuario_id = $pdo->lastInsertId();


    /* cria funcionario */
    $sql = $pdo->prepare("
    INSERT INTO funcionarios (usuario_id, nome, telefone, cargo)
    VALUES (?, ?, ?, 'Gerente')
    ");
    $sql->execute([$usuario_id, $nome, $telefone]);


/* =========================
   DASHBOARD
========================= */
/* TOTAL CLIENTES */  
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
SELECT u.id_usuario, u.email, f.nome, f.telefone
FROM usuarios u
JOIN funcionarios f ON f.usuario_id = u.id_usuario
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


/* DASHBOARD */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    padding:20px;
}


.card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    border-left:6px solid #ff877d;
}


.card i{
    font-size:22px;
    color:#ff877d;
}


.card p{
    font-size:24px;
    font-weight:bold;
}


/* SEÇÕES */
section{
    padding:20px;
}


h2{
    color:#421d14;
}


/* FORM */
form input{
    padding:10px;
    margin:5px;
    border-radius:8px;
    border:1px solid #ccc;
}


form button{
    padding:10px;
    background:#ff877d;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}


/* TABELA */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
}


th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
}


/* LISTA */
.item{
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
    margin-top: 50px;
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
</style>
</head>


<body>


<header>
    <div>Admin</div>
    <div>Olá, <?= $nome ?> | <a href="logout.php" style="color:white;">Sair</a></div>
</header>


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
</div>


</div>


<!-- ================= GERENTES ================= -->
<section>
<div class="card">
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
                <a href="gerentes/editar.php?id=<?= $g['id_usuario'] ?>"><button>Editar</button></a>
                <a href="gerentes/excluir.php?id=<?= $g['id_usuario'] ?>"><button>Excluir</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


</section>


<!-- ================= RELATÓRIOS ================= -->
<section>
<h2>Relatórios</h2>


<?php foreach($statusPedidos as $s): ?>
<div class="item">
<?= $s['status'] ?>: <?= $s['total'] ?>
</div>
<?php endforeach; ?>


</section>

</body>
</html>