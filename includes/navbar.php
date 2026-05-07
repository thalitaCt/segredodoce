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
            --amarelo: #fde047;
            --amarelo2: #facc15;
        }

        .logo {
            font-family: Yeseva One;
            display: flex;
            align-items: center;
            gap: 10px;

            img {
                width: 50px;
                height: 50px;
                border-radius: 350px;
            }
        }

        .navbar {
            z-index: 900;
            background-color: var(--rosa);
            top: 0px;
            left: 0px;
            right: 0px;
            padding: 20px;
            height: 60px;
            position: fixed;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 17pt;
            color: var(--bege2);
            font-family: Poppins;

            .carrinho-icon {
                    position: relative;
                    display: inline-block;
                    margin-top: 13px;

                    #numeroC {
                    position:absolute;
                    top: -18px;
                    right: -19px;
                    background-color: red;
                    color: var(--branco);
                    font-weight: 500;
                    font-size: 12pt;
                    border-radius: 8px;
                    padding: 2px;
                    }
}
        }

        .logo {
                justify-self: flex-start;
            }


            .navbar .menu ul {
                list-style: none;
                display: flex;
                justify-content: center;
                gap: 30px;
                transition: 0.5s;
            }


            .navbar .menu a {
                color: var(--branco);
                text-decoration: none;
                transition: 0.5s;
            }


            .navbar .menu ul li {
                transition: 0.5s
            }


            .menu {
                display: flex;
                align-items: center;
                justify-self: center;
                gap: 10px;
            }


            .navbar .menu li:hover {
                transform: scale(1.1);
                background-color: var(--bege);
                border-radius: 20px;
                padding: 3px;
                font-weight: 700;
            }


            .navbar .menu a:hover {
                color: var(--marrom3);
            }


            .navbar .icons a {
                color: var(--bege2);
                text-decoration: none;
                padding-left: 25px;
                transition: 0.5s;
            }


            .navbar .icons a:hover {
                color: var(--marrom2);
            }


            .icons i {
                transition: 0.5s;
            }


            .icons i:hover {
                transform: scale(1.3);
            }


            .icons {
                justify-self: end;
                display: flex;
                gap: 20px;
                font-size: 21pt;
            }


            .user-icon {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;


                i {
                    margin-top: 18px;
                }


                span {
                    font-size: 9pt;
                    margin-left: 17px;
                }
            }


            .menu-icon {
                display: none;
            }


            .mobile-extra {
                display: none;
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


            .mobile-extra {
                display: block;
                cursor: pointer;
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


                .user-icon {
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


               
            }

    @media (min-width: 1400px) {
        .logo {
            font-size: 18pt;

            img {
                width: 100px;
                height: 100px;
            }
        }

        .navbar {
            .carrinho-icon {
                font-size: 20px;

                #numeroC {
                    font-size: 16pt;
                }
            }
        }

        .menu ul li {
            font-size: 22pt;
        }

        .icons i {
            font-size: 20px;
        }
    }
    </style>
<body>
    <header class="navbar">
        <div class="logo"><img src="imagens/LogoSegredo.png">Segredo Doce</div>

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
            <li><a href="pedidos.php">Pedidos</a></li>
            <li><a href="contato.php">Contato</a></li>

            <div class="mobile-extra">
                    <?php if(isset($_SESSION['nome'])): ?>
                        <li><a href="logout.php" title="Sair">Sair</a></li>

                            <?php
                            $nome = $_SESSION['nome'];
                            $partes = explode(" ", trim($nome));
                            $primeiro = $partes[0];

                            if(isset($partes[1]) && !empty($partes[1])) {
                                $nomeFormatado= $primeiro . " " . $partes[1];
                            } else {
                                $nomeFormatado = $primeiro;
                            }
                            ?>

                        <span class="nome-user"><?= $nomeFormatado?></span>
                        <?php else: ?>

                            <li><a href="login.php">Minha Conta</a></li>

                        <?php endif; ?>
                </div>
        </ul>
            </div>

        <div class="icons">

                <div class="carrinho-icon">
                    <a href="carrinho.php"> <i class="fa-solid fa-bag-shopping"></i> </a>
                    <span id="numeroC"><?php echo $totalItens; ?></span> 
                </div>

                <div class="user-icon">
                    <?php if(isset($_SESSION['nome'])): ?>
                        <a href="logout.php" title="Sair"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>

                            <?php
                            $nome = $_SESSION['nome'];
                            $partes = explode(" ", trim($nome));
                            $primeiro = $partes[0];
                            $segundo = $partes[1] ?? "";
                            $nomeFormatado = $primeiro . "  " . $segundo;
                            ?>

                        <span class="nome-user"><?= $nomeFormatado?></span>
                        <?php else: ?>

                            <a href="login.php"><i class="fa-solid fa-user"></i></a>

                        <?php endif; ?>
                </div>
                </div>
        
    </header>

    <script>
        function toggleMenu() {
            document.getElementById("menu").classList.toggle("active");
        }
        </script>
</body>
</html>