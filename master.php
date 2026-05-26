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

$pagina = $_GET['pagina'] ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="css/painel.css">

<title>Painel Master</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root{
    --rosa:#ff877d;
    --rosa2:#ee5350;
    --marrom:#421d14;
    --fundo:#fff7f3;
    --branco:#ffffff;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins;
}

body{
    background:var(--fundo);
    display:flex;
}

/* SIDEBAR */

.sidebar{
    width:260px;
    min-height:100vh;
    background:linear-gradient(
    180deg,
    var(--rosa),
    var(--rosa2)
    );

    color:white;
    padding:25px;
    position:fixed;
    left:0;
    top:0;
}

.logo{
    font-size:28px;
    font-weight:700;
    margin-bottom:40px;
}

.logo span{
    display:block;
    font-size:13px;
    font-weight:400;
    opacity:0.8;
}

.menu{
    display:flex;
    flex-direction:column;
    gap:15px;
}

.menu a{
    color:white;
    text-decoration:none;
    padding:14px;
    border-radius:12px;
    transition:0.3s;
    display:flex;
    align-items:center;
    gap:12px;
}

.menu a:hover{
    background:rgba(255,255,255,0.15);
}

/* CONTEÚDO */

.main{
    margin-left:260px;
    width:100%;
    padding:35px;
}

.topo{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.usuario{
    background:white;
    padding:12px 18px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

</style>
</head>

<body>

<div class="sidebar">

<div class="logo">
Segredo Doce
<span>Painel Master</span>
</div>

<div class="menu">

<a href="master.php">
<i class="fa-solid fa-chart-line"></i>
Dashboard
</a>

<a href="master.php?pagina=produtos">
<i class="fa-solid fa-cake-candles"></i>
Produtos
</a>

<a href="master.php?pagina=pedidos">
<i class="fa-solid fa-box"></i>
Pedidos
</a>

<a href="master.php?pagina=clientes">
<i class="fa-solid fa-users"></i>
Clientes
</a>

<a href="master.php?pagina=funcionarios">
<i class="fa-solid fa-user-tie"></i>
Funcionários
</a>

<a href="logout.php">
<i class="fa-solid fa-right-from-bracket"></i>
Sair
</a>

</div>

</div>

<div class="main">

<div class="topo">

<h1>Painel Administrativo</h1>

<div class="usuario">
Olá,
<?= $_SESSION['nome'] ?>
</div>

</div>

<?php

switch($pagina){

    case 'produtos':
        include 'master_paginas/produtos.php';
    break;

    case 'pedidos':
        include 'master_paginas/pedidos.php';
    break;

    case 'clientes':
        include 'master_paginas/clientes.php';
    break;

    case 'funcionarios':
        include 'master_paginas/funcionarios.php';
    break;

    default:
        include 'master_paginas/dashboard.php';
}

?>

</div>

</body>
</html>