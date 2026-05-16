<?php
session_start();
include 'includes/conexao.php';

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'atendente'){
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'] ?? 'Usuário';

$sql = $pdo->prepare("SELECT * FROM pedidos ORDER BY data_pedido DESC");
$sql->execute();
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
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

:root {
  --rosa:#ff877d;
  --rosa2:#ee5350;
  --bege:#fff4ee;
  --marrom:#7d5147;
  --verde:#347141;
  --cinza:#666;
}

body{
    font-family:Poppins;
    margin:0;
    background:var(--bege);
}

header{
    background:var(--rosa);
    color:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
}

.container{
    padding:20px;
}

/* CARD PRINCIPAL */
.card{
    background:white;
    padding:15px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 0 5px rgba(0,0,0,0.1);
}

/* NOVO PEDIDO */
.card.pedido form{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

.card.pedido input,
.card.pedido select{
    padding:10px;
    border-radius:10px;
    border:1px solid #ddd;
    width:200px;
}

.card.pedido button{
    background:var(--rosa);
    color:white;
    border:none;
    padding:10px;
    border-radius:10px;
    cursor:pointer;
    font-weight:700;
}

/* TABELA */
table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:10px;
    border-bottom:1px solid #eee;
    text-align:center;
}

/* STATUS */
.status{
    font-weight:bold;
}

/* ALERTA */
.alerta{
    position:fixed;
    top:20px;
    right:20px;
    background:#00a00d;
    color:white;
    padding:20px;
    border-radius:10px;
    font-weight:600;
}

.fechar{
    margin-left:10px;
    cursor:pointer;
}

/* MOBILE */
@media(max-width:768px){
    .card.pedido form{
        flex-direction:column;
    }

    .card.pedido input,
    .card.pedido select{
        width:100%;
    }
}
</style>

</head>

<body>

<?php if(isset($_GET['msg'])): ?>
<div class="alerta">
<?php
if($_GET['msg'] == 'pedido_criado') echo "Pedido realizado com sucesso";
if($_GET['msg'] == 'status_atualizado') echo "Status atualizado com sucesso";
if($_GET['msg'] == 'erro_status') echo "Status inválido";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>



<header>
    <div>Atendente</div>
    <div>Olá, <?= htmlspecialchars($nome) ?> | <a href="../logout.php" style="color:white;">Sair</a></div>
</header>

<div class="container">

<!-- NOVO PEDIDO -->
<div class="card pedido">
    <h2>Novo Pedido</h2>

    <form action="criar_pedido_manual.php" method="POST">

        <input type="text" name="cliente_nome" placeholder="Nome do cliente" required>

        <input type="email" name="cliente_email" placeholder="Email do cliente" required>

        <select name="produto_id" required>
            <?php
            $produtos = $pdo->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
            foreach($produtos as $prod){
                echo "<option value='{$prod['id_produtos']}'>
                        {$prod['nome']} - R$ {$prod['preco']}
                      </option>";
            }
            ?>
        </select>

        <input type="number" name="quantidade" placeholder="Quantidade" min="1" required>

        <select name="forma_pagamento" required>
            <option value="pix">Pix</option>
            <option value="cartao">Cartão</option>
            <option value="boleto">Boleto</option>
        </select>

        <button type="submit">Criar Pedido</button>
    </form>
</div>

<!-- LISTA DE PEDIDOS -->
<div class="card">
    <h2>Pedidos</h2>

    <table>
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
            'Pedido Confirmado' => 'blue',
            'Pendente' => 'orange',
            'Em preparo' => 'blue',
            'Pronto' => 'green',
            'Entregue' => 'gray',
            'Cancelado' => 'red',
            default => 'black'
        };
        ?>

        <tr>
            <td><?= $p['id_pedidos'] ?></td>
            <td><?= htmlspecialchars($p['cliente_nome']) ?></td>
            <td>R$ <?= number_format($p['total'], 2, ',', '.') ?></td>
            <td><?= $p['forma_pagamento'] ?></td>
            <td><?= $p['pago'] ? 'Pago' : 'Pendente' ?></td>

            <td class="status" style="color:<?= $cor ?>">
                <?= $p['status'] ?>
            </td>

            <td>
                <form action="atualizar_status.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id_pedidos'] ?>">

                    <select name="status">
                        <option <?= $p['status']=='Pedido Confirmado'?'selected':'' ?>>Pedido Confirmado</option>
                        <option <?= $p['status']=='Pendente'?'selected':'' ?>>Pendente</option>
                        <option <?= $p['status']=='Em preparo'?'selected':'' ?>>Em preparo</option>
                        <option <?= $p['status']=='Pronto'?'selected':'' ?>>Pronto</option>
                        <option <?= $p['status']=='Entregue'?'selected':'' ?>>Entregue</option>
                        <option <?= $p['status']=='Cancelado'?'selected':'' ?>>Cancelado</option>
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
