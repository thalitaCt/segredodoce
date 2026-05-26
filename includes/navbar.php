<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Yeseva+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

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

    --glass: rgba(255,255,255,0.15);
    --borda: rgba(255,255,255,0.2);

    --sombra:
    0 8px 30px rgba(0,0,0,0.15);
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    padding-top:110px;
    overflow-x:hidden;
}

/* NAVBAR */

.navbar{
    position:fixed;
    top:15px;
    left:20px;
    right:20px;

    z-index:9990;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:18px 30px;

    border-radius:24px;

    background:rgba(255,135,125,0.92);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,0.18);

    box-shadow:var(--sombra);

    color:var(--branco);

    font-family:Poppins;
}

/* LOGO */

.logo{
    display:flex;
    align-items:center;
    gap:12px;

    font-family:'Yeseva One';
    font-size:28px;
    color:var(--branco);

    user-select:none;
}

.logo img{
    width:58px;
    height:58px;
    border-radius:50%;

    object-fit:cover;

    border:3px solid rgba(255,255,255,0.25);

    box-shadow:
    0 4px 10px rgba(0,0,0,0.12);
}

.logo{
    justify-self:flex-start;
}

.logo-link{
    display:flex;
    align-items:center;
    gap:14px;
    text-decoration:none;
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
    font-family:'Yeseva One', serif;
    font-size:30px;
    color:var(--branco);
    letter-spacing:0.5px;
}

.logo-subtitulo{
    margin-top:6px;
    font-family:'Poppins', sans-serif;
    font-size:11px;
    font-weight:500;
    letter-spacing:2px;
    text-transform:uppercase;
    color:rgba(255,255,255,0.85);
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

.menu ul li{
    transition:0.25s ease;
}

.menu a{
    color:var(--branco);
    text-decoration:none;

    padding:10px 16px;
    border-radius:14px;

    font-size:16px;
    font-weight:500;

    transition:0.25s ease;
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

.icons a{
    color:var(--branco);
    text-decoration:none;
}

/* CARRINHO */

.carrinho-icon{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
}

.carrinho-icon i{
    font-size:28px;
    transition:0.25s ease;
}

.carrinho-icon i:hover{
    transform:scale(1.12);
}

#numeroC{
    position:absolute;

    top:-10px;
    right:-12px;

    min-width:22px;
    height:22px;

    padding:2px 6px;

    border-radius:999px;

    background:var(--marrom3);

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:11px;
    font-weight:700;

    border:2px solid white;
}

/* USER MENU */

.user-menu{
    position:relative;
    display:flex;
    align-items:center;
}

.user-button{
    background:none;
    border:none;

    color:white;

    display:flex;
    align-items:center;
    gap:10px;

    cursor:pointer;

    padding:10px 14px;

    border-radius:14px;

    transition:0.25s ease;

    font-family:Poppins;
}

.user-button:hover{
    background:rgba(255,255,255,0.15);
}

.user-button i{
    font-size:22px;
}

#user-conta{
    font-size:15px;
    font-weight:500;
}

/* DROPDOWN */

.dropdown-user{
    position:absolute;

    top:65px;
    right:0;

    width:230px;

    background:white;

    border-radius:18px;

    overflow:hidden;

    display:none;
    flex-direction:column;

    box-shadow:
    0 10px 35px rgba(0,0,0,0.18);

    animation:dropdown 0.25s ease;
}

.dropdown-user.active{
    display:flex;
}

.dropdown-user a{
    color:var(--marrom3) !important;

    padding:16px 18px;

    text-decoration:none;

    font-size:15px;
    font-weight:500;

    transition:0.2s;
}

.dropdown-user a:hover{
    background:var(--bege2);
    padding-left:24px;
}

