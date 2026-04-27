<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleContato.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Contato</title>
</head>
<body>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'enviado'): ?>
<div class="alerta">
<p>Mensagem enviada com sucesso!</p>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<?php if(isset($_GET['erro']) && $_GET['erro'] == 'campos_vazios'): ?>
<div class="alerta">
<p>Preencha todos os campos!</p>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>

<?php if(isset($_GET['erro']) && $_GET['erro'] == 'assunto'): ?>
<div class="alerta">
<p>Selecione um assunto válido!</p>
<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>


<?php
session_start();
?>

<?php include 'includes/navbar.php'; ?>

<section id="inicio">
    <h1 class="titulo">Vamos adoçar sua ideia?</h1>
        <p class="texto">Estamos prontos para tirar dúvidas,
            receber<br> pedidos e tornar seus momentos ainda mais especiais
        </p>

    <div class="cards">
        <div class="card">
            <i class="fa-brands fa-whatsapp"></i>
            <h2>WhatsApp</h2>
            <p>(21) 99999-9999</p>
        </div>

        <div class="card">
            <i class="fa-brands fa-instagram"></i>
            <h2>Instagram</h2>
            <p>@confsegredodoce</p>
        </div>

        <div class="card">
            <i class="fa-regular fa-envelope"></i>
            <h2>Email</h2>
            <p>confeitariasegredoce@gmail.com</p>
        </div>

        <div class="card">
            <i class="fa-regular fa-clock"></i>
            <h2>Horário</h2>
            <p>Segunda a Sexta: 09h ás 18h <br>Sábado: 09h ás 14h <br>Domingo: Fechado</p>
        </div>
    </div>
</section>

<section id="meio">

    <div class="info">
    <h2>Prefere nos escrever? <br>Envie sua mensagem abaixo</h2>

    <form action="actions/processa_contato.php" method="POST">
        Nome:<input type="text" name="nome" required>
        E-mail:<input type="email" name="email" required>
        Assunto:<select name="assunto" required>
            <option value="">Selecione um assunto</option>
            <option value="pedido">Fazer pedido</option>
            <option value="encomenda">Encomenda personalizada</option>
            <option value="cardapio">Dúvida sobre o cardápio</option>
            <option value="entrega">Prazo de entrega</option>
            <option value="parceria">Parcerias</option>
            <option value="sugestao">Sugestões</option>
            <option value="outro">Outro</option>
        </select>
        Mensagem:<textarea name="mensagem" required></textarea>
        <button type="submit">Enviar</button>
    </form>
    </div>

    <div class="mapa">
        <h2>Visite-nos no nosso endereço</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3674.391832695731!2d-43.175071200000005!3d-22.9357923!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x997f87fde9c3cb%3A0x4ea407ddc572b043!2sR.%20Sen.%20Vergueiro%2C%2093%20-%20Loja%2014%20-%20Flamengo%2C%20Rio%20de%20Janeiro%20-%20RJ%2C%2022230-000!5e0!3m2!1spt-BR!2sbr!4v1777234921723!5m2!1spt-BR!2sbr" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
    
</body>
</html>