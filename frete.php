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


    $cep = trim(preg_replace('/\D/', '', $_POST['cep']));
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

// CEP vazio
if (empty($cep)) {
    header("Location: frete.php?erro=cep_vazio");
    exit;
}


// CEP inválido
if (strlen(preg_replace('/\D/', '', $cep)) != 9) {
    header("Location: frete.php?erro=cep_invalido");
    exit;
}


// Região não selecionada
if (empty($regiao)) {
    header("Location: frete.php?erro=regiao_vazia");
    exit;
}


// Estado fora do RJ (taxa extra)
if (!empty($estado) && strtoupper($estado) != "RJ") {
    header("Location: frete.php?msg=frete_extra_estado");
    exit;
}


// Cidade fora do Rio (taxa extra)
if (!empty($cidade) && strtolower($cidade) != "rio de janeiro") {
    header("Location: frete.php?msg=frete_extra_cidade");
    exit;
}


// SUCESSO
header("Location: frete.php?msg=frete_calculado");
exit;


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

.alerta-sucesso {
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: rgb(0, 160, 13);
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

.alerta-sucesso .fechar {
  color: var(--branco);
  font-size: 15px;
  padding: 3px;
  border-radius: 8px;
  font-weight: 700;
  position: absolute;
  top: 8px;
  right: 10px;
  cursor: pointer;
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

    .alerta {
    right: 5px;
    margin: 15px;
    font-size: 10pt;
  }

  .alerta-sucesso {
    right: 5px;
    margin: 15px;
    font-size: 10pt;
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


        <strong>CEP</strong><input
        type="text"
        id="cep" 
        name="cep"
        maxlength="9"
        placeholder="00000-000"
        value="<?= $cliente['cep'] ?? '' ?>"
        required>


        <strong>Endereço</strong><input
        type="text"
        name="endereco"
        placeholder="Rua / Avenida"
        value="<?= $cliente['endereco'] ?? '' ?>"
        required>


        <strong>Número</strong><input
        type="text"
        name="numero"
        placeholder="Número"
        value="<?= $cliente['numero'] ?? '' ?>"
        required>


        <strong>Bairro</strong><input
        type="text"
        name="bairro"
        placeholder="Bairro"
        value="<?= $cliente['bairro'] ?? '' ?>"
        required>


        <strong>Região</strong><select name="regiao" required>


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


        <strong>Cidade</strong><input
        type="text"
        name="cidade"
        placeholder="Rio de Janeiro"
        value="<?= $cliente['cidade'] ?? '' ?>"
        required>


        <strong>Estado</strong><input
        type="text"
        name="estado"
        placeholder="RJ"
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

<script>
document.getElementById('cep').addEventListener('input', function(e){


    let v = e.target.value.replace(/\D/g,'');


    if(v.length > 8){
        v = v.slice(0,8);
    }


    v = v.replace(/(\d{5})(\d)/,'$1-$2');


    e.target.value = v;
});
</script>

</body>
</html>
