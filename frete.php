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
        'Zona Sudoeste',
        'Entrega Externa'
    ];


    if(!in_array($regiao, $regioesValidas)){
        header("Location: frete.php?erro=regiao_invalida");
        exit;
    }


    /* FRETE */


    $cidadeNormalizada = mb_strtolower(trim($cidade));


    if(
        $cidadeNormalizada != 'rio de janeiro' ||
        strtoupper($estado) != 'RJ'
    ){


        $frete = 40;
        $msgFrete = "Entrega externa aplicada.";


        $regiao = 'Entrega Externa';


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

            case 'Zona Sudoeste':
                $frete = 25;
            break;


            default:
                $frete = 30;
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
    $msgFrete = "Frete calculado com sucesso!";
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
    --verde:#00a00d;
    --vermelho:#e53935;
}


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins;
}


body{
    background:var(--bege2);
    padding:30px 15px;
}


.container{
    max-width:1200px;
    margin:auto;
    background:var(--branco);
    padding:35px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}


h1{
    text-align:center;
    color:var(--marrom3);
    margin-bottom:25px;
    font-size:32px;
}


.info{
    background:#fff4ee;
    padding:18px;
    border-radius:12px;
    margin-bottom:25px;
    color:var(--marrom3);
    line-height:1.8;
}


.form-grid{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap:22px;
}


.input-group{
    display:flex;
    flex-direction:column;
    gap:8px;
}


.input-group.full{
    grid-column:1 / -1;
}


label{
    font-weight:600;
    color:var(--marrom3);
    font-size: 16pt;
}


input,
select{
    padding:16px;
    border-radius:12px;
    border:1px solid #ddd;
    outline:none;
    font-size:15pt;
    transition:0.3s;
    background:white;
}


input:focus,
select:focus{
    border-color:var(--rosa);
    box-shadow:0 0 0 3px rgba(255,135,125,0.15);
}


small{
    color:#666;
    font-size:13px;
}


.btn{
    margin-top:25px;
    width:100%;
    border:none;
    background:var(--rosa);
    color:white;
    padding:16px;
    border-radius:14px;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:0.3s;
}


.btn:hover{
    background:var(--rosa2);
}


.resumo{
    margin-top:30px;
    background:#fff7f3;
    border-radius:18px;
    padding:25px;
}


.resumo h2{
    color:var(--marrom3);
    margin-bottom:20px;
}


.resumo-item{
    display:flex;
    justify-content:space-between;
    margin-bottom:14px;
    font-size:17px;
    color:var(--marrom3);
}


.total{
    border-top:1px solid #ddd;
    padding-top:15px;
    margin-top:15px;
    font-size:22px;
    font-weight:700;
}


.finalizar{
    margin-top:20px;
}


.finalizar a{
    text-decoration:none;
}


.finalizar button{
    width:100%;
    border:none;
    background:var(--verde);
    color:white;
    padding:15px;
    border-radius:14px;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:0.3s;
}


.finalizar button:hover{
    transform:scale(1.02);
}


.alerta,
.alerta-sucesso{
    position:fixed;
    top:20px;
    right:20px;
    padding:18px 24px;
    border-radius:12px;
    color:white;
    z-index:9999;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
}


.alerta{
    background:var(--vermelho);
}


.alerta-sucesso{
    background:var(--verde);
}


.fechar{
    cursor:pointer;
    font-weight:bold;
}


@media(max-width:768px){


    .container{
        padding:20px;
    }


    .form-grid{
        grid-template-columns:1fr;
    }


    h1{
        font-size:26px;
    }


    .alerta,
    .alerta-sucesso{
        left:10px;
        right:10px;
        font-size:14px;
    }
}


</style>
</head>


<body>


<?php if(isset($_GET['erro'])): ?>


<div class="alerta">


<i class="fa-solid fa-circle-exclamation"></i>


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


<i class="fa-solid fa-circle-check"></i>


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


• Entregas na cidade do Rio de Janeiro possuem frete por zona.<br>


• Outros municípios e estados possuem frete fixo de R$40.<br>


• Caso sua entrega seja fora da cidade do Rio, selecione "Entrega Externa".


</div>


<form method="POST">


<div class="form-grid">


