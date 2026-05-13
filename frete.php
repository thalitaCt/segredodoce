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

    /* VALIDAÇÕES */

    if(empty($cep)){
        header("Location: frete.php?erro=cep_vazio");
        exit;
    }

    if(strlen($cep) != 8){
        header("Location: frete.php?erro=cep_invalido");
        exit;
    }

    if(empty($regiao)){
        header("Location: frete.php?erro=regiao_vazia");
        exit;
    }

    $regioesValidas = [
        'Centro',
        'Zona Sul',
        'Zona Norte',
        'Zona Oeste',
        'Entrega Externa'
    ];

    if(!in_array($regiao, $regioesValidas)){
        header("Location: frete.php?erro=regiao_invalida");
        exit;
    }

    /* FRETE */

    if(
        strtolower($cidade) != 'rio de janeiro' ||
        strtoupper($estado) != 'RJ'
    ){

        $frete = 40;
        $msgFrete = "Entrega externa aplicada.";

    } else {

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

        $msgFrete = "Frete calculado com sucesso!";
    }

    $totalFinal = $total + $frete;

    $_SESSION['frete'] = $frete;

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

    $sucessoFrete = true;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Frete</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

.alerta{
    position:fixed;
    top:20px;
    right:20px;
    background:#e53935;
    color:white;
    padding:20px 30px;
    border-radius:10px;
    z-index:9999;
    font-weight:600;
}

.alerta-sucesso{
    position:fixed;
    top:20px;
    right:20px;
    background:#00a00d;
    color:white;
    padding:20px 30px;
    border-radius:10px;
    z-index:9999;
    font-weight:600;
}

.fechar{
    margin-left:15px;
    cursor:pointer;
    font-weight:bold;
}

small{
    color:#666;
}

@media(max-width:768px){

    .container{
        margin:15px;
        padding:20px;
    }

    .alerta,
    .alerta-sucesso{
        right:10px;
        left:10px;
        font-size:14px;
    }
}

</style>
</head>

<body>

<?php if(isset($_GET['erro'])): ?>

<div class="alerta">

<?php

if($_GET['erro'] == 'cep_vazio'){
    echo "Informe o CEP.";
}

elseif($_GET['erro'] == 'cep_invalido'){
    echo "CEP inválido.";
}

elseif($_GET['erro'] == 'regiao_vazia'){
    echo "Selecione a zona de entrega.";
}

elseif($_GET['erro'] == 'regiao_invalida'){
    echo "Zona inválida.";
}

else{
    echo "Ocorreu um erro.";
}

?>

<span class="fechar"
onclick="this.parentElement.style.display='none'">
X
</span>

</div>

<?php endif; ?>

<?php if(isset($sucessoFrete)): ?>

<div class="alerta-sucesso">

<?= $msgFrete ?>

<span class="fechar"
onclick="this.parentElement.style.display='none'">
X
</span>

</div>

<?php endif; ?>

<div class="container">

<h1>Entrega e Frete</h1>

<div class="info">

<strong>Informações de entrega:</strong><br><br>

• Entregas na cidade do Rio de Janeiro usam frete por zona.<br>

• Outros municípios e estados possuem frete fixo de R$40.

</div>

<form method="POST">

<strong>CEP</strong>

<input
type="text"
id="cep"
name="cep"
maxlength="9"
placeholder="00000-000"
value="<?= $cliente['cep'] ?? '' ?>"
required>

<strong>Endereço</strong>

<input
type="text"
name="endereco"
placeholder="Rua / Avenida"
value="<?= $cliente['endereco'] ?? '' ?>"
required>

<strong>Número</strong>

<input
type="text"
name="numero"
placeholder="Número"
value="<?= $cliente['numero'] ?? '' ?>"
required>

<strong>Bairro</strong>

<input
type="text"
name="bairro"
placeholder="Bairro"
value="<?= $cliente['bairro'] ?? '' ?>"
required>

<strong>Zona de entrega</strong>

<select name="regiao" id="regiao" required>

<option value="">Selecione sua zona</option>

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

<option value="Entrega Externa"
<?= ($cliente['regiao'] ?? '') == 'Entrega Externa' ? 'selected' : '' ?>>
Entrega Externa
</option>

</select>

<small>
A zona é utilizada apenas para entregas na cidade do Rio de Janeiro - RJ.
</small>

<strong>Cidade</strong>

<input
type="text"
name="cidade"
id="cidade"
placeholder="Rio de Janeiro"
value="<?= $cliente['cidade'] ?? '' ?>"
required>

<strong>Estado</strong>

<select name="estado" id="estado" required>

<option value="">Selecione o estado</option>

<?php

$estados = [
"AC"=>"Acre",
"AL"=>"Alagoas",
"AP"=>"Amapá",
"AM"=>"Amazonas",
"BA"=>"Bahia",
"CE"=>"Ceará",
"DF"=>"Distrito Federal",
"ES"=>"Espírito Santo",
"GO"=>"Goiás",
"MA"=>"Maranhão",
"MT"=>"Mato Grosso",
"MS"=>"Mato Grosso do Sul",
"MG"=>"Minas Gerais",
"PA"=>"Pará",
"PB"=>"Paraíba",
"PR"=>"Paraná",
"PE"=>"Pernambuco",
"PI"=>"Piauí",
"RJ"=>"Rio de Janeiro",
"RN"=>"Rio Grande do Norte",
"RS"=>"Rio Grande do Sul",
"RO"=>"Rondônia",
"RR"=>"Roraima",
"SC"=>"Santa Catarina",
"SP"=>"São Paulo",
"SE"=>"Sergipe",
"TO"=>"Tocantins"
];

foreach($estados as $sigla => $nome){

    $selected = ($cliente['estado'] ?? '') == $sigla
    ? 'selected'
    : '';

    echo "<option value='$sigla' $selected>
    $nome ($sigla)
    </option>";
}

?>

</select>

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

const cidade = document.getElementById('cidade');
const estado = document.getElementById('estado');
const regiao = document.getElementById('regiao');

function verificarEntrega(){

    let cidadeValor = cidade.value.toLowerCase().trim();
    let estadoValor = estado.value.toUpperCase().trim();

    if(
        cidadeValor === 'rio de janeiro' &&
        estadoValor === 'RJ'
    ){

        regiao.disabled = false;

    } else {

        regiao.value = 'Entrega Externa';
    }
}

cidade.addEventListener('input', verificarEntrega);
estado.addEventListener('change', verificarEntrega);

verificarEntrega();

</script>

</body>
</html>
