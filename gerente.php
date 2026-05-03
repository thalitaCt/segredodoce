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
WHERE u.tipo = 'recepcionista'
")->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Painel do Gerente</title>


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
    font-family:Poppins;
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
    padding:20px;
    margin-bottom:25px;
    border-radius:10px;
    box-shadow:0 0 8px rgba(0,0,0,0.1);
}


.card h2{
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
</style>
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
    <div>Gerente</div>
    <div>Olá, <?= $nome ?> | <a href="../logout.php" style="color:white;">Sair</a></div>
</header>


<div class="container">


<!-- PRODUTOS -->
<div class="card">
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
                <a href="produtos/editar.php?id=<?= $p['id_produtos'] ?>"><button>Editar</button></a>
                <a href="produtos/excluir.php?id=<?= $p['id_produtos'] ?>"><button>Excluir</button></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


<!-- CLIENTES -->
<div class="card">
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
                <a href="clientes/editar.php?id=<?= $c['usuario_id'] ?>"><button>Editar</button></a>
                <a href="clientes/excluir.php?id=<?= $c['usuario_id'] ?>"><button>Excluir</button></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


<!-- ATENDENTES -->
<div class="card">
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
                <a href="atendentes/editar.php?id=<?= $a['usuario_id'] ?>"><button>Editar</button></a>
                <a href="atendentes/excluir.php?id=<?= $a['usuario_id'] ?>"><button>Excluir</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>


</div>


</body>
</html>