<div class="input-group">
<label>CEP</label>


<input
type="text"
id="cep"
name="cep"
maxlength="9"
placeholder="00000-000"
value="<?= $cliente['cep'] ?? '' ?>"
required>
</div>


<div class="input-group">
<label>Número</label>


<input
type="text"
name="numero"
placeholder="Número"
value="<?= $cliente['numero'] ?? '' ?>"
required>
</div>


<div class="input-group full">
<label>Endereço</label>


<input
type="text"
name="endereco"
placeholder="Rua / Avenida"
value="<?= $cliente['endereco'] ?? '' ?>"
required>
</div>


<div class="input-group">
<label>Bairro</label>


<input
type="text"
name="bairro"
placeholder="Bairro"
value="<?= $cliente['bairro'] ?? '' ?>"
required>
</div>


<div class="input-group">
<label>Cidade</label>


<input
type="text"
name="cidade"
id="cidade"
placeholder="Rio de Janeiro"
value="<?= $cliente['cidade'] ?? '' ?>"
required>
</div>


<div class="input-group">
<label>Estado</label>


<select name="estado" id="estado" required>


<option value="">Selecione</option>


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
</div>


<div class="input-group">
<label>Zona de entrega</label>


<select name="regiao" id="regiao" required>


<option value="">Selecione</option>


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

<option value="Zona Sudoeste"
<?= ($cliente['regiao'] ?? '') == 'Zona Sudoeste' ? 'selected' : '' ?>>
Zona Sudoeste
</option>


<option value="Entrega Externa"
<?= ($cliente['regiao'] ?? '') == 'Entrega Externa' ? 'selected' : '' ?>>
Entrega Externa
</option>


</select>


<small>
Utilizado apenas para entregas no Rio de Janeiro - RJ.
</small>


</div>


</div>


<button type="submit" class="btn">
<i class="fa-solid fa-truck"></i>
Calcular Frete
</button>


</form>


<?php if($frete !== null): ?>


<div class="resumo" id="resumoFrete">


<h2>Resumo do Pedido</h2>


<div class="resumo-item">
<span>Subtotal</span>
<span>R$ <?= number_format($total, 2, ',', '.') ?></span>
</div>


<div class="resumo-item">
<span>Frete</span>
<span>R$ <?= number_format($frete, 2, ',', '.') ?></span>
</div>


<div class="resumo-item total">
<span>Total</span>
<span>R$ <?= number_format($totalFinal, 2, ',', '.') ?></span>
</div>


<div class="finalizar">


<a href="checkout.php">


<button>
<i class="fa-solid fa-credit-card"></i>
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
window.addEventListener('load', verificarEntrega);


function verificarEntrega(){

    let cidadeValor = cidade.value.toLowerCase().trim();
    let estadoValor = estado.value.toUpperCase().trim();

    if(
        cidadeValor === 'rio de janeiro' &&
        estadoValor === 'RJ'
    ){

        regiao.disabled = false;

        if(regiao.value === 'Entrega Externa'){
            regiao.value = '';
        }

    } else {
        regiao.value = 'Entrega Externa';
        regiao.disabled = true;
    }
}

cidade.addEventListener('input', verificarEntrega);
estado.addEventListener('change', verificarEntrega);

verificarEntrega();


</script>

<script>

const cepInput = document.getElementById('cep');
cepInput.addEventListener('blur', async function(){

    let cep = cepInput.value.replace(/\D/g,'');

    if(cep.length != 8){
        return;
    }

    try{

        const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const dados = await resposta.json();

        if(dados.erro){
            alert("CEP não encontrado.");
            return;
        }


        document.querySelector('input[name="endereco"]').value = dados.logradouro || '';
        document.querySelector('input[name="bairro"]').value = dados.bairro || '';
        document.getElementById('cidade').value = dados.localidade || '';
        document.getElementById('estado').value = dados.uf || '';

        verificarEntrega();

    } catch(error){

        console.log(error);
        alert("Erro ao buscar CEP.");

    }

});
</script>

<script>

window.addEventListener('load', () => {

    const resumo = document.getElementById('resumoFrete');

    if(resumo){

        resumo.scrollIntoView({
            behavior: 'smooth'
        });

    }

});


</script>

</body>
</html>