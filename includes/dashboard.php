<?php
include 'includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: login.php");
    exit;
}


/* pedidos */
$pedidos = $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();


/* clientes */
$clientes = $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();


/* funcionarios */
$funcionarios = $pdo->query("SELECT COUNT(*) FROM funcionarios")->fetchColumn();


/* produtos */
$produtos = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();


/* pedidos pendentes */
$pendentes = $pdo->query("SELECT COUNT(*) FROM pedidos WHERE status = 'Pendente'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    .dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin: 30px;
    font-family: Poppins;
}


.card-dash {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
    cursor: pointer;
    border-left: 6px solid var(--rosa);
}


.card-dash:hover {
    transform: translateY(-5px) scale(1.02);
}


.card-dash h3 {
    margin: 0;
    font-size: 16px;
    color: #555;
}


.card-dash .numero {
    font-size: 28px;
    font-weight: bold;
    margin-top: 10px;
    color: var(--marrom3);
}


.titulo-dashboard {
    font-family: Poppins;
    font-size: 22pt;
    text-align: center;
    text-decoration: underline;
    text-decoration-color: var(--amarelo2);
    margin-top: 20px;
    color: var(--marrom3);
}

.card-dash.ativo {
    border-left: 6px solid var(--verde);
}
</style>
</head>
<body>

<h2 class="titulo-dashboard">Dashboard do Gerente</h2>


<div class="dashboard">


    <div class="card-dash" onclick="abrirSecao('pedidos')">
        <h3>Total de Pedidos</h3>
        <div class="numero"><?= $pedidos ?></div>
    </div>


    <div class="card-dash" onclick="abrirSecao('clientes')">
        <h3>Clientes</h3>
        <div class="numero"><?= $clientes ?></div>
    </div>


    <div class="card-dash" onclick="abrirSecao('atendente')">
        <h3>Funcionários</h3>
        <div class="numero"><?= $funcionarios ?></div>
    </div>


    <div class="card-dash" onclick="abrirSecao('produtos')">
        <h3>Produtos</h3>
        <div class="numero"><?= $produtos ?></div>
    </div>


    <div class="card-dash">
        <h3>Pedidos Pendentes</h3>
        <div class="numero"><?= $pendentes ?></div>
    </div>


</div>

</body>
</html>