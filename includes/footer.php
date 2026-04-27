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

        footer {
            bottom: 0px;
            padding: 10px;
            font-family: Poppins;
            margin-top: 40px;
            left: 0px;
            right: 0px;
            background-color: var(--marrom2);
            color: var(--bege2);
        }

        .partes {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            align-items: center;
            justify-items: center;
            gap: 10px;
        }

        .parte1 {
            text-align: left;

            h1 {
                font-family: Poppins;
                font-size: 25pt;
                padding-left: 0px;
                color: var(--bege2);
            }
        }

        .parte2 {
            text-align: left;
            font-size: 11pt;

            i {
                padding: 3px;
            }

            h1 {
                font-family: Poppins;
                font-size: 25pt;
                padding-left: 0px;
                color: var(--bege2);
            }
        }

        .parte3 {
            text-align: left;

            a {
                text-decoration: none;
                color: var(--bege2);
            }

            i {
                font-size: 45px;
                margin-right: 5px;
            }

            h1 {
                font-family: Poppins;
                font-size: 25pt;
                padding-left: 0px;
                color: var(--bege2);
            }
        }

        .copy {
             h2 {
            text-align: center;
            font-size: 10pt;
            font-weight: 400;
            }
        }

         @media (max-width: 768px) {
            .partes {
                display: block;
                bottom: 0px;
            }

            .parte1 {
                padding-bottom: 10px;
                h1 {
                    font-size: 22pt;
                }
                p {
                    font-size: 10pt;
                }
            }

            .parte2 {
                padding-bottom: 10px;

                h1 {
                    font-size: 22pt;
                }
                p {
                    font-size: 10pt;
                }
            }

            .parte3 {
                padding-bottom: 18px;

                h1 {
                    font-size: 22pt;
                }
                i {
                    padding-right: 7px;
                }
            }

            .copy {
                font-size: 9pt;
            }
        }

    </style>
<body>
    <footer>

    <div class="partes">
        <div class="parte1">
            <h1>Segredo Doce</h1>
            <p>Sabores feitos para transformar momentos<br> simples 
                em lembranças especiais
            </p>
        </div>

        <div class="parte2">
            <h1>Contato</h1>
            <i class="fa-solid fa-phone"></i> (21) 99999-9999<br>
            <i class="fa-solid fa-envelope"></i> confeitariasegredoce@gmail.com<br>
            <i class="fa-solid fa-location-dot"></i> Endereço: R.Sen.Vergueiro, 
            93 - Loja 14 -<br> Flamengo, Rio de Janeiro - RJ, 22230-000<br>
        </div>

        <div class="parte3">
            <h1>Redes Sociais</h1>
            <a href="https://www.facebook.com/share/18R5ChkSKD/"><i class="fa-brands fa-square-facebook"></i></a>
            <a href="https://www.instagram.com/confsegredoce_?igsh=NnowdzdpOTUyd3p5"><i class="fa-brands fa-square-instagram"></i></a>
            <a href="https://x.com/confsegredoce"><i class="fa-brands fa-square-x-twitter"></i></a>
        </div>

        <div class="copy">
        <h2>@ 2026 Segredo Doce - Todos os direitos reservados</h2>
        </div>
    </div>
    </footer>
</body>
</html>