<?php
session_start();
include '../includes/conexao.php';


if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}


$id = $_GET['id'];


$sql = $pdo->prepare("SELECT * FROM produtos WHERE id_produtos = ?");
$sql->execute([$id]);
$produto = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php if (isset($_GET['erro'])): ?>
<div class="alerta erro">

<i class="fa-solid fa-triangle-exclamation"></i>
<?php
if ($_GET['erro'] == 'invalida') echo "Envie uma imagem válida.";
if ($_GET['erro'] == 'formato') echo "Formato de imagem inválido.";
if ($_GET['erro'] == 'upload') echo "Erro ao enviar imagem.";

?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<div class="form-card">

<h2>Alterar Produto</h2>

<form method="POST" action="salvar_edicao.php">

<input 
type="hidden" 
name="id" 
value="<?= $produto['id_produtos'] ?>"
>

<div class="form-grid produto-grid">

<div class="input-group">
<label>Nome</label>

<input
type="text"
name="nome"
value="<?= htmlspecialchars($produto['nome']) ?>"
required
>
</div>

<div class="input-group">
<label>Preço</label>

<input
type="number"
step="0.01"
name="preco"
value="<?= $produto['preco'] ?>"
required
>
</div>

<div class="input-group">
<label>Estoque</label>

<input
type="number"
name="estoque"
value="<?= $produto['estoque'] ?>"
required
>
</div>

<div class="input-group">
<label>Categoria</label>

<select name="categoria" required>

<option value="">Selecione</option>

<option value="Bolo de Pote"
<?= $produto['categoria'] == 'Bolo de Pote' ? 'selected' : '' ?>>
Bolo de Pote
</option>

<option value="Fatias"
<?= $produto['categoria'] == 'Fatias' ? 'selected' : '' ?>>
Fatias
</option>

<option value="Gourmet"
<?= $produto['categoria'] == 'Gourmet' ? 'selected' : '' ?>>
Gourmet
</option>

<option value="Copo da Felicidade"
<?= $produto['categoria'] == 'Copo da Felicidade' ? 'selected' : '' ?>>
Copo da Felicidade
</option>

</select>
</div>

<div class="input-group full">
<label>Descrição</label>

<textarea
name="descricao"
placeholder="Descrição do produto"
><?= htmlspecialchars($produto['descricao']) ?></textarea>
</div>

<div class="input-group">
<label>Imagem Atual</label>

<?php

if(str_contains($produto['imagem'], 'http')){

    $imagemProduto = $produto['imagem'];

}else{

    $imagemProduto = '../../' . $produto['imagem'];

}

?>

<img
src="<?= $imagemProduto; ?>"
class="preview-img">

</div>

<div class="grupo">

<label>Nova Imagem (Opcional)</label>

<input
type="file"
name="imagem">

</div>

</div>

<button type="submit">
Salvar
</button>

</form>
</div>

</body>
</html>
