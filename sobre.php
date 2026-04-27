<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleSobre.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Sobre</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <h1 class="titulo">Sobre Nós</h1>

    <section id="inicio">
    <div class="imagens">
        <img id="esquerda" src="imagens/geral1.jpg">
        <img id="destaque" src="imagens/geral2.jpg">
        <img id="direita" src="imagens/geral3.jpg">
    </div>
    <h2 class="subtitulo">Como tudo começou</h2>
    <p class="texto">A Confeitaria segredo doce nasceu do sonho de uma mulher que sempre acreditou
         no poder dos<br> pequenos gestos. Desde jovem, ela costumava preparar bolos e pães para alegrar
          os vizinhos em momentos<br> difíceis. Cada receita era acompanhada de um sorriso e palavras de conforto.
        Com o tempo, decidiu transformar<br> esse carinho em um lugar especial.
        Assim surgiu a Confeitaria da Esperança: um cantinho simples,<br> com o cheiro doce
         de baunilha no ar e mesas floridas perto da janela. Lá, cada doce tem um significado.<br> Os
          cupcakes simbolizam alegria, os pães quentinhos representam aconchego, e
     os <br>bolos decorados trazem celebração. Mas o verdadeiro segredo da confeitaria não está
      no açúcar<br> ou na farinha, e sim no amor. Todos que passam por lá saem um pouco mais leves,<br> com
       o coração aquecido e um pedacinho de esperança para levar consigo.
    </p>
    </section>

    <section id="meio">

    <div class="missao">
        <h2 class="subtitulo">Nosso propósito vai além de vender doces</h2>
            <p id="info">Na Segredo Doce, acreditamos que cada pedido
                representa um momento especial. <br>Nossa missão é transformar
                ocasiões simples em lembranças doces,<br> através de produtos feitos
                com carinho e qualidade
            </p>

            <div class="pilares">

                <div class="pilar um">
                <i class="fa-solid fa-heart"></i>
                <div class="textos">
                <h3>Carinho</h3>
                <p>Produção feita com cuidado em cada detalhe</p>
                </div>
                </div>

                <div class="pilar dois">
                <i class="fa-solid fa-leaf"></i>
                <div class="textos">
                <h3>Qualidade</h3>
                <p>Ingredientes escolhidos para melhor sabor</p>
                </div>
                </div>

                <div class="pilar tres">
                <i class="fa-solid fa-star"></i>
                <div class="textos">
                <h3>Encantar</h3>
                <p>Experiências que marcam momentos especiais</p>
                </div>
                </div>
            </div>
    </div>
        <h2 class="subtitulo">Cada detalhe importa</h2>
        <p class="texto">Da escolha dos ingredientes ao acabamento
            final, cada etapa é feita<br> com dedicação para entregar 
            qualidade e encantar desde o primeiro olhar
        </p>

        <div class="galeria">
            <img class="esquerda" src="imagens/geral4.png">
            <img class="direita" src="imagens/geral5.webp">
            <img class="esquerda" src="imagens/geral9.jpg">
            <img class="direita" src="imagens/geral6.jpg">
            <img class="esquerda" src="imagens/geral7.jpg">
            <img class="direita" src="imagens/geral8.webp">
            <img class="esquerda" src="imagens/geral11.jpg">
        </div>
        </section>

        <section id="final">

        <h2 class="subtitulo">O que torna cada pedido especial</h1>

        <div class="cards">

            <div class="card">
                <i class="fa-solid fa-kitchen-set"></i>
                <h3>Produção Artesanal</h3>
                <p>Cada item é preparado com atenção aos detalhes, 
                    garantindo sabor e qualidade únicos</p>
            </div>

            <div class="card">
                <i class="fa-solid fa-book"></i>
                <h3>Receitas Exclusivas</h3>
                <p>Sabores preparados com combinações pensadas
                    para oferecer uma experiência única
                </p>
            </div>

            <div class="card">
                <i class="fa-solid fa-gift"></i>
                <h3>Atenção aos Detalhes</h3>
                <p>Cada acabamento, embalagem e apresentação 
                    recebe cuidado especial
                </p>
            </div>

            <div class="card">
                <i class="fa-solid fa-lightbulb"></i>
                <h3>Evolução Constante</h3>
                <p>Buscamos novas ideias, tendências e melhorias
                    para surpreender sempre
                </p>
            </div>

            <div class="card">
                <i class="fa-solid fa-truck"></i>
                <h3>Cuidado na Entrega</h3>
                <p>Organização e atenção para que tudo chegue
                    bonito e em perfeito estado
                </p>
            </div>

            <div class="card">
                <i class="fa-solid fa-check-double"></i>
                <h3>Experiência Completa</h3>
                <p>Não vendemos apenas doces, criamos
                    momentos memoráveis do pedido à entrega
                </p>
            </div>
        </div>
        </section>

<?php include 'includes/footer.php'; ?>
</body>
</html>