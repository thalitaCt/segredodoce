<?php
session_start();
include '/includes/conexao.php';


if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'recepcionista'){
    header("Location: ../login.php");
    exit;
}

$nome = $_SESSION['nome'] ?? 'Usuário';

$sql = $pdo->query("SELECT * FROM pedidos ORDER BY data_pedido DESC");
$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel do Atendente</title>


<style>
body{
    font-family: Arial;
    margin:0;
    background:#fff4ee;
}


header{
    background:#ff877d;
    color:white;
    padding:15px;
    display:flex;
    justify-content:space-between;
}


.container{
    padding:20px;
}


.card{
    background:white;
    padding:15px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 0 5px rgba(0,0,0,0.1);
}


button{
    background:#ff877d;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:5px;
    cursor:pointer;
}


select{
    padding:5px;
}


.status{
    font-weight:bold;
}


</style>
</head>


<body>


<header>
    <div>Atendente</div>
    <div>Olá, <?= $nome ?> | <a href="../logout.php" style="color:white;">Sair</a></div>
</header>


<div class="container">


<div class="card">
    <h2>Pedidos</h2>


    <table border="1" width="100%" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Valor</th>
            <th>Pagamento</th>
            <th>Status Pagamento</th>
            <th>Status Pedido</th>
            <th>Ação</th>
        </tr>


        <?php foreach($pedidos as $p): ?>


        <?php
        $cor = match($p['status']){
            'Pendente' => 'orange',
            'Em preparo' => 'blue',
            'Pronto' => 'green',
            'Entregue' => 'gray',
            default => 'black'
        };
        ?>


        <tr>
            <td><?= $p['id_pedido'] ?></td>
            <td><?= $p['cliente_nome'] ?? 'Cliente' ?></td>
            <td>R$ <?= number_format($p['total'], 2, ',', '.') ?></td>


            <td><?= $p['forma_pagamento'] ?></td>


            <td>
                <?= $p['pago'] ? '✅ Pago' : '❌ Pendente' ?>
            </td>


            <td class="status" style="color:<?= $cor ?>">
                <?= $p['status'] ?>
            </td>


            <td>
                <form action="atualizar_status.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id_pedido'] ?>">


                    <select name="status">
                        <option <?= $p['status']=='Pendente'?'selected':'' ?>>Pendente</option>
                        <option <?= $p['status']=='Em preparo'?'selected':'' ?>>Em preparo</option>
                        <option <?= $p['status']=='Pronto'?'selected':'' ?>>Pronto</option>
                        <option <?= $p['status']=='Entregue'?'selected':'' ?>>Entregue</option>
                    </select>


                    <button type="submit">Atualizar</button>
                </form>
            </td>
        </tr>


        <?php endforeach; ?>


    </table>
</div>


</div>


</body>
</html>
