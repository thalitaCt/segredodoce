<?php
session_start();
include 'includes/conexao.php';


if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}


if(empty($_SESSION['carrinho'])){
    header("Location: carrinho.php");
    exit;
}


$idUsuario = $_SESSION['id'];


/* CLIENTE */
$sql = $pdo->prepare("
SELECT *
FROM clientes
WHERE usuario_id = ?
");


$sql->execute([$idUsuario]);


$cliente = $sql->fetch(PDO::FETCH_ASSOC);


/* TOTAL CARRINHO */
$total = 0;


foreach($_SESSION['carrinho'] as $produto){


    $qtd = $produto['quantidade'];
    $total += $produto['preco'] * $qtd;
}


$frete = null;
$totalFinal = null;


/* CALCULAR FRETE */
if($_SERVER['REQUEST_METHOD'] == 'POST'){


    $cep = trim($_POST['cep']);
    $endereco = trim($_POST['endereco']);
    $numero = trim($_POST['numero']);
    $bairro = trim($_POST['bairro']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $regiao = trim($_POST['regiao']);


    /* VALIDAÇÃO CIDADE/ESTADO */


    if(
        strtolower($cidade) != 'rio de janeiro' ||
        strtoupper($estado) != 'RJ'
    ){


        $frete = 40;


    }
    else{


        switch($regiao){


            case 'Centro':
                $frete = 5;
            break;


            case 'Zona Sul':
                $frete = 10;
            break;


            case 'Zona Norte':
                $frete = 15;
            break;


            case 'Zona Oeste':
                $frete = 20;
            break;


            default:
                $frete = 25;
        }
    }


    $totalFinal = $total + $frete;


    /* SALVAR FRETE */
    $_SESSION['frete'] = $frete;


    /* SALVAR ENDEREÇO */
    $_SESSION['endereco_pedido'] = [


        'cep' => $cep,
        'endereco' => $endereco,
        'numero' => $numero,
        'bairro' => $bairro,
        'cidade' => $cidade,
        'estado' => $estado,
        'regiao' => $regiao
    ];


    /* ATUALIZAR CLIENTE */


    $update = $pdo->prepare("
    UPDATE clientes
    SET
    cep = ?,
    endereco = ?,
    numero = ?,
    bairro = ?,
    cidade = ?,
    estado = ?,
    regiao = ?
    WHERE usuario_id = ?
    ");


    $update->execute([
        $cep,
        $endereco,
        $numero,
        $bairro,
        $cidade,
        $estado,
        $regiao,
        $idUsuario
    ]);
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Frete</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root{
    --rosa:#ff877d;
    --rosa2:#ee5350;
    --bege2:#fff4ee;
    --marrom3:#421d14;
    --branco:#fff;
}


body{
    margin:0;
    background:var(--bege2);
    font-family:Poppins;
}


.container{
    max-width:700px;
    margin:40px auto;
    background:var(--branco);
    padding:30px;
    border-radius:18px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}


h1{
    text-align:center;
    color:var(--marrom3);
    margin-bottom:25px;
}


form{
    display:flex;
    flex-direction:column;
    gap:15px;
}


input,
select{
    padding:14px;
    border-radius:10px;
    border:1px solid #ddd;
    outline:none;
    font-size:15px;
    font-family:Poppins;
}


input:focus,
select:focus{
    border-color:var(--rosa);
}


button{
    background:var(--rosa);
    color:white;
    border:none;
    padding:14px;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
    font-family:Poppins;
}


button:hover{
    background:var(--rosa2);
}


.resumo{
    margin-top:25px;
    background:var(--bege2);
    padding:20px;
    border-radius:12px;
}


.resumo p{
    font-size:18px;
    margin:12px 0;
}


.finalizar{
    margin-top:20px;
}


.finalizar a{
    text-decoration:none;
}


.info{
    background:#fff4ee;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    font-size:14px;
    line-height:1.6;
}


@media(max-width:768px){


    .container{
        margin:15px;
        padding:20px;
    }


    h1{
        font-size:28px;
    }


    input,
    select,
    button{
        font-size:14px;
    }


}


</style>
</head>
<body>


<div class="container">


    <h1>Entrega e Frete</h1>


    <div class="info">


        <strong>Informações de entrega:</strong><br>


        • Entregas no Rio de Janeiro possuem frete por região.<br>


        • Outros municípios e estados possuem frete fixo.


    </div>


    <form method="POST">


        <input
        type="text"
        name="cep"
        placeholder="CEP"
        value="<?= $cliente['cep'] ?? '' ?>"
        required>


        <input
        type="text"
        name="endereco"
        placeholder="Rua / Avenida"
        value="<?= $cliente['endereco'] ?? '' ?>"
        required>


        <input
        type="text"
        name="numero"
        placeholder="Número"
        value="<?= $cliente['numero'] ?? '' ?>"
        required>


        <input
        type="text"
        name="bairro"
        placeholder="Bairro"
        value="<?= $cliente['bairro'] ?? '' ?>"
        required>


        <select name="regiao" required>


            <option value="">Selecione sua região</option>


            <option value="Centro"
            <?= ($cliente['regiao'] ?? '') == 'Centro' ? 'selected' : '' ?>>
            Centro
            </option>


            <option value="Zona Sul"
            <?= ($cliente['regiao'] ?? '') == 'Zona Sul' ? 'selected' : '' ?>>
            Zona Sul
            </option>


            <option value="Zona Norte"
            <?= ($cliente['regiao'] ?? '') == 'Zona Norte' ? 'selected' : '' ?>>
            Zona Norte
            </option>


            <option value="Zona Oeste"
            <?= ($cliente['regiao'] ?? '') == 'Zona Oeste' ? 'selected' : '' ?>>
            Zona Oeste
            </option>


            <option value="Outro Município"
            <?= ($cliente['regiao'] ?? '') == 'Outro Município' ? 'selected' : '' ?>>
            Outro Município
            </option>


        </select>


        <input
        type="text"
        name="cidade"
        placeholder="Cidade"
        value="<?= $cliente['cidade'] ?? '' ?>"
        required>


        <input
        type="text"
        name="estado"
        placeholder="Estado"
        value="<?= $cliente['estado'] ?? '' ?>"
        required>


        <button type="submit">
            Calcular Frete
        </button>


    </form>


    <?php if($frete !== null): ?>


    <div class="resumo">


        <p>
            <strong>Subtotal:</strong>
            R$ <?= number_format($total, 2, ',', '.') ?>
        </p>


        <p>
            <strong>Frete:</strong>
            R$ <?= number_format($frete, 2, ',', '.') ?>
        </p>


        <p>
            <strong>Total:</strong>
            R$ <?= number_format($totalFinal, 2, ',', '.') ?>
        </p>


        <div class="finalizar">


            <a href="checkout.php">
                <button>
                    Continuar para Checkout
                </button>
            </a>


        </div>


    </div>


    <?php endif; ?>


</div>


</body>
</html>
