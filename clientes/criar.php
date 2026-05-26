<?php
session_start();

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'gerente') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/styleGerente.css">
<title>Cadastrar Cliente</title>

<style>
.erro-senha{
    color:red;
    font-size:13px;
    margin-top:5px;
    display:none;
}
</style>
</head>

<body>

<?php if(isset($_GET['erro'])): ?>
<div class="alerta">
<?php
if ($_GET['erro'] == 'telefone_invalido') {
    echo "Número de celular inválido. Use DDD + número (ex: 21999999999).";
}
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<div class="form-card">

<h2>Cadastrar Cliente</h2>

<form method="POST" action="salvar_criacao.php">


<div class="form-grid cliente-grid">


<div class="input-group">
<label>Nome</label>
<input type="text" name="nome" required>
</div>


<div class="input-group">
<label>Telefone</label>
<input type="text" id="telefone" name="telefone" maxlength="15" required>
</div>


<div class="input-group">
<label>Email</label>
<input type="email" name="email" required>
</div>


<div class="input-group">
<label>Senha</label>
<input type="password" id="senha" name="senha" required>
</div>


<div class="input-group">
<label>Confirmar senha</label>
<input type="password" id="confirmar_senha" required>
<div class="erro-senha" id="erroSenha">
Senhas não coincidem
</div>
</div>


<div class="input-group">
<label>CEP</label>
<input type="text" id="cep" name="cep" maxlength="9">
</div>


<div class="input-group">
<label>Número</label>
<input type="text" name="numero">
</div>


<div class="input-group full">
<label>Rua / Avenida</label>
<input type="text" name="endereco">
</div>


<div class="input-group">
<label>Bairro</label>
<input type="text" name="bairro">
</div>


<div class="input-group">
<label>Cidade</label>
<input type="text" name="cidade" id="cidade">
</div>


<div class="input-group">
<label>Estado</label>


<select name="estado" id="estado">


<option value="">Selecione</option>


<option value="AC">Acre (AC)</option>
<option value="AL">Alagoas (AL)</option>
<option value="AP">Amapá (AP)</option>
<option value="AM">Amazonas (AM)</option>
<option value="BA">Bahia (BA)</option>
<option value="CE">Ceará (CE)</option>
<option value="DF">Distrito Federal (DF)</option>
<option value="ES">Espírito Santo (ES)</option>
<option value="GO">Goiás (GO)</option>
<option value="MA">Maranhão (MA)</option>
<option value="MT">Mato Grosso (MT)</option>
<option value="MS">Mato Grosso do Sul (MS)</option>
<option value="MG">Minas Gerais (MG)</option>
<option value="PA">Pará (PA)</option>
<option value="PB">Paraíba (PB)</option>
<option value="PR">Paraná (PR)</option>
<option value="PE">Pernambuco (PE)</option>
<option value="PI">Piauí (PI)</option>
<option value="RJ">Rio de Janeiro (RJ)</option>
<option value="RN">Rio Grande do Norte (RN)</option>
<option value="RS">Rio Grande do Sul (RS)</option>
<option value="RO">Rondônia (RO)</option>
<option value="RR">Roraima (RR)</option>
<option value="SC">Santa Catarina (SC)</option>
<option value="SP">São Paulo (SP)</option>
<option value="SE">Sergipe (SE)</option>
<option value="TO">Tocantins (TO)</option>


</select>
</div>


<div class="input-group">
<label>Zona de entrega</label>


<select name="regiao" id="regiao">


<option value="">Selecione</option>


<option value="Centro">Centro</option>
<option value="Zona Sul">Zona Sul</option>
<option value="Zona Norte">Zona Norte</option>
<option value="Zona Oeste">Zona Oeste</option>
<option value="Zona Sudoeste">Zona Sudoeste</option>
<option value="Entrega Externa">Entrega Externa</option>


</select>
</div>


</div>


<button type="submit" id="btnSubmit">
Criar Cliente
</button>


</form>

</div>

<script>
// telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g,'');

    if (v.length > 11) v = v.slice(0, 11);

    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
    v = v.replace(/(\d{5})(\d{4})$/, "$1-$2");

    e.target.value = v;
});


// senhas
const senha = document.getElementById('senha');
const confirmar = document.getElementById('confirmar_senha');
const erro = document.getElementById('erroSenha');
const btn = document.getElementById('btnSubmit');

function validarSenha(){
    if(confirmar.value !== senha.value){
        erro.style.display = "block";
        btn.disabled = true;
        btn.style.opacity = 0.5;
    } else {
        erro.style.display = "none";
        btn.disabled = false;
        btn.style.opacity = 1;
    }
}

senha.addEventListener('input', validarSenha);
confirmar.addEventListener('input', validarSenha);

document.getElementById('cep').addEventListener('input', function(e){

    let v = e.target.value.replace(/\D/g,'');

    if(v.length > 8){
        v = v.slice(0,8);
    }

    v = v.replace(/(\d{5})(\d)/,'$1-$2');

    e.target.value = v;

});


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

</script>

</body>
</html>
