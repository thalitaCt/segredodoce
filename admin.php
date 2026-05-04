<?php
session_start();
include 'includes/conexao.php';


if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}


/* =========================
   AÇÕES
========================= */


/* CRIAR GERENTE */
if(isset($_POST['acao']) && $_POST['acao'] == 'criar'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cargo = $_POST['cargo'];
    $salario = $_POST['salario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);


    $sql = $pdo->prepare("INSERT INTO usuarios (email, senha, tipo) VALUES (?, ?, 'gerente')");
    $sql->execute([$email, $senha]);


    $usuario_id = $pdo->lastInsertId();


    $sql = $pdo->prepare("
    INSERT INTO funcionarios (usuario_id, nome, telefone, cargo, salario)
    VALUES (?, ?, ?, ?, ?)
    ");
    $sql->execute([$usuario_id, $nome, $telefone, $cargo, $salario]);
}


/* EXCLUIR */
if(isset($_GET['excluir'])){
    $id = $_GET['excluir'];


    $pdo->prepare("DELETE FROM funcionarios WHERE usuario_id=?")->execute([$id]);
    $pdo->prepare("DELETE FROM usuarios WHERE id_usuario=?")->execute([$id]);
}


/* EDITAR (CARREGAR) */
$editar = null;
if(isset($_GET['editar'])){
    $id = $_GET['editar'];


    $sql = $pdo->prepare("
    SELECT u.id_usuario, u.email, f.nome, f.telefone, f.cargo, f.salario
    FROM usuarios u
    JOIN funcionarios f ON f.usuario_id = u.id_usuario
    WHERE u.id_usuario = ?
    ");
    $sql->execute([$id]);
    $editar = $sql->fetch(PDO::FETCH_ASSOC);
}


/* SALVAR EDIÇÃO */
if(isset($_POST['acao']) && $_POST['acao'] == 'salvar'){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cargo = $_POST['cargo'];
    $salario = $_POST['salario'];


    $pdo->prepare("UPDATE usuarios SET email=? WHERE id_usuario=?")
        ->execute([$email, $id]);


    $pdo->prepare("
    UPDATE funcionarios
    SET nome=?, telefone=?, cargo=?, salario=?
    WHERE usuario_id=?
    ")->execute([$nome, $telefone, $cargo, $salario, $id]);
}


/* =========================
   DADOS
========================= */


$gerentes = $pdo->query("
SELECT u.id_usuario, u.email, f.nome, f.telefone, f.cargo, f.salario
FROM usuarios u
JOIN funcionarios f ON f.usuario_id = u.id_usuario
WHERE u.tipo = 'gerente'
")->fetchAll(PDO::FETCH_ASSOC);


/* DASHBOARD */
$totalClientes = $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
$totalPedidos = $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
$totalVendas = $pdo->query("SELECT COALESCE(SUM(total),0) FROM pedidos")->fetchColumn();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Admin</title>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>
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


/* CARDS */
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
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}


/* SEÇÕES */
section{
    padding:20px;
}


/* FORM */
form{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}


form input{
    padding:10px;
    border-radius:10px;
    border:1px solid #ccc;
}


button{
    background:#ff877d;
    color:white;
    border:none;
    padding:10px;
    border-radius:10px;
    cursor:pointer;
}


/* TABELA */
table{
    width:100%;
    background:white;
    border-collapse:collapse;
}


th,td{
    padding:10px;
    border-bottom:1px solid #ddd;
}


a{
    text-decoration:none;
    margin:5px;
    font-weight:bold;
}

.top-actions{
    margin-bottom:10px;
}


.top-actions button{
    background:#ff877d;
    color:white;
    border:none;
    padding:10px;
    border-radius:8px;
    cursor:pointer;
}


table{
    width:100%;
    background:white;
    border-collapse:collapse;
}


th, td{
    padding:10px;
    border-bottom:1px solid #ddd;
}


button{
    background:#ff877d;
    color:white;
    border:none;
    padding:8px;
    border-radius:6px;
    cursor:pointer;
}

</style>
</head>


<body>


<header>
    <div>Admin</div>
    <div><a href="logout.php" style="color:white;">Sair</a></div>
</header>


<!-- DASHBOARD -->
<section>
<div class="grid">


<div class="card">
<i class="fa-solid fa-users"></i>
<p><?= $totalClientes ?></p>
Clientes
</div>


<div class="card">
<i class="fa-solid fa-receipt"></i>
<p><?= $totalPedidos ?></p>
Pedidos
</div>


<div class="card">
<i class="fa-solid fa-coins"></i>
<p>R$ <?= number_format($totalVendas,2,',','.') ?></p>
Vendas
</div>


</div>
</section>


<!-- GERENTES -->
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
            <th>Telefone</th>
            <th>Cargo</th>
            <th>Salário</th>
            <th>Ações</th>
        </tr>


        <?php foreach($gerentes as $g): ?>
        <tr>
            <td><?= $g['nome'] ?></td>
            <td><?= $g['email'] ?></td>
            <td><?= $g['telefone'] ?></td>
            <td><?= $g['cargo'] ?></td>
            <td>R$ <?= number_format($g['salario'],2,',','.') ?></td>
            <td>
                <a href="gerentes/editar.php?id=<?= $g['id_usuario'] ?>">
                    <button>Editar</button>
                </a>


                <a href="gerentes/excluir.php?id=<?= $g['id_usuario'] ?>" onclick="return confirm('Excluir gerente?')">
                    <button>Excluir</button>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</section>


</body>
</html>