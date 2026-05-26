<div class="container">   
    <h2>Produtos</h2>  
    <button onclick="location.href='produtos/criar.php'">Cadastrar Produto</button>    
</div>    


<table>    
    <tr>    
        <th>Nome</th>    
        <th>Preço</th>    
        <th>Estoque</th>    
        <th>Ações</th>    
    </tr>    


    <?php foreach($produtos as $p): ?>    
    <tr>    
        <td><?= $p['nome'] ?></td>    
        <td>R$ <?= number_format($p['preco'],2,',','.') ?></td>    
        <td><?= $p['estoque'] ?></td>    
        <td>    
            <a href="produtos/editar.php?id=<?= $p['id_produtos'] ?>"><button class="btn-editar"><i class="fa-solid fa-pen"></i></button></a>    
            <a href="produtos/excluir.php?id=<?= $p['id_produtos'] ?>"onclick="return confirm('Deseja excluir este produto?')"><button class="btn-excluir"><i class="fa-solid fa-trash"></i></button></a>    
        </td>    
    </tr>    
    <?php endforeach; ?>    
</table>
</div>
</body>
</html>
