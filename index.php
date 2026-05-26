<?php
include 'includes/conexao.php';
session_start();

$sql = $pdo->query("SELECT * FROM produtos WHERE destaque = true LIMIT 6");
$produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Segredo Doce | Confeitaria Artesanal</title>

    <meta name="description" content="Doces artesanais feitos com carinho. Bolos gelados, copos da felicidade, doces gourmet e muito mais.">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="css/styleGeral.css">
</head>
<body>

<?php if (isset($_GET['msg'])): ?>

<div class="alerta sucesso">

    <i class="fa-solid fa-circle-check"></i>

    <?php
    if ($_GET['msg'] == 'cadastrado') {
        echo "Conta criada com sucesso";
    }

    if ($_GET['msg'] == 'login_sucesso') {
        echo "Login realizado com sucesso";
    }
    ?>

    <span class="fechar" onclick="this.parentElement.style.display='none'">
        X
    </span>

</div>

<?php endif; ?>

<?php include 'includes/navbar.php'; ?>


<!-- HERO -->
<section id="hero">

    <div id="textos">

        <span class="tag-topo">
            ✨ Doces artesanais feitos com carinho
        </span>

        <h1>
            Segredo Doce
        </h1>

        <h2 class="subtitulo">
            Cada receita guarda um sabor inesquecível
        </h2>

        <p class="texto">
            Na Segredo Doce, cada doce é preparado com ingredientes
            selecionados, carinho e aquele toque especial que transforma
            momentos simples em lembranças inesquecíveis.
        </p>

        <div class="hero-buttons">

            <a href="cardapio.php" class="btn hero">
                <i class="fa-solid fa-basket-shopping"></i>
                Ver Cardápio
            </a>

            <a href="sobre.php" class="btn hero2">
                Saiba Mais
            </a>

        </div>

    </div>


    <div class="images">

        <img id="esquerda" src="imagens/Fatias.jpg" alt="Fatias doces">

        <img id="destaque" src="imagens/PoteSacole.jpg" alt="Produto destaque">

        <img id="direita" src="imagens/CopoFelicidadeTradicional.jpg" alt="Copo da felicidade">

    </div>

</section>


<!-- FAVORITOS -->
<section id="favoritos">

    <h1 class="titulo">
        Favoritos dos clientes
    </h1>

    <h2 class="subtitulo">
        Os doces mais pedidos da Segredo Doce
    </h2>


    <div class="produtos">

        <?php foreach($produtos as $produto): ?>

        <article class="produto">

            <img src="<?= $produto['imagem']; ?>"
                 alt="<?= $produto['nome']; ?>">


            <div class="produto-conteudo">

                <h2>
                    <?= $produto['nome']; ?>
                </h2>

                <p class="descricao-produto">
                    <?= $produto['descricao']; ?>
                </p>


                <div class="info">

                    <div class="esquerda">

                        <span>
                            R$ <?= number_format($produto['preco'],2,',','.'); ?>
                        </span>

                        <h3>
                            Estoque: <?= $produto['estoque']; ?>
                        </h3>

                    </div>


                    <div class="direita">

                        <h3 class="categoria <?= strtolower(str_replace(' ', '-', $produto['categoria'])); ?>">
                            <?= $produto['categoria']; ?>
                        </h3>

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

        </article>

        <?php endforeach; ?>

    </div>


    <a href="cardapio.php" class="btn-produtos">
        <i class="fa-solid fa-basket-shopping"></i>
        Ver todos os produtos
    </a>

</section>


<!-- CATEGORIAS -->
<section id="mid">

    <h1 class="titulo">
        Um sabor para cada vontade
    </h1>


    <div class="cards">

        <div class="card bolo">
            <i class="fa-solid fa-cake-candles"></i>
            <h3>Bolos Gelados</h3>
        </div>


        <div class="card doce">
            <i class="fa-solid fa-candy-cane"></i>
            <h3>Doces Gourmet</h3>
        </div>


        <div class="card bebida">
            <i class="fa-solid fa-mug-hot"></i>
            <h3>Copos da Felicidade</h3>
        </div>


        <div class="card gelado">
            <i class="fa-regular fa-snowflake"></i>
            <h3>Fatias</h3>
        </div>

    </div>


    <h2 class="subtitulo">
        Mais do que doces, criamos momentos
    </h2>


    <p class="texto">
        Cada receita é preparada com carinho para transformar
        qualquer ocasião em algo especial.
    </p>

</section>


<!-- BENEFÍCIOS -->
<section id="beneficios">

    <h1 class="titulo">
        Por que escolher a Segredo Doce?
    </h1>


    <div class="beneficios-grid">

        <div class="card-beneficio">
            <i class="fa-solid fa-heart"></i>
            <h3>Feito com carinho</h3>
            <p>Receitas preparadas artesanalmente em cada detalhe.</p>
        </div>


        <div class="card-beneficio">
            <i class="fa-solid fa-cookie-bite"></i>
            <h3>Ingredientes selecionados</h3>
            <p>Qualidade e sabor em todos os produtos.</p>
        </div>


        <div class="card-beneficio">
            <i class="fa-solid fa-gift"></i>
            <h3>Encomendas especiais</h3>
            <p>Personalizamos seus pedidos para momentos únicos.</p>
        </div>


        <div class="card-beneficio">
            <i class="fa-solid fa-truck"></i>
            <h3>Atendimento rápido</h3>
            <p>Praticidade e organização em cada entrega.</p>
        </div>

    </div>

</section>


<!-- AVALIAÇÕES -->
<section id="avaliacoes">

    <h1 class="titulo">
        Quem prova, recomenda
    </h1>


    <div class="slider-box">

        <button class="seta esquerda" onclick="voltar()">
            <i class="fa-solid fa-arrow-left"></i>
        </button>


        <div class="cards-area">

            <div class="lado fade"></div>

            <div class="card-avaliacao" id="cardPrincipal"></div>

            <div class="lado fade"></div>

        </div>


        <button class="seta direita" onclick="avancar()">
            <i class="fa-solid fa-arrow-right"></i>
        </button>

    </div>

</section>


<!-- FESTAS -->
<section id="festas">

    <h1 class="titulo">
        Seu evento merece um sabor inesquecível
    </h1>


    <p class="texto">
        Produções especiais para aniversários, festas e momentos únicos.
    </p>


    <a href="contato.php" class="btn festa">
        Solicitar orçamento
    </a>

</section>


<!-- ESTATÍSTICAS -->
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


    <h2>
        Transformando pequenos momentos em doces lembranças
    </h2>

</section>


<?php include 'includes/footer.php'; ?>


<script>

const avaliacoes = [

{
nome:"Mariana Souza",
texto:"Os doces chegaram impecáveis e com um sabor maravilhoso.",
estrelas:"★★★★★"
},

{
nome:"Camila Alves",
texto:"Melhor bolo gelado que já experimentei.",
estrelas:"★★★★★"
},

{
nome:"Fernanda Lima",
texto:"Atendimento rápido e produtos lindos.",
estrelas:"★★★★☆"
},

{
nome:"Julia Costa",
texto:"Tudo muito caprichado. Foi sucesso no aniversário.",
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


function avancar(){

    atual++;

    if(atual >= avaliacoes.length){
        atual = 0;
    }

    renderizar();
}


function voltar(){

    atual--;

    if(atual < 0){
        atual = avaliacoes.length - 1;
    }

    renderizar();
}


renderizar();

</script>

</body>
</html>