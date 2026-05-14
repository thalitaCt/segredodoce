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

<input type="text" name="nome" value="<?= $cliente['nome'] ?>">
<input type="email" name="email" value="<?= $cliente['email'] ?>">
<input type="text" id="telefone" name="telefone" value="<?= $cliente['telefone'] ?>">

<input type="text" name="cep" value="<?= $cliente['cep'] ?>" placeholder="CEP">
<input type="text" name="endereco" value="<?= $cliente['endereco'] ?>" placeholder="Endereço">
<input type="text" name="numero" value="<?= $cliente['numero'] ?>" placeholder="Número">
<input type="text" name="bairro" value="<?= $cliente['bairro'] ?>" placeholder="Bairro">
<input type="text" name="cidade" value="<?= $cliente['cidade'] ?>" placeholder="Cidade">

<select name="estado" required>
    <option value="">Selecione o estado</option>

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

<select name="regiao">
    <option value="">Região</option>
    <option value="Centro" <?= $cliente['regiao']=='Centro'?'selected':'' ?>>Centro</option>
    <option value="Zona Sul" <?= $cliente['regiao']=='Zona Sul'?'selected':'' ?>>Zona Sul</option>
    <option value="Zona Norte" <?= $cliente['regiao']=='Zona Norte'?'selected':'' ?>>Zona Norte</option>
    <option value="Zona Oeste" <?= $cliente['regiao']=='Zona Oeste'?'selected':'' ?>>Zona Oeste</option>
    <option value="Entrega Externa" <?= $cliente['regiao']=='Entrega Externa'?'selected':'' ?>>Entrega Externa</option>
</select>

<button type="submit">Salvar</button>

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
</script>

</body>
</html>
