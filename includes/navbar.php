<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

@import url('https://fonts.googleapis.com/css2?family=Yeseva+One&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root{
    --bege:#ffedcd;
    --bege2:#fff4ee;
    --bege3:#eacab6;

    --marrom:#7d5147;
    --marrom2:#833c2c;
    --marrom3:#421d14;

    --rosa:#ff877d;
    --rosa2:#ee5350;

    --verde:#347141;

    --branco:#ffffff;
    --preto:#1b1b1b;

    --glass:rgba(255,255,255,0.15);
    --borda:rgba(255,255,255,0.18);
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Poppins;
}

/* NAVBAR */

.navbar{
    position:fixed;
    top:0;
    left:0;
    right:0;

    z-index:9999;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:18px 40px;

    background:rgba(255,135,125,0.92);
    backdrop-filter:blur(14px);

    border-bottom:1px solid rgba(255,255,255,0.15);

    color:var(--branco);
}

/* LOGO */

.logo{
    display:flex;
    align-items:center;
    gap:12px;

    text-decoration:none;
    color:var(--branco);

    font-family:Yeseva One;
    font-size:28px;

    transition:0.3s;
}

.logo:hover{
    transform:scale(1.02);
}

.logo img{
    width:58px;
    height:58px;

    object-fit:cover;

    border-radius:50%;

    border:2px solid rgba(255,255,255,0.3);
}

/* MENU */

.menu ul{
    display:flex;
    align-items:center;
    gap:14px;

    list-style:none;
}

.menu a{
    color:var(--branco);
    text-decoration:none;

    font-size:15px;
    font-weight:500;

    padding:10px 18px;

    border-radius:30px;

    transition:0.3s;
}

.menu a:hover{
    background:rgba(255,255,255,0.18);
    color:var(--bege2);
}

/* ICONS */

.icons{
    display:flex;
    align-items:center;
    gap:18px;
}

/* CARRINHO */

.carrinho-icon{
    position:relative;
}

.carrinho-icon a{
    width:48px;
    height:48px;

    display:flex;
    align-items:center;
    justify-content:center;

    text-decoration:none;

    color:var(--branco);

    border-radius:50%;

    background:rgba(255,255,255,0.12);

    transition:0.3s;
}

.carrinho-icon a:hover{
    transform:translateY(-2px);
    background:rgba(255,255,255,0.22);
}

.carrinho-icon i{
    font-size:20px;
}

#numeroC{
    position:absolute;

    top:-5px;
    right:-5px;

    min-width:22px;
    height:22px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:3px 6px;

    border-radius:50px;

    background:var(--marrom3);

    color:var(--branco);

    font-size:11px;
    font-weight:700;
}

/* USER MENU */

.user-menu{
    position:relative;
}

.user-button{
    border:none;
    outline:none;

    display:flex;
    align-items:center;
    gap:10px;

    padding:10px 16px;

    border-radius:50px;

    cursor:pointer;

    background:rgba(255,255,255,0.12);

    color:var(--branco);

    font-family:Poppins;
    font-size:15px;
    font-weight:500;

    transition:0.3s;
}

.user-button:hover{
    background:rgba(255,255,255,0.22);
}

.user-button i{
    font-size:18px;
}

.dropdown-user{
    position:absolute;

    top:65px;
    right:0;

    width:240px;

    background:var(--branco);

    border-radius:20px;

    overflow:hidden;

    display:none;

    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}

.dropdown-user.active{
    display:flex;
    flex-direction:column;
}

.dropdown-user a{
    padding:16px 18px;

    color:var(--marrom3);
    text-decoration:none;

    font-size:15px;
    font-weight:500;

    transition:0.3s;
}

.dropdown-user a:hover{
    background:var(--bege2);
}

/* LOGIN ICON */

.login-icon{
    width:48px;
    height:48px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:50%;

    background:rgba(255,255,255,0.12);

    color:var(--branco);
    text-decoration:none;

    transition:0.3s;
}

.login-icon:hover{
    background:rgba(255,255,255,0.22);
    transform:translateY(-2px);
}

.login-icon i{
    font-size:20px;
}

/* MENU MOBILE */

.menu-icon{
    display:none;

    width:48px;
    height:48px;

    align-items:center;
    justify-content:center;

    border-radius:50%;

    background:rgba(255,255,255,0.12);

    cursor:pointer;

    transition:0.3s;
}

.menu-icon:hover{
    background:rgba(255,255,255,0.22);
}

.menu-icon i{
    font-size:22px;
}

/* MOBILE */

.mobile-user{
    display:none;
}

@media(max-width:900px){

    .navbar{
        padding:15px 18px;
    }

    .logo{
        font-size:22px;
    }

    .logo img{
        width:48px;
        height:48px;
    }

    .menu-icon{
        display:flex;
    }

    .menu{
        position:absolute;

        top:85px;
        right:18px;

        width:260px;

        padding:20px;

        border-radius:24px;

        background:rgba(255,135,125,0.97);

        backdrop-filter:blur(14px);

        border:1px solid rgba(255,255,255,0.15);

        display:none;
    }

    .menu.active{
        display:block;
    }

    .menu ul{
        flex-direction:column;
        align-items:stretch;
    }

    .menu a{
        display:block;
        width:100%;
    }

    .desktop-user{
        display:none;
    }

    .mobile-user{
        display:flex;
        flex-direction:column;

        margin-top:15px;
        padding-top:15px;

        border-top:1px solid rgba(255,255,255,0.2);
    }

    .mobile-user span{
        padding:10px 18px;

        font-size:15px;
        font-weight:600;

        color:var(--bege2);
    }

}

</style>
</head>

<body>

<?php

$totalItens = 0;

if(isset($_SESSION['carrinho'])){

    foreach($_SESSION['carrinho'] as $item){

        $totalItens += $item['quantidade'] ?? 1;

    }

}

?>

<header class="navbar">

<a href="index.php" class="logo">

<img src="imagens/LogoSegredo.png" alt="Logo">

<span>Segredo Doce</span>

</a>

<nav class="menu" id="menu">

<ul>

<li>
<a href="index.php">
Home
</a>
</li>

<li>
<a href="cardapio.php">
Cardápio
</a>
</li>

<li>
<a href="sobre.php">
Sobre
</a>
</li>

<li>
<a href="contato.php">
Contato
</a>
</li>

<div class="mobile-user">

<?php if(isset($_SESSION['nome'])): ?>

<?php

$nome = $_SESSION['nome'];
$partes = explode(" ", trim($nome));
$primeiro = $partes[0];

?>

<span>
Olá, <?= $primeiro; ?>
</span>

<li>
<a href="minha_conta.php">
Minha Conta
</a>
</li>

<li>
<a href="pedidos.php">
Meus Pedidos
</a>
</li>

<li>
<a href="logout.php">
Sair
</a>
</li>

<?php else: ?>

<li>
<a href="login.php">
Entrar / Criar Conta
</a>
</li>

<?php endif; ?>

</div>

</ul>

</nav>

<div class="icons">

<div class="carrinho-icon">

<a href="carrinho.php">

<i class="fa-solid fa-bag-shopping"></i>

</a>

<?php if($totalItens > 0): ?>

<span id="numeroC">

<?= $totalItens; ?>

</span>

<?php endif; ?>

</div>

<div class="desktop-user">

<?php if(isset($_SESSION['nome'])): ?>

<?php

$nome = $_SESSION['nome'];
$partes = explode(" ", trim($nome));
$primeiro = $partes[0];

?>

<div class="user-menu">

<button
class="user-button"
onclick="toggleDropdown()">

<i class="fa-solid fa-user"></i>

<span>
<?= $primeiro; ?>
</span>

<i class="fa-solid fa-chevron-down"></i>

</button>

<div class="dropdown-user" id="dropdownUser">

<a href="minha_conta.php">

<i class="fa-solid fa-user"></i>
Minha Conta

</a>

<a href="pedidos.php">

<i class="fa-solid fa-box"></i>
Meus Pedidos

</a>

<a href="logout.php">

<i class="fa-solid fa-right-from-bracket"></i>
Sair

</a>

</div>

</div>

<?php else: ?>

<a href="login.php" class="login-icon">

<i class="fa-solid fa-user"></i>

</a>

<?php endif; ?>

</div>

<div class="menu-icon" onclick="toggleMenu()">

<i class="fa-solid fa-bars"></i>

</div>

</div>

</header>

<script>

function toggleMenu(){

    document
    .getElementById('menu')
    .classList
    .toggle('active');

}

function toggleDropdown(){

    document
    .getElementById('dropdownUser')
    .classList
    .toggle('active');

}

window.addEventListener('click', function(e){

    const dropdown =
    document.getElementById('dropdownUser');

    const botao =
    document.querySelector('.user-button');

    if(
        dropdown &&
        botao &&
        !dropdown.contains(e.target) &&
        !botao.contains(e.target)
    ){

        dropdown.classList.remove('active');

    }

});

</script>

</body>
</html>
