<?php
include 'includes/conexao.php';
session_start();


$sql = $pdo->query("
SELECT * FROM produtos WHERE destaque = true");
$produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/styleGeral.css">
    <title>Home</title>
</head>
<body>


<?php if (isset($_GET['msg'])): ?>
<div class="alerta sucesso">
<i class="fa-solid fa-circle-check"></i>
<?php
if ($_GET['msg'] == 'cadastrado') echo "Conta criada com sucesso";
if ($_GET['msg'] == 'login_sucesso') echo "Login realizado com sucesso";
?>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>


    <?php include 'includes/navbar.php'; ?>


    <section id="hero">
    <div id="textos">
        <h1>Segredo Doce</h1>
        <h2 class="subtitulo">Cada receita guarda um sabor inesquecível</h2>
        <p class="texto">Na Segredo Doce, cada receita é preparada com carinho,<br> 
            ingredientes seleciondos e aquele toque especial que<br> transforma simples
            momentos em lembranças inesquecíveis.
        </p>
        <button class="btn hero"><a href="cardapio.php">Ver Cardápio</a></button>
        <button class="btn hero2"><a href="sobre.php">Saiba Mais</a></button>
    </div>
    <div class="images">
    <img id="esquerda" src="imagens/Fatias.jpg">
    <img id="destaque" src="imagens/PoteSacole.jpg">
    <img id="direita" src="imagens/CopoFelicidadeTradicional.jpg">
    </div>
    </section>


    <section id="favoritos">
        <h1 class="titulo">Favoritos dos clientes</h1>
        <h2 class="subtitulo">Sabores que conquistaram nossos clientes e viraram favoritos</h2>


    <div class="produtos">


<?php foreach($produtos as $produto): ?>
            <div class="produto">
                <img src="<?= $produto['imagem']; ?>">
                <h2><?= $produto['nome']; ?></h2>


            <div class="info">


                 <div class="esquerda">
                <p><?= $produto['descricao']; ?></p>
                <span>R$ <?= number_format($produto['preco'],2,",","."); ?></span>
                <h3>Estoque: <?= $produto['estoque']; ?></h3>
            </div>


            <div class="direita">


                <h3 class="categoria <?= strtolower(str_replace(' ', '-',$produto['categoria'])); ?>"><?= $produto['categoria']; ?></h3>
                <div class="estrelas">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                </div>


            </div>


            </div>


            


            </div>
<?php endforeach; ?>


    </div>


    <br><br><a href="cardapio.php"><i class="fa-solid fa-basket-shopping"></i> Ver Produtos</a>
    </section>


    <section id="mid">
        
        <h1 class="titulo">Um sabor para cada vontade</h1>


        <div class="cards">


            <div class="card bolo"><i class="fa-solid fa-cake-candles"></i><h3>Bolos Gelados</h3></div>


            <div class="card doce"><i class="fa-solid fa-candy-cane"></i><h3>Doces Gourmet</h3></div>


            <div class="card bebida"><i class="fa-solid fa-mug-hot"></i><h3>Copos da Felicidade</h3></div>


            <div class="card gelado"><i class="fa-regular fa-snowflake"></i><h3>Fatias</h3></div>
            </div>


        </div>


        <h2 class="subtitulo">Mais do que doces, criamos momentos</h3>
        <p class="texto">Na Segredo Doce, cada receita nasce com carinho ingredientes<br> selecionados
            e aquele toque especial que transforma qualquer<br> momento em algo inesquecível
        </p>
    </section>


    <section id="beneficios">
        <h1 class="titulo">Por que Escolher a Segredo Doce?</h1>


        <div class="card">
            <div class="topo"><i class="fa-solid fa-angles-right"></i><h3>Ingredientes Selecionados</h3></div>
            <p class="texto">Receitas preparadas com ingredientes escolhidos
                para<br> garantir sabor e qualidade em cada detalhe
            </p>
        </div>


        <div class="card">
            <div class="topo"><i class="fa-solid fa-angles-right"></i><h3>Produção Fresca</h3></div>
            <p class="texto">Doces preparados com cuidado para entregar<br> frescor,
                textura e sabor impecáveis
            </p>
        </div>


        <div class="card">
            <div class="topo"><i class="fa-solid fa-angles-right"></i><h3>Feito com Carinho</h3></div>
            <p class="texto">Cada pedido recebe atenção especial, como se fosse<br>
                feito para alguém da família
            </p>
        </div>


        <div class="card">
            <div class="topo"><i class="fa-solid fa-angles-right"></i><h3>Encomendas Personalizadas</h3></div>
            <p class="texto">Produções especiais para aniversários, <br>
                festas e momentos únicos
            </p>
        </div>


        <div class="card">
            <div class="topo"><i class="fa-solid fa-angles-right"></i><h3>Atendimento Ágil</h3></div>
            <p class="texto">Praticidade no pedido e atendimento rápido<br> para 
                facilitar sua rotina
            </p>
        </div>


        <div class="card">
            <div class="topo"><i class="fa-solid fa-angles-right"></i><h3>Apresentação Encantadora</h3></div>
            <p class="texto">Além de deliciosos, nossos produtos <br>também conquistam
                no visual
            </p>
        </div>
    </section>


    <section id="avaliacoes">
        <h1 class="titulo">Quem prova, recomenda</h1>


        <div class="slider-box">




        <button class="seta esquerda" onclick="voltar()"><i class="fa-solid fa-arrow-left"></i></button>




        <div class="cards-area">




            <div class="lado fade"></div>




            <div class="card-avaliacao" id="cardPrincipal"></div>




            <div class="lado fade"></div>




        </div>




        <button class="seta direita" onclick="avancar()"><i class="fa-solid fa-arrow-right"></i></button>




    </div>


    </section>


    <script>




const avaliacoes = [




{
nome:"Mariana Souza",
texto:"Os doces chegaram impecáveis e com um sabor maravilhoso. Dá para sentir o carinho em cada detalhe.",
estrelas:"★★★★★"
},




{
nome:"Camila Alves",
texto:"Melhor bolo gelado que já experimentei. Cremoso, bonito e extremamente saboroso.",
estrelas:"★★★★★"
},




{
nome:"Fernanda Lima",
texto:"Atendimento rápido, entrega organizada e produtos lindos. Recomendo demais.",
estrelas:"★★★★☆"
},




{
nome:"Julia Costa",
texto:"Tudo muito caprichado. Pedi para aniversário e foi sucesso total entre os convidados.",
estrelas:"★★★★★"
}




];




let atual = 0;




function renderizar(){




document.getElementById("cardPrincipal").innerHTML = `




<div class="comentario">
${avaliacoes[atual].texto}
</div>




<div class="estrelas">
${avaliacoes[atual].estrelas}
</div>




<div class="nome">
${avaliacoes[atual].nome}
</div>




`;




}




function animarTroca(direcao){




const card = document.getElementById("cardPrincipal");




card.classList.remove("entra-esq","entra-dir");




card.classList.add(direcao == "dir" ? "sai-esq" : "sai-dir");




setTimeout(() => {




if(direcao == "dir"){
atual++;
if(atual >= avaliacoes.length) atual = 0;
}else{
atual--;
if(atual < 0) atual = avaliacoes.length -1;
}




renderizar();




card.classList.remove("sai-esq","sai-dir");




card.classList.add(direcao == "dir" ? "entra-dir" : "entra-esq");




},300);




}




function avancar(){
animarTroca("dir");
}




function voltar(){
animarTroca("esq");
}




renderizar();




</script>


        <section id="festas">
            <h1 class="titulo">Seu evento merece um sabor inesquecível</h1>
            <p class="texto">Aniversários, festas, lembranças e datas especiais<br>
                com doces preparados sob medida pra você
            </p>
        <button class="btn festa"><a href="contato.php">Solicitar Orçamento</a></button>
        </section>


        <section id="final">


            <section class="estatisticas">




    <div class="stat">
        <h3>+500</h3>
        <p>Pedidos entregues</p>
    </div>




    <div class="stat">
        <h3>+100</h3>
        <p>Clientes felizes</p>
    </div>




    <div class="stat">
        <h3>★★★★★</h3>
        <p>Avaliações positivas</p>
    </div>




    <div class="stat">
        <h3>100%</h3>
        <p>Feito com carinho</p>
    </div>




</section>


<h2>Transformando pequenos momentos em doces lembranças</h2>

        </section>


<?php include 'includes/footer.php'; ?>


</body>
</html>