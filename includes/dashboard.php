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
    border-left: 6px solid var(--rosa);
}


.card-dash:hover {
    transform: translateY(-5px);
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
</style>
</head>
<body>

<h2 class="titulo-dashboard">Dashboard do Gerente</h2>


<div class="dashboard">


    <div class="card-dash">
        <h3>Total de Pedidos</h3>
        <div class="numero"><?= $pedidos ?></div>
    </div>


    <div class="card-dash">
        <h3>Clientes</h3>
        <div class="numero"><?= $clientes ?></div>
    </div>


    <div class="card-dash">
        <h3>Funcionários</h3>
        <div class="numero"><?= $funcionarios ?></div>
    </div>


    <div class="card-dash">
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