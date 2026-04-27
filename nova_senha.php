<?php
    include 'includes/conexao.php';

    $token = $_GET['token'];

    $sql = "SELECT * FROM clientes WHERE token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['token' => $token]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario || strtotime($usuario['token_expira']) <time()) {
        die("Token inválido ou expirado");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>
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
    </style>
</head>
<body>
    <div class="container">
    <form action="actions/processa_nova_senha.php" method="POST">
        <h2>Nova Senha</h2>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="input-box"><input type="password" name="senha" placeholder="Nova senha" required></div>
        <button type="submit">Alterar senha</button>
    </form>
    </div>
</body>
</html>