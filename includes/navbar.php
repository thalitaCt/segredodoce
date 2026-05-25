<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

@import url('https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root{

    --rosa1:#ffb3aa;
    --rosa2:#ff877d;
    --rosa3:#ee5350;

    --bege:#fff4ee;
    --bege2:#ffedcd;

    --marrom:#7d5147;
    --marrom2:#421d14;

    --branco:#ffffff;
    --preto:#1e1e1e;

}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins;
}

body{
    padding-top:95px;
}

/* NAVBAR */

.navbar{

    position:fixed;

    top:0;
    left:0;
    right:0;

    z-index:9999;

    height:90px;

    padding:0 35px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    background:linear-gradient(
    135deg,
    var(--rosa1),
    var(--rosa2),
    var(--rosa3)
    );

    box-shadow:
    0 5px 20px rgba(0,0,0,0.12),
    0 1px 0 rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

}

/* LOGO */

.logo{

    display:flex;
    align-items:center;
    gap:12px;

    text-decoration:none;
    color:var(--branco);

}

.logo img{

    width:58px;
    height:58px;

    border-radius:50%;

    object-fit:cover;

    border:3px solid rgba(255,255,255,0.3);

}

.logo-text{

    display:flex;
    flex-direction:column;

    line-height:1;

}

.logo-text h1{

    font-family:'Berkshire Swash';

    font-size:34px;
    font-weight:400;

}

.logo-text span{

    font-size:11px;

    letter-spacing:2px;

    opacity:0.9;

}

/* MENU */

.menu{

    display:flex;
    align-items:center;

}

.menu ul{

    display:flex;
    align-items:center;

    gap:18px;

    list-style:none;

}

.menu li{

    transition:0.3s;

    border-radius:14px;

}

.menu li:hover{

    transform:translateY(-2px);

    background:rgba(255,255,255,0.15);

    backdrop-filter:blur(5px);

}

.menu a{

    display:block;

    padding:12px 16px;

    color:var(--branco);

    text-decoration:none;

    font-size:15px;
    font-weight:500;

}

/* ICONS */

.icons{

    display:flex;
    align-items:center;

    gap:22px;

}

/* CARRINHO */

.carrinho-icon{

    position:relative;

}

.carrinho-icon a{

    color:white;

    text-decoration:none;

}

.carrinho-icon i{

    font-size:24px;

    transition:0.3s;

}

.carrinho-icon i:hover{

    transform:scale(1.12);

    color:var(--bege2);

}

#numeroC{

    position:absolute;

    top:-10px;
    right:-12px;

    min-width:22px;
    height:22px;

    border-radius:50%;

    background:var(--marrom2);

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:11px;
    font-weight:700;

    padding:2px;

}

/* USER */

.user-menu{

    position:relative;

}

.user-button{

    background:none;
    border:none;

    color:white;

    display:flex;
    align-items:center;

    gap:10px;

    cursor:pointer;

    font-size:15px;
    font-weight:500;

}

.user-button i{

    transition:0.3s;

}

.user-button:hover i{

    color:var(--bege2);

}

.user-avatar{

    width:42px;
    height:42px;

    border-radius:50%;

    background:rgba(255,255,255,0.15);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:18px;

}

/* DROPDOWN */

.dropdown-user{

    position:absolute;

    top:60px;
    right:0;

    width:220px;

    background:white;

    border-radius:18px;

    overflow:hidden;

    display:none;
    flex-direction:column;

    box-shadow:0 10px 25px rgba(0,0,0,0.15);

}

.dropdown-user.active{

    display:flex;

}

.dropdown-user a{

    padding:16px 18px;

    text-decoration:none;

    color:var(--marrom2);

    font-size:15px;
    font-weight:500;

    transition:0.3s;

}

.dropdown-user a:hover{

    background:var(--bege);

}

/* MENU MOBILE */

.menu-icon{

    display:none;

    color:white;

    font-size:28px;

    cursor:pointer;

}

.mobile-user-mobile{

    display:none;

}

/* RESPONSIVO */

@media(max-width:768px){

    .navbar{

        height:85px;

        padding:0 18px;

    }

    .logo img{

        width:50px;
        height:50px;

    }

    .logo-text h1{

        font-size:28px;

    }

    .menu-icon{

        display:block;

    }

    .menu{

        position:absolute;

        top:90px;
        right:15px;

        width:240px;

        padding:20px;

        border-radius:20px;

        background:linear-gradient(
        135deg,
        var(--rosa2),
        var(--rosa3)
        );

        display:none;

        box-shadow:0 10px 25px rgba(0,0,0,0.15);

    }

    .menu.active{

        display:flex;

        animation:menuFade 0.3s ease;

    }

    .menu ul{

        width:100%;

        flex-direction:column;

        align-items:flex-start;

        gap:8px;

    }

    .menu li{

        width:100%;

    }

    .menu a{

        width:100%;

    }

    .user-menu{

        display:none;

    }

    .mobile-user-mobile{

        display:flex;

        flex-direction:column;

        width:100%;

        margin-top:10px;
        padding-top:15px;

        border-top:1px solid rgba(255,255,255,0.15);

    }

    .mobile-user-mobile li{

        list-style:none;

    }

    .mobile-user-mobile a{

        display:block;

        width:100%;

        color:white;

        text-decoration:none;

        padding:10px;

    }

    .user-header{

        color:var(--bege2);

        font-size:16px;
        font-weight:600;

        padding:10px;

    }

}

/* ANIMAÇÃO */

@keyframes menuFade{

    from{

        opacity:0;
        transform:translateY(-10px);

    }

    to{

        opacity:1;
        transform:translateY(0);

    }

}

</style>

</head>

<body>

<header class="navbar">

<!-- LOGO -->

<a href="index.php" class="logo">

<img src="imagens/LogoSegredo.png">

<div class="logo-text">

<h1>Segredo Doce</h1>

<span>DOCERIA ARTESANAL</span>

</div>

</a>

<!-- MENU MOBILE -->

<div class="menu-icon" onclick="toggleMenu()">

<i class="fa-solid fa-bars"></i>

</div>

<!-- MENU -->

<nav class="menu" id="menu">

<ul>

<li>
<a href="index.php">Home</a>
</li>

<li>
<a href="cardapio.php">Cardápio</a>
</li>

<li>
<a href="sobre.php">Sobre</a>
</li>

<li>
<a href="contato.php">Contato</a>
</li>

<div class="mobile-user-mobile">

<li class="user-header">
Olá, Cliente
</li>

<li>
<a href="#">Minha Conta</a>
</li>

<li>
<a href="#">Pedidos</a>
</li>

<li>
<a href="#">Sair</a>
</li>

</div>

</ul>

</nav>

<!-- ICONS -->

<div class="icons">

<!-- CARRINHO -->

<div class="carrinho-icon">

<a href="#">

<i class="fa-solid fa-bag-shopping"></i>

</a>

<span id="numeroC">2</span>

</div>

<!-- USER -->

<div class="user-menu">

<button
class="user-button"
onclick="toggleDropdown()">

<div class="user-avatar">

<i class="fa-solid fa-user"></i>

</div>

<span>
Olá, Cliente
</span>

<i class="fa-solid fa-chevron-down"></i>

</button>

<div
class="dropdown-user"
id="dropdownUser">

<a href="#">
Minha Conta
</a>

<a href="#">
Pedidos
</a>

<a href="#">
Sair
</a>

</div>

</div>

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

window.addEventListener("click", function(e){

    const dropdown =
    document.getElementById("dropdownUser");

    const button =
    document.querySelector(".user-button");

    if(dropdown && button){

        if(
            !dropdown.contains(e.target)
            &&
            !button.contains(e.target)
        ){

            dropdown.classList.remove("active");

        }

    }

});

</script>

</body>
</html>
