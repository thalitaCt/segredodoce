<?php
include 'includes/conexao.php';
session_start();

$sql = $pdo->query("
SELECT * FROM produtos 
WHERE destaque = true
LIMIT 4
");

$produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

    <meta
    name="description"
    content="Doces artesanais, bolos gelados, copos da felicidade e sobremesas especiais feitas com carinho.">

    <title>
        Segredo Doce | Confeitaria Artesanal
    </title>

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link
    rel="stylesheet"
    href="css/styleGeral.css">
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

    <span
    class="fechar"
    onclick="this.parentElement.style.display='none'">
        X
    </span>

</div>

<?php endif; ?>

<?php include 'includes/navbar.php'; ?>

<!-- HERO -->

<section id="hero">

    <div id="textos">

        <div class="hero-badge">
            ✨ Doces artesanais feitos com carinho
        </div>

        <h1>
            O sabor que transforma momentos
        </h1>

        <h2 class="subtitulo">
            Cada receita guarda um sabor inesquecível
        </h2>

        <p class="texto">
            Na Segredo Doce, cada sobremesa é preparada
            com ingredientes selecionados e aquele toque
            especial que transforma momentos simples em
            lembranças doces e inesquecíveis.
        </p>

        <div class="hero-botoes">

            <button class="btn hero">
                <a href="cardapio.php">
                    Ver Cardápio
                </a>
            </button>

            <button class="btn hero2">
                <a href="sobre.php">
                    Saiba Mais
                </a>
            </button>

        </div>

        <div class="mini-stats">

            <div class="mini-stat">
                <strong>+500</strong>
                <span>Pedidos entregues</span>
            </div>

            <div class="mini-stat">
                <strong>★★★★★</strong>
                <span>Clientes satisfeitos</span>
            </div>

        </div>

    </div>

    <div class="images">

        <img
        id="esquerda"
        src="imagens/Fatias.jpg"
        alt="Fatias doces">

        <img
        id="destaque"
        src="imagens/PoteSacole.jpg"
        alt="Copos da felicidade">

        <img
        id="direita"
        src="imagens/CopoFelicidadeTradicional.jpg"
        alt="Sobremesa artesanal">

    </div>

</section>

<!-- FAVORITOS -->

<section id="favoritos">

    <h1 class="titulo">
        Favoritos dos clientes
    </h1>

    <h2 class="subtitulo">
        Os sabores mais pedidos da Segredo Doce
    </h2>

    <div class="produtos">

<?php foreach($produtos as $produto): ?>

        <div class="produto">

            <div class="produto-img">

                <img
                src="<?= $produto['imagem']; ?>"
                alt="<?= $produto['nome']; ?>">

            </div>

            <div class="produto-conteudo">

                <div class="topo-produto">

                    <h2>
                        <?= $produto['nome']; ?>
                    </h2>

                    <span class="preco">
                        R$ <?= number_format($produto['preco'],2,",","."); ?>
                    </span>

                </div>

                <p class="descricao">
                    <?= $produto['descricao']; ?>
                </p>

                <div class="rodape-produto">

                    <div class="estrelas">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <span class="categoria <?= strtolower(str_replace(' ', '-', $produto['categoria'])); ?>">
                        <?= $produto['categoria']; ?>
                    </span>

                </div>

                <div class="acoes-produto">

                    <a
                    href="produto.php?id=<?= $produto['id_produtos']; ?>"
                    class="btn-produto">

                        Ver Produto

                    </a>

                </div>

            </div>

        </div>

<?php endforeach; ?>

    </div>

    <a href="cardapio.php" class="btn-ver-todos">
        <i class="fa-solid fa-basket-shopping"></i>
        Ver Todos os Produtos
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
        Cada detalhe é preparado com carinho para
        transformar aniversários, encontros e pequenos
        momentos em lembranças especiais.
    </p>

</section>

<!-- BENEFÍCIOS -->

<section id="beneficios">

    <h1 class="titulo">
        Por que escolher a Segredo Doce?
    </h1>

    <div class="beneficios-grid">

        <div class="card">

            <div class="topo">

                <div class="icone-beneficio">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <h3>Feito com carinho</h3>

            </div>

            <p class="texto">
                Receitas preparadas com dedicação
                em cada detalhe.
            </p>

        </div>

        <div class="card">

            <div class="topo">

                <div class="icone-beneficio">
                    <i class="fa-solid fa-cookie-bite"></i>
                </div>

                <h3>Ingredientes selecionados</h3>

            </div>

            <p class="texto">
                Qualidade e sabor em todas as receitas.
            </p>

        </div>

        <div class="card">

            <div class="topo">

                <div class="icone-beneficio">
                    <i class="fa-solid fa-bolt"></i>
                </div>

                <h3>Atendimento rápido</h3>

            </div>

            <p class="texto">
                Praticidade para facilitar seus pedidos.
            </p>

        </div>

        <div class="card">

            <div class="topo">

                <div class="icone-beneficio">
                    <i class="fa-solid fa-gift"></i>
                </div>

                <h3>Perfeito para eventos</h3>

            </div>

            <p class="texto">
                Doces especiais para festas e comemorações.
            </p>

        </div>

    </div>

</section>

<!-- AVALIAÇÕES -->

<section id="avaliacoes">

    <h1 class="titulo">
        Quem prova, recomenda
    </h1>

    <div class="slider-box">

        <button
        class="seta esquerda"
        onclick="voltar()">

            <i class="fa-solid fa-arrow-left"></i>

        </button>

        <div class="cards-area">

            <div class="card-avaliacao" id="cardPrincipal"></div>

        </div>

        <button
        class="seta direita"
        onclick="avancar()">

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
        Produções especiais para aniversários,
        festas e momentos únicos.
    </p>

    <button class="btn festa">

        <a href="contato.php">
            Solicitar Orçamento
        </a>

    </button>

</section>

<!-- FINAL -->

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
texto:"Tudo muito caprichado e delicioso.",
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

setInterval(() => {
    avancar();
}, 5000);

renderizar();

</script>

</body>
</html>