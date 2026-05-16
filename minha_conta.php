<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?erro=login");
    exit;
}


include 'includes/conexao.php';


$idUsuario = $_SESSION['id'];


$sql = $pdo->prepare("
SELECT 
    u.email,
    c.nome,
    c.telefone,
    c.cep,
    c.endereco,
    c.numero,
    c.bairro,
    c.cidade,
    c.estado,
    c.regiao
FROM clientes c
JOIN usuarios u ON u.id_usuario = c.usuario_id
WHERE c.usuario_id = ?
");


$sql->execute([$idUsuario]);


$cliente = $sql->fetch(PDO::FETCH_ASSOC);


$primeiroNome = explode(" ", trim($cliente['nome']))[0];
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Minha Conta</title>
<link rel="stylesheet" href="css/styleConta.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php if(isset($_GET['erro'])): ?>


<div class="alerta">


<?php


if($_GET['erro'] == 'nome_vazio'){
    echo "Preencha o nome.";
}


elseif($_GET['erro'] == 'telefone_vazio'){
    echo "Preencha o telefone.";
}


elseif($_GET['erro'] == 'telefone_invalido'){
    echo "Número de celular inválido.";
}


elseif($_GET['erro'] == 'cep_invalido'){
    echo "CEP inválido.";
}


elseif($_GET['erro'] == 'regiao_vazia'){
    echo "Selecione uma região.";
}


elseif($_GET['erro'] == 'endereco_incompleto'){
    echo "Complete os dados do endereço.";
}


else{
    echo "Ocorreu um erro inesperado.";
}


?>


<span class="fechar"
onclick="this.parentElement.style.display='none'">
X
</span>


</div>


<?php endif; ?>


<?php if(isset($_GET['msg'])): ?>


<div class="alerta-sucesso">


<?php


if($_GET['msg'] == 'salvo'){
    echo "Dados atualizados com sucesso!";
}


elseif($_GET['msg'] == 'endereco_salvo'){
    echo "Endereço atualizado com sucesso!";
}


else{
    echo "Operação realizada com sucesso!";
}


?>


<span class="fechar"
onclick="this.parentElement.style.display='none'">X</span>


</div>


<?php endif; ?>


<?php include 'includes/navbar.php'; ?>


<div class="container">


<div class="topo-conta">


<h1>Olá, <?= $primeiroNome; ?> 👋</h1>


<p>Gerencie suas informações pessoais e endereço</p>


</div>


<form action="actions/salvar_conta.php" method="POST">


<div class="grid-conta">


<div class="card-conta">


<h2>
<i class="fa-solid fa-user"></i>
Dados Pessoais
</h2>


<div class="form-grid">


<div class="input-group">
<label>Nome</label>


<input
type="text"
name="nome"
value="<?= htmlspecialchars($cliente['nome']) ?>"
required>
</div>


<div class="input-group">
<label>Telefone</label>


<input
type="text"
id="telefone"
name="telefone"
maxlength="15"
value="<?= htmlspecialchars($cliente['telefone']) ?>"
required>
</div>


<div class="input-group full">
<label>Email</label>


<input
type="email"
value="<?= htmlspecialchars($cliente['email']) ?>"
disabled>
</div>


</div>


</div>


<div class="card-conta">

<h2>
<i class="fa-solid fa-location-dot"></i>
Endereço
</h2>

<div class="form-grid">

<div class="input-group">
<label>CEP</label>

<input
type="text"
id="cep"
name="cep"
maxlength="9"
value="<?= htmlspecialchars($cliente['cep'] ?? '') ?>">
</div>

<div class="input-group">
<label>Número</label>

<input
type="text"
name="numero"
value="<?= htmlspecialchars($cliente['numero'] ?? '') ?>">
</div>

<div class="input-group full">
<label>Rua / Avenida</label>

<input
type="text"
name="endereco"
value="<?= htmlspecialchars($cliente['endereco'] ?? '') ?>">
</div>

<div class="input-group">
<label>Bairro</label>

<input
type="text"
name="bairro"
value="<?= htmlspecialchars($cliente['bairro'] ?? '') ?>">
</div>

<div class="input-group">
<label>Cidade</label>

<input
type="text"
name="cidade"
value="<?= htmlspecialchars($cliente['cidade'] ?? '') ?>">
</div>

<!-- ESTADO ALINHADO COM FRETE -->
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


    $selected = (($cliente['estado'] ?? '') === $sigla)
    ? 'selected'
    : '';


    echo "
    <option value='$sigla' $selected>
        $nome ($sigla)
    </option>";
}


?>

</select>
</div>

<!-- REGIÃO ALINHADA COM FRETE -->
<div class="input-group full">
<label>Zona de entrega</label>

<select name="regiao" id="regiao" required>

<option value="">Selecione</option>

<?php
$regioes = [
"Centro",
"Zona Sul",
"Zona Norte",
"Zona Oeste",
"Entrega Externa"
];

foreach($regioes as $r){

    $selected = (($cliente['regiao'] ?? '') === $r) ? 'selected' : '';

    echo "<option value='$r' $selected>$r</option>";
}
?>

</select>

<small>Utilizado para cálculo de frete no checkout.</small>

</div>

</div>

</div>


</div>


<button type="submit" class="botao-salvar">
Salvar Alterações
</button>


</form>


</div>


<?php include 'includes/footer.php'; ?>


<script>

document.getElementById('telefone').addEventListener('input', function(e){

    let v = e.target.value.replace(/\D/g,'');

    if(v.length > 11){
        v = v.slice(0,11);
    }

    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
    v = v.replace(/(\d{5})(\d{4})$/, "$1-$2");

    e.target.value = v;
});

document.getElementById('cep').addEventListener('input', function(e){

    let v = e.target.value.replace(/\D/g,'');

    if(v.length > 8){
        v = v.slice(0,8);
    }

    v = v.replace(/(\d{5})(\d)/,'$1-$2');

    e.target.value = v;
});


const cidade = document.querySelector('input[name="cidade"]');
const estado = document.getElementById('estado');
const regiao = document.getElementById('regiao');
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

        document.querySelector('input[name="endereco"]').value =
        dados.logradouro || '';
        document.querySelector('input[name="bairro"]').value =
        dados.bairro || '';

        cidade.value = dados.localidade || '';

        estado.value = dados.uf || '';

        verificarEntrega();

    } catch(error){

        console.log(error);
    }

});

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
window.addEventListener('load', verificarEntrega);

</script>


</body>
</html>
