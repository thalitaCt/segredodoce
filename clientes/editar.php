<?php
session_start();
include '../includes/conexao.php';

$id = $_GET['id'];

$sql = $pdo->prepare("
SELECT c.*, u.email
FROM clientes c
JOIN usuarios u ON u.id_usuario = c.usuario_id
WHERE c.usuario_id = ?
");

$sql->execute([$id]);
$cliente = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php if(isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'telefone_invalido') echo "Número de celular inválido. Use DDD + número (ex: 21999999999).";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<div class="form-card">

<h2>Editar Cliente</h2>

<form method="POST" action="salvar_edicao.php">

<input type="hidden" name="id" value="<?= $cliente['usuario_id'] ?>">

<div class="form-grid cliente-grid">

<div class="input-group">
<label>Nome</label>

<input
type="text"
name="nome"
value="<?= $cliente['nome'] ?>"
required>
</div>

<div class="input-group">
<label>Email</label>

<input
type="email"
name="email"
value="<?= $cliente['email'] ?>"
required>
</div>

<div class="input-group">
<label>Telefone</label>

<input
type="text"
id="telefone"
name="telefone"
maxlength="15"
value="<?= $cliente['telefone'] ?>"
required>
</div>

<div class="input-group">
<label>CEP</label>

<input
type="text"
id="cep"
name="cep"
maxlength="9"
value="<?= $cliente['cep'] ?>">
</div>

<div class="input-group">
<label>Número</label>

<input
type="text"
name="numero"
value="<?= $cliente['numero'] ?>">
</div>

<div class="input-group full">
<label>Rua / Avenida</label>

<input
type="text"
name="endereco"
value="<?= $cliente['endereco'] ?>">
</div>

<div class="input-group">
<label>Bairro</label>

<input
type="text"
name="bairro"
value="<?= $cliente['bairro'] ?>">
</div>

<div class="input-group">
<label>Cidade</label>

<input
type="text"
id="cidade"
name="cidade"
value="<?= $cliente['cidade'] ?>">
</div>

<div class="input-group">
<label>Estado</label>

<select name="estado" id="estado" required>

<option value="">Selecione</option>

<option value="AC" <?= $cliente['estado']=='AC'?'selected':'' ?>>Acre (AC)</option>
<option value="AL" <?= $cliente['estado']=='AL'?'selected':'' ?>>Alagoas (AL)</option>
<option value="AP" <?= $cliente['estado']=='AP'?'selected':'' ?>>Amapá (AP)</option>
<option value="AM" <?= $cliente['estado']=='AM'?'selected':'' ?>>Amazonas (AM)</option>
<option value="BA" <?= $cliente['estado']=='BA'?'selected':'' ?>>Bahia (BA)</option>
<option value="CE" <?= $cliente['estado']=='CE'?'selected':'' ?>>Ceará (CE)</option>
<option value="DF" <?= $cliente['estado']=='DF'?'selected':'' ?>>Distrito Federal (DF)</option>
<option value="ES" <?= $cliente['estado']=='ES'?'selected':'' ?>>Espírito Santo (ES)</option>
<option value="GO" <?= $cliente['estado']=='GO'?'selected':'' ?>>Goiás (GO)</option>
<option value="MA" <?= $cliente['estado']=='MA'?'selected':'' ?>>Maranhão (MA)</option>
<option value="MT" <?= $cliente['estado']=='MT'?'selected':'' ?>>Mato Grosso (MT)</option>
<option value="MS" <?= $cliente['estado']=='MS'?'selected':'' ?>>Mato Grosso do Sul (MS)</option>
<option value="MG" <?= $cliente['estado']=='MG'?'selected':'' ?>>Minas Gerais (MG)</option>
<option value="PA" <?= $cliente['estado']=='PA'?'selected':'' ?>>Pará (PA)</option>
<option value="PB" <?= $cliente['estado']=='PB'?'selected':'' ?>>Paraíba (PB)</option>
<option value="PR" <?= $cliente['estado']=='PR'?'selected':'' ?>>Paraná (PR)</option>
<option value="PE" <?= $cliente['estado']=='PE'?'selected':'' ?>>Pernambuco (PE)</option>
<option value="PI" <?= $cliente['estado']=='PI'?'selected':'' ?>>Piauí (PI)</option>
<option value="RJ" <?= $cliente['estado']=='RJ'?'selected':'' ?>>Rio de Janeiro (RJ)</option>
<option value="RN" <?= $cliente['estado']=='RN'?'selected':'' ?>>Rio Grande do Norte (RN)</option>
<option value="RS" <?= $cliente['estado']=='RS'?'selected':'' ?>>Rio Grande do Sul (RS)</option>
<option value="RO" <?= $cliente['estado']=='RO'?'selected':'' ?>>Rondônia (RO)</option>
<option value="RR" <?= $cliente['estado']=='RR'?'selected':'' ?>>Roraima (RR)</option>
<option value="SC" <?= $cliente['estado']=='SC'?'selected':'' ?>>Santa Catarina (SC)</option>
<option value="SP" <?= $cliente['estado']=='SP'?'selected':'' ?>>São Paulo (SP)</option>
<option value="SE" <?= $cliente['estado']=='SE'?'selected':'' ?>>Sergipe (SE)</option>
<option value="TO" <?= $cliente['estado']=='TO'?'selected':'' ?>>Tocantins (TO)</option>

</select>
</div>

<div class="input-group">
<label>Zona de entrega</label>


<select name="regiao" id="regiao">

<option value="">Selecione</option>

<option value="Centro" <?= $cliente['regiao']=='Centro'?'selected':'' ?>>Centro</option>

<option value="Zona Sul" <?= $cliente['regiao']=='Zona Sul'?'selected':'' ?>>Zona Sul</option>

<option value="Zona Norte" <?= $cliente['regiao']=='Zona Norte'?'selected':'' ?>>Zona Norte</option>

<option value="Zona Oeste" <?= $cliente['regiao']=='Zona Oeste'?'selected':'' ?>>Zona Oeste</option>

<option value="Zona Sudoeste" <?= $cliente['regiao']=='Zona Sudoeste'?'selected':'' ?>>Zona Sudoeste</option>

<option value="Entrega Externa" <?= $cliente['regiao']=='Entrega Externa'?'selected':'' ?>>
Entrega Externa
</option>


</select>
</div>

</div>

<button type="submit">
Salvar
</button>

</form>

</div>

<script>
document.getElementById('telefone').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g,'');

    if (v.length > 11) v = v.slice(0, 11);

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
        regiao.disabled = true;

    }
}

cidade.addEventListener('input', verificarEntrega);
estado.addEventListener('change', verificarEntrega);

verificarEntrega();

const cepInput = document.getElementById('cep');

/* =========================
   BUSCAR CEP
========================= */

async function buscarCEP(){

    let cep = cepInput.value.replace(/\D/g,'');

    if(cep.length != 8){
        return;
    }

    try{

        const resposta =
        await fetch(`https://viacep.com.br/ws/${cep}/json/`);

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

    }
    catch(error){

        console.log(error);

    }

}

/* QUANDO SAI DO INPUT */
cepInput.addEventListener('blur', buscarCEP);

/* QUANDO APERTA ENTER */
cepInput.addEventListener('keydown', async function(e){

    if(e.key === 'Enter'){

        e.preventDefault();

        await buscarCEP();

        document.querySelector('input[name="numero"]').focus();
    }
});
</script>

</body>
</html>
