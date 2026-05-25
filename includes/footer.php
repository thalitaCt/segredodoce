<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

@import url('https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root{

    --rosa1:#ffb3aa;
    --rosa2:#ff877d;
    --rosa3:#ee5350;

    --bege:#fff4ee;
    --bege2:#ffedcd;

    --marrom:#7d5147;
    --marrom2:#5e2f25;
    --marrom3:#421d14;

    --branco:#ffffff;

}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins;
}

/* FOOTER */

.footer{

    margin-top:70px;

    background:
    linear-gradient(
    135deg,
    var(--marrom3),
    var(--marrom2)
    );

    color:var(--bege);

    position:relative;

    overflow:hidden;

}

/* EFEITO */

.footer::before{

    content:"";

    position:absolute;

    top:-100px;
    right:-100px;

    width:250px;
    height:250px;

    border-radius:50%;

    background:rgba(255,255,255,0.04);

}

.footer-container{

    max-width:1300px;

    margin:auto;

    padding:60px 35px 25px;

}

/* GRID */

.footer-grid{

    display:grid;

    grid-template-columns:
    1.3fr
    1fr
    1fr
    1fr;

    gap:40px;

}

/* LOGO */

.footer-logo{

    display:flex;
    align-items:center;

    gap:14px;

    margin-bottom:18px;

}

.footer-logo img{

    width:65px;
    height:65px;

    border-radius:50%;

    object-fit:cover;

    border:3px solid rgba(255,255,255,0.15);

}

.footer-logo h1{

    font-family:'Berkshire Swash';

    font-size:36px;
    font-weight:400;

    color:var(--branco);

}

/* DESCRIÇÃO */

.footer-text{

    line-height:1.8;

    font-size:15px;

    color:rgba(255,255,255,0.82);

}

/* TITULOS */

.footer-title{

    font-size:21px;
    font-weight:700;

    margin-bottom:20px;

    color:var(--branco);

    position:relative;

}

.footer-title::after{

    content:"";

    position:absolute;

    left:0;
    bottom:-8px;

    width:45px;
    height:3px;

    border-radius:20px;

    background:var(--rosa2);

}

/* LINKS */

.footer-links{

    display:flex;
    flex-direction:column;

    gap:14px;

}

.footer-links a{

    text-decoration:none;

    color:rgba(255,255,255,0.82);

    transition:0.3s;

    width:fit-content;

}

.footer-links a:hover{

    color:var(--bege2);

    transform:translateX(4px);

}

/* CONTATO */

.footer-contact{

    display:flex;
    flex-direction:column;

    gap:16px;

}

.footer-contact div{

    display:flex;

    align-items:flex-start;

    gap:12px;

    line-height:1.6;

    color:rgba(255,255,255,0.82);

    font-size:15px;

}

.footer-contact i{

    color:var(--rosa1);

    margin-top:3px;

    font-size:16px;

}

/* REDES */

.footer-social{

    display:flex;

    gap:14px;

    margin-top:10px;

}

.footer-social a{

    width:48px;
    height:48px;

    border-radius:50%;

    background:rgba(255,255,255,0.08);

    display:flex;
    align-items:center;
    justify-content:center;

    color:white;

    font-size:20px;

    text-decoration:none;

    transition:0.3s;

}

.footer-social a:hover{

    transform:translateY(-5px);

    background:var(--rosa2);

}

/* COPYRIGHT */

.footer-copy{

    margin-top:45px;
    padding-top:22px;

    border-top:
    1px solid rgba(255,255,255,0.12);

    text-align:center;

    color:rgba(255,255,255,0.65);

    font-size:14px;

}

/* RESPONSIVO */

@media(max-width:950px){

    .footer-grid{

        grid-template-columns:
        1fr 1fr;

    }

}

@media(max-width:768px){

    .footer-container{

        padding:50px 22px 22px;

    }

    .footer-grid{

        grid-template-columns:1fr;

        gap:35px;

    }

    .footer-logo h1{

        font-size:30px;

    }

    .footer-title{

        font-size:20px;

    }

    .footer-copy{

        font-size:13px;

    }

}

</style>

</head>

<body>

<footer class="footer">

<div class="footer-container">

<div class="footer-grid">

<!-- SOBRE -->

<div>

<div class="footer-logo">

<img src="imagens/LogoSegredo.png">

<h1>Segredo Doce</h1>

</div>

<p class="footer-text">

Sabores feitos para transformar momentos simples
em lembranças especiais. Nossa confeitaria une
carinho, criatividade e ingredientes selecionados
para criar doces inesquecíveis.

</p>

</div>

<!-- LINKS -->

<div>

<h2 class="footer-title">
Navegação
</h2>

<div class="footer-links">

<a href="index.php">
Home
</a>

<a href="cardapio.php">
Cardápio
</a>

<a href="sobre.php">
Sobre Nós
</a>

<a href="contato.php">
Contato
</a>

</div>

</div>

<!-- CONTATO -->

<div>

<h2 class="footer-title">
Contato
</h2>

<div class="footer-contact">

<div>

<i class="fa-solid fa-phone"></i>

<span>
(21) 99999-9999
</span>

</div>

<div>

<i class="fa-solid fa-envelope"></i>

<span>
confeitariasegredoce@gmail.com
</span>

</div>

<div>

<i class="fa-solid fa-location-dot"></i>

<span>
R. Senador Vergueiro, 93 - Loja 14<br>
Flamengo, Rio de Janeiro - RJ
</span>

</div>

</div>

</div>

<!-- REDES -->

<div>

<h2 class="footer-title">
Redes Sociais
</h2>

<p class="footer-text">

Acompanhe novidades, promoções
e nossos doces especiais.

</p>

<div class="footer-social">

<a href="https://www.facebook.com/share/18R5ChkSKD/">

<i class="fa-brands fa-facebook-f"></i>

</a>

<a href="https://www.instagram.com/confsegredoce_?igsh=NnowdzdpOTUyd3p5">

<i class="fa-brands fa-instagram"></i>

</a>

<a href="https://x.com/confsegredoce">

<i class="fa-brands fa-x-twitter"></i>

</a>

</div>

</div>

</div>

<div class="footer-copy">

© 2026 Segredo Doce — Todos os direitos reservados.

</div>

</div>

</footer>

</body>
</html>
