<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/styleGerente.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="form-card">

<h2>Cadastrar Produto</h2>

<form method="POST" action="salvar_criacao.php">

<div class="form-grid produto-grid">

<div class="input-group">
<label>Nome do Produto</label>

<input
type="text"
name="nome"
placeholder="Ex: Bolo de Morango"
required>
</div>

<div class="input-group">
<label>Categoria</label>

<select name="categoria" required>

<option value="">Selecione</option>

<option value="Bolo de Pote">
Bolo de Pote
</option>

<option value="Fatias">
Fatias
</option>

<option value="Gourmet">
Gourmet
</option>

<option value="Copo da Felicidade">
Copo da Felicidade
</option>

</select>
</div>

<div class="input-group">
<label>Preço</label>

<input
type="number"
step="0.01"
name="preco"
placeholder="0,00"
required>
</div>

<div class="input-group">
<label>Estoque</label>

<input
type="number"
name="estoque"
placeholder="Quantidade"
required>
</div>

<div class="input-group full">
<label>Descrição</label>

<textarea
name="descricao"
placeholder="Descrição do produto"
rows="4"></textarea>
</div>

<div class="input-group full">
<label>Imagem</label>

<input
type="file"
name="imagem" 
required>

</div>

</div>

<button type="submit">
Cadastrar Produto
</button>

</form>
</div>

</body>
</html>
