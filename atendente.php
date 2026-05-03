<?php
session_start();
include 'includes/conexao.php';


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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<title>Painel do Atendente</title>

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
    font-family: Poppins;
    margin:0;
    background:#fff4ee;
}


header{
    background:#ff877d;
    color:white;
    padding:20px;
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
            <td><?= $p['id_pedidos'] ?></td>
            <td><?= $p['cliente_nome'] ?? 'Cliente' ?></td>
            <td>R$ <?= number_format($p['total'], 2, ',', '.') ?></td>


            <td><?= $p['forma_pagamento'] ?></td>


            <td>
                <?= $p['pago'] ? 'Pago' : 'Pendente' ?>
            </td>


            <td class="status" style="color:<?= $cor ?>">
                <?= $p['status'] ?>
            </td>


            <td>
                <form action="atualizar_status.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id_pedidos'] ?>">


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
