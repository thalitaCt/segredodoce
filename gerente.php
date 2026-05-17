<?php
session_start();
include 'includes/conexao.php';


if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'gerente'){
    header("Location: login.php");
    exit;
}


$nome = $_SESSION['nome'] ?? 'Usuário';


/* PRODUTOS */
$produtos = $pdo->query("SELECT * FROM produtos ORDER BY id_produtos DESC")->fetchAll(PDO::FETCH_ASSOC);


/* CLIENTES */
$clientes = $pdo->query("
SELECT c.*, u.email
FROM clientes c
JOIN usuarios u ON u.id_usuario = c.usuario_id
")->fetchAll(PDO::FETCH_ASSOC);


/* ATENDENTES */
$atendentes = $pdo->query("
SELECT f.*, u.email
FROM funcionarios f
JOIN usuarios u ON u.id_usuario = f.usuario_id
WHERE u.tipo = 'atendente'
")->fetchAll(PDO::FETCH_ASSOC);

/* PEDIDOS */
$pedidosLista = $pdo->query("
SELECT *
FROM pedidos
ORDER BY id_pedidos DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/stylePainelGerente.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel do Gerente</title>
</head>

<body>

<?php if(isset($_GET['msg'])): ?>


<div class="alerta">


<?php
switch($_GET['msg']){
    case 'produto_criado':
        echo "Produto criado com sucesso!";
        break;


    case 'produto_editado':
        echo "Produto atualizado com sucesso!";
        break;


    case 'produto_excluido':
        echo "Produto excluído com sucesso!";
        break;


    case 'cliente_criado':
        echo "Cliente criado com sucesso!";
        break;


    case 'cliente_editado':
        echo "Cliente atualizado com sucesso!";
        break;


    case 'cliente_excluido':
        echo "Cliente excluído com sucesso!";
        break;


    case 'atendente_criado':
        echo "Atendente criado com sucesso!";
        break;


    case 'atendente_editado':
        echo "Atendente atualizado com sucesso!";
        break;


    case 'atendente_excluido':
        echo "Atendente excluído com sucesso!";
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
            🍰 Segredo Doce
        </div>

        <div class="painel-titulo">
            Painel do Gerente
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

<?php include 'includes/dashboard.php'; ?>

<div class="container">


<!-- PRODUTOS -->
<div class="card secao" id="secao-produtos">
    <h2>Produtos</h2>


    <div class="top-actions">
        <button onclick="location.href='produtos/criar.php'">Cadastrar Produto</button>
    </div>


    <table>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>


        <?php foreach($produtos as $p): ?>
        <tr>
            <td><?= $p['nome'] ?></td>
            <td>R$ <?= number_format($p['preco'],2,',','.') ?></td>
            <td><?= $p['estoque'] ?></td>
            <td>
                <a href="produtos/editar.php?id=<?= $p['id_produtos'] ?>"><button class="btn-editar"><i class="fa-solid fa-pen"></i></button></a>
                <a href="produtos/excluir.php?id=<?= $p['id_produtos'] ?>"onclick="return confirm('Deseja excluir este produto?')"><button class="btn-excluir"><i class="fa-solid fa-trash"></i></button></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


<!-- CLIENTES -->
<div class="card secao" id="secao-clientes">
    <h2>Clientes</h2>


    <div class="top-actions">
        <button onclick="location.href='clientes/criar.php'">Cadastrar Cliente</button>
    </div>


    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>


        <?php foreach($clientes as $c): ?>
        <tr>
            <td><?= $c['nome'] ?></td>
            <td><?= $c['email'] ?></td>
            <td><?= $c['telefone'] ?></td>
            <td>
                <a href="clientes/editar.php?id=<?= $c['usuario_id'] ?>"><button class="btn-editar"><i class="fa-solid fa-pen"></i></button></a>
                <a href="clientes/excluir.php?id=<?= $c['usuario_id'] ?>"onclick="return confirm('Deseja excluir este cliente?')"><button class="btn-excluir"><i class="fa-solid fa-trash"></i></button></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


<!-- ATENDENTES -->
<div class="card secao" id="secao-atendentes">
    <h2>Atendentes</h2>


    <div class="top-actions">
        <button onclick="location.href='atendentes/criar.php'">Cadastrar Atendente</button>
    </div>


    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Cargo</th>
            <th>Ações</th>
        </tr>


        <?php foreach($atendentes as $a): ?>
        <tr>
            <td><?= $a['nome'] ?></td>
            <td><?= $a['email'] ?></td>
            <td><?= $a['cargo'] ?></td>
            <td>
                <a href="atendentes/editar.php?id=<?= $a['usuario_id'] ?>"><button class="btn-editar"><i class="fa-solid fa-pen"></i></button></a>
                <a href="atendentes/excluir.php?id=<?= $a['usuario_id'] ?>"onclick="return confirm('Deseja excluir este atendente?')"><button class="btn-excluir"><i class="fa-solid fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="card secao" id="secao-pedidos">

<h2>Pedidos</h2>

<table>

<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Total</th>
    <th>Status</th>
    <th>Pagamento</th>
    <th>Data</th>
</tr>

<?php foreach($pedidosLista as $p): ?>

<?php
        $cor = match($p['status']){
            'Pedido confirmado' => 'lightblue',
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

    <td><?= $p['cliente_nome'] ?></td>

    <td>
        R$ <?= number_format($p['total'],2,',','.') ?>
    </td>

    <td class="status" style="color:<?= $cor ?>">
                <?= $p['status'] ?>
            </td>

    <td><?= $p['forma_pagamento'] ?></td>

    <td><?= $p['data_pedido'] ?></td>

</tr>

<?php endforeach; ?>

</table>
</div>

</div>


<script>

function abrirSecao(secao){

    // esconder todas
    document.querySelectorAll('.secao').forEach(function(card){
        card.style.display = 'none';
    });

    // mostrar selecionada
    const elemento = document.getElementById('secao-' + secao);

    if(elemento){
        elemento.style.display = 'block';

        elemento.scrollIntoView({
            behavior:'smooth'
        });
    }
}

</script>

</body>
</html>