@keyframes dropdown{

    from{
        opacity:0;
        transform:translateY(-10px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* MENU ICON */

.menu-icon{
    display:none;
}



            @media (max-width: 768px) {

            html, body {
                overflow-x: hidden;
            }

            .navbar {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                padding: 10px;
                width: 100%;
                gap: 10px;
                min-height: 70px;
                box-sizing: border-box;
            }

            .navbar .icons a {
                padding-left: 0 !important;
            }


            .logo {
                order: 1;
            }


            .menu a {
                color:white;
                text-decoration:none;
            }

            .menu-icon {
                order: 3;
                display: block !important;
                font-size:30px;
                margin-left: 0px;
                flex-shrink: 0;
            }

                .menu {
                    justify-self: end;
                    text-align: center;
                    display:none;
                    flex-direction:column;
                    background:var(--rosa);
                    position:absolute;
                    top:90px;
                    right:15px;
                    width:200px;
                    padding:10px;
                    border-radius: 15px;
                    gap: 20px;
                }


                .menu ul {
                    text-align: center;
                    flex-direction: column;
                }


                .icons {
                    order: 2;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    justify-items: center;
                    align-items: center;
                    gap: 15px;
                    margin-left: auto;
                    margin-right: 0px;
                }


                .user-menu {
                    display: none;
                }

                .menu.active{
                    display:flex;
                    flex-direction: column;
                    position: absolute;
                    top: 48px;
                    right: 5px;
                }

                .carrinho-icon {
                    order: 2;
                    display: flex;
                    flex-direction: row;
                    font-size:25px;
                    padding-bottom: 10px;
                    justify-content: center;
                    justify-items: center;
                    align-items: center;
                    gap: 10px;
                    margin-left: auto;

                    #numeroC {
                        margin-right: 57px;
                        padding: 3px;
                        margin-top: 10px;
                        font-size: 6pt;
                    }
                }

                .mobile-user-mobile{
            display:flex;
            flex-direction:column;
            gap:10px;
        }


        .mobile-user-mobile li{
            list-style:none;
        }


        .mobile-user-mobile a{
            color:white;
            text-decoration:none;
            font-size:16px;
            padding:8px;
            display:block;
        }


        .user-header{
            font-weight:600;
            font-size:18px;
            padding:10px 8px;
            border-bottom:1px solid rgba(255,255,255,0.3);
            margin-bottom:5px;
        }
               
        }
    </style>
<body>
    <header class="navbar">
        <div class="logo">

    <a href="index.php" class="logo-link">

        <img src="imagens/LogoSegredo.png" alt="Segredo Doce">

        <div class="logo-texto">

            <span class="logo-titulo">
                Segredo Doce
            </span>

            <span class="logo-subtitulo">
                Confeitaria Artesanal
            </span>

        </div>

    </a>

</div>

<?php
  $totalItens = 0;

  if(isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $totalItens += $item['quantidade'] ?? 1;
    }
  }
?>

<div class="menu-icon" onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></div>

            <div class="menu" id="menu"><ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cardapio.php">Cardápio</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="contato.php">Contato</a></li>

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


    <li><a href="minha_conta.php">Minha Conta</a></li>
    <li><a href="pedidos.php">Meus Pedidos</a></li>
    <li><a href="logout.php">Sair</a></li>


<?php else: ?>


    <li><a href="login.php">Entrar / Criar Conta</a></li>


<?php endif; ?>


</div>

        </ul>
            </div>

        <div class="icons">

                <div class="carrinho-icon">
                    <a href="carrinho.php"> <i class="fa-solid fa-bag-shopping"></i> </a>
                    <?php if($totalItens > 0): ?>
                    <span id="numeroC"><?php echo $totalItens; ?></span>
                     <?php endif; ?>
                </div>

           <div class="user-menu">


<?php if(isset($_SESSION['nome'])): ?>


<?php
$nome = $_SESSION['nome'];
$partes = explode(" ", trim($nome));
$primeiro = $partes[0];
?>


<button class="user-button" onclick="toggleDropdown()">


    <i class="fa-solid fa-user"></i>


    <span id="user-conta">Olá, <?= $primeiro; ?></span>


    <i class="fa-solid fa-chevron-down seta"></i>


</button>


<div class="dropdown-user" id="dropdownUser">


    <a href="minha_conta.php">
        Minha Conta
    </a>


    <a href="pedidos.php">
        Meus Pedidos
    </a>


    <a href="logout.php">
        Sair
    </a>


</div>


<?php else: ?>


<a href="login.php">
    <i class="fa-solid fa-user"></i>
</a>


<?php endif; ?>


</div>
            </div>
        
    </header>

    <script>
        function toggleMenu() {
            document.getElementById("menu").classList.toggle("active");
        }
        </script>

    <script>
    function toggleDropdown(){
        document
        .getElementById("dropdownUser")
        .classList.toggle("active");
    }
    </script>

</body>
</html>
