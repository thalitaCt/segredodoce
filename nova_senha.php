<?php
include 'includes/conexao.php';


$token = $_GET['token'] ?? null;


if(!$token){
    header("Location: login.php?erro=token");
    exit;
}


$sql = "SELECT * FROM usuarios WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute(['token' => $token]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if(!$usuario || strtotime($usuario['token_expira']) < time()){
    header("Location: login.php?erro=token_invalido");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nova Senha</title>


<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


:root{
    --rosa:#ff877d;
    --rosa2:#ee5350;
    --bege:#fff4ee;
    --branco:#fff;
}


*{
    margin:0;
    padding:0;
    font-family:Poppins;
    box-sizing:border-box;
}


body{
    background:var(--bege);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}


.container{
    background:var(--rosa);
    padding:30px;
    border-radius:20px;
    width:90%;
    max-width:420px;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}


h2{
    margin-bottom:20px;
}


input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:10px;
    outline:none;
}


button{
    width:100%;
    margin-top:15px;
    padding:12px;
    border:none;
    border-radius:10px;
    background:var(--bege);
    color:var(--rosa2);
    font-weight:700;
    cursor:pointer;
    transition:0.3s;
}


button:hover{
    background:#ffe1d8;
}


small{
    display:block;
    margin-top:5px;
    opacity:0.9;
}
</style>
</head>


<body>


<div class="container">


<h2>Nova Senha</h2>


<form action="actions/processa_nova_senha.php" method="POST">


<input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">


<input type="password" name="senha" placeholder="Nova senha" required>


<input type="password" name="senha_confirmar" placeholder="Confirmar senha" required>


<small>Use uma senha forte e segura</small>


<button type="submit">Alterar senha</button>


</form>


</div>


</body>
</html>