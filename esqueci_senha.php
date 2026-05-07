<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha</title>
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

* {
    font-family: Poppins;
    margin: 0px;
    padding: 0px;
}
body {
    justify-items: center;
    background-color: var(--bege);
    text-align: center;
}
        .container {
            justify-items: center;
            margin-top: 130px;
            background-color: var(--rosa);
            width: 450px;
            height:280px;
            color: var(--branco);
            border-radius: 25px;
        }
        input {
            margin-top: 30px;
            width: 100%;
            padding: 10px;
            background: #eee;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 16px;
            color: #333;
            font-weight: 500;
            width: 380px;
            }   
        button {
            margin: 15px;
            width: 70%;
            height: 48px;
            background-color: var(--bege);
            border-radius: 10px;
            outline: none;
            cursor: pointer;
            border: none;
            color: var(--bege3);
            font-weight: 700;
            font-size: 15pt;
        }
        h2 {
            padding-top: 30px;
            background-color: var(--amarelo2);
            padding: 15px;
            width: 470px;
            font-size: 25pt;
            border-radius: 20px;
        }

        .alerta {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgb(0, 207, 17);
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
            font-weight: 700;
            position: absolute;
            top: 8px;
            right: 10px;
            cursor: pointer;
            }

        @media (max-width: 768px) {
                .container {
                    margin-top: 230px;
                    width: 320px;
                    height: 250px;
                    text-align: center;
                }

                h2 {
                    padding: 15px;
                    font-size: 18pt;
                    width: 290px;
                }

                .alerta {
                    right: 5px;
                    margin: 15px;
                    font-size: 10pt;
                }

                input {
                    width: 80%;
                }
            }

            @media (min-width: 1400px) {
                input {
                    font-size: 20pt;
                }

                h2 {
                    font-size: 30pt;
                }

                button {
                    font-size: 20pt;
                }
            }
    </style>
</head>
<body>
<?php if(isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if($_GET['erro'] == 'email') echo "E-mail não encontrado.";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>
    <div class="container">
    <form action="actions/processa_esqueci.php" method="POST">
        <h2>Esqueci Minha Senha</h2>
    <div class="input-box"><input type="email" name="email" placeholder="Digite seu email" required>
    <button type="submit">Enviar</button></div>
</form>
    </div>
</body>
</html>