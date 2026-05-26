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

    --shadow:0 10px 25px rgba(0,0,0,0.12);
}

/* RESET */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* NAVBAR */

.navbar{
    z-index:9990;
    position:fixed;
    top:0;
    left:0;
    right:0;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:18px 35px;

    background:rgba(255,135,125,0.92);
    backdrop-filter:blur(14px);

    border-bottom:1px solid rgba(255,255,255,0.15);

    font-family:Poppins;
    color:var(--branco);

    min-height:85px;
}

/* LOGO */

.logo{
    display:flex;
    align-items:center;
    gap:12px;

    text-decoration:none;

    color:var(--branco);

    transition:0.3s;
}

.logo:hover{
    transform:scale(1.02);
}

.logo img{
    width:58px;
    height:58px;

    border-radius:50%;
    object-fit:cover;

    box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

.logo-texto{
    display:flex;
    flex-direction:column;

    line-height:1;
}

.logo-titulo{
    font-family:"Yeseva One", serif !important;

    font-size:28px;
    font-weight:400;

    color:var(--branco);

    letter-spacing:0.5px;
}

.logo-subtitulo{
    font-family:"Poppins", sans-serif !important;

    font-size:11px;
    font-weight:500;

    color:rgba(255,255,255,0.85);

    letter-spacing:2px;

    text-transform:uppercase;

    margin-top:4px;
}

/* MENU */

.menu{
    display:flex;
    align-items:center;
}

.menu ul{
    list-style:none;

    display:flex;
    align-items:center;
    gap:15px;
}

.menu li{
    list-style:none;
}

.menu a{
    text-decoration:none;
    color:var(--branco);

    font-size:15px;
    font-weight:500;

    padding:10px 18px;
    border-radius:999px;

    transition:0.3s;
}

.menu a:hover{
    background:rgba(255,255,255,0.18);
    color:var(--branco);

    transform:translateY(-2px);
}

/* ICONS */

.icons{
    display:flex;
    align-items:center;
    gap:20px;
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

    border-radius:50%;

    background:rgba(255,255,255,0.14);

    color:var(--branco);
    text-decoration:none;

    font-size:21px;

    transition:0.3s;
}

.carrinho-icon a:hover{
    transform:translateY(-2px);
    background:rgba(255,255,255,0.22);
}

#numeroC{
    position:absolute;

    top:-6px;
    right:-6px;

    min-width:22px;
    height:22px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:3px 6px;

    background:var(--marrom3);

    color:white;

    border-radius:999px;

    font-size:11px;
    font-weight:700;

    border:2px solid var(--rosa);
}

/* USER */

.user-menu{
    position:relative;
}

.user-button{
    border:none;
    cursor:pointer;

    display:flex;
    align-items:center;
    gap:10px;

    padding:10px 16px;

    border-radius:999px;

    background:rgba(255,255,255,0.14);

    color:white;

    font-family:Poppins;
    font-size:14px;
    font-weight:500;

    transition:0.3s;
}

.user-button:hover{
    background:rgba(255,255,255,0.22);
}

.user-button .fa-user{
    font-size:18px;
}

.user-button .seta{
    font-size:11px;
}

/* DROPDOWN */

.dropdown-user{
    position:absolute;

    top:60px;
    right:0;

    width:230px;

    background:white;

    border-radius:18px;

    overflow:hidden;

    display:none;
    flex-direction:column;

    box-shadow:var(--shadow);
}

.dropdown-user.active{
    display:flex;
}

.dropdown-user a{
    text-decoration:none;

    padding:15px 18px;

    color:var(--marrom3);

    font-size:14px;
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

    background:rgba(255,255,255,0.14);

    color:white;
    text-decoration:none;

    font-size:19px;

    transition:0.3s;
}

.login-icon:hover{
    background:rgba(255,255,255,0.22);
}

/* MOBILE */

.menu-icon{
    display:none;

    font-size:28px;
    cursor:pointer;
}

/* MOBILE USER */

.mobile-user-mobile{
    display:none;
}

/* RESPONSIVO */

@media(max-width:768px){

    .login-icon {
       display: none;
}

    html,
    body{
        overflow-x:hidden;
    }

    .navbar{
        padding:12px 16px;
        min-height:75px;
    }

    .logo{
        font-size:22px;
    }

    .logo img{
        width:48px;
        height:48px;
    }

    .menu-icon{
        display:block;
        order:3;
    }

    .menu{
        display:none;

        position:absolute;

        top:82px;
        right:12px;

        width:240px;

        background:var(--rosa);

        border-radius:20px;

        padding:18px;

        box-shadow:var(--shadow);
    }

    .menu.active{
        display:flex;
    }

    .menu ul{
        width:100%;
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
    }

    .menu a{
        width:100%;
        display:block;
    }

    .icons{
        gap:12px;
        margin-left:auto;
    }

    .user-menu{
        display:none;
    }

    .mobile-user-mobile{
        display:flex;
        flex-direction:column;
        width:100%;
        gap:5px;

        margin-top:10px;
        padding-top:10px;

        border-top:1px solid rgba(255,255,255,0.2);
    }

    .mobile-user-mobile li{
        list-style:none;
        width:100%;
    }

    .mobile-user-mobile a{
        width:100%;
        display:block;
    }

    .user-header{
        font-size:16px;
        font-weight:600;

        padding:10px 12px;

        color:white;
    }

}

/* TELAS GRANDES */

@media(min-width:1400px){

    .navbar{
        padding:22px 50px;
    }

    .logo{
        font-size:34px;
    }

    .logo img{
        width:70px;
        height:70px;
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

    <img src="imagens/LogoSegredo.png" alt="Segredo Doce">

    <div class="logo-texto">

        <span class="logo-titulo">
            Segredo Doce
        </span>

        <span class="logo-subtitulo">
            CONFEITARIA ARTESANAL
        </span>

    </div>

</a>
<div class="menu-icon" onclick="toggleMenu()">

    <i class="fa-solid fa-bars"></i>

</div>

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

<div class="mobile-user-mobile">

<?php if(isset($_SESSION['nome'])): ?>

<?php
$nome = $_SESSION['nome'];
$partes = explode(" ", trim($nome));
$primeiro = $partes[0];
?>

<li class="user-header">

Olá, <?= $primeiro; ?>

</li>

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

<?php if(isset($_SESSION['nome'])): ?>

<?php
$nome = $_SESSION['nome'];
$partes = explode(" ", trim($nome));
$primeiro = $partes[0];
?>

<div class="user-menu">

<button class="user-button" onclick="toggleDropdown()">

<i class="fa-solid fa-user"></i>

<span>
Olá, <?= $primeiro; ?>
</span>

<i class="fa-solid fa-chevron-down seta"></i>

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

</header>

<script>

function toggleMenu(){

    document
    .getElementById("menu")
    .classList.toggle("active");

}

function toggleDropdown(){

    document
    .getElementById("dropdownUser")
    .classList.toggle("active");

}

window.addEventListener('click', function(e){

    const dropdown =
    document.getElementById("dropdownUser");

    const botao =
    document.querySelector(".user-button");

    if(
        dropdown &&
        !dropdown.contains(e.target) &&
        !botao.contains(e.target)
    ){
        dropdown.classList.remove("active");
    }

});

</script>

</body>
</html>