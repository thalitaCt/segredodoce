<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha</title>


<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


:root {
    --bege: #ffedcd;
    --bege2: #fff4ee;
    --rosa: #ff877d;
    --rosa2: #ee5350;
    --branco: #ffffff;
}


* {
    margin: 0;
    padding: 0;
    font-family: Poppins;
    box-sizing: border-box;
}


body {
    background: var(--bege);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;
}


/* CONTAINER */
.container {
    background: var(--rosa);
    padding: 30px;
    border-radius: 20px;
    width: 100%;
    max-width: 420px;
    color: white;
}


/* TITULO */
h2 {
    margin-bottom: 20px;
}


/* INPUT */
input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    outline: none;
    margin-top: 10px;
}


/* BOTÃO */
button {
    width: 100%;
    margin-top: 15px;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: var(--bege2);
    color: var(--rosa2);
    font-weight: 700;
    cursor: pointer;
}


button:hover {
    background: #ffe1d8;
}


/* ALERTA */
.alerta {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #e53935;
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    z-index: 9999;
    font-weight: 600;
}


.fechar {
    margin-left: 10px;
    cursor: pointer;
    font-weight: bold;
}


/* RESPONSIVO */
@media (max-width: 500px) {
    .container {
        width: 90%;
    }


    .alerta {
        right: 10px;
        left: 10px;
        font-size: 14px;
    }
}
</style>


</head>


<body>


<?php if(isset($_GET['erro'])): ?>
<div class="alerta">


<?php
if($_GET['erro'] === 'email') {
    echo "E-mail não encontrado.";
} else {
    echo "Erro ao processar solicitação.";
}
?>


<span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>


<!-- FORMULÁRIO -->
<div class="container">


    <h2>Esqueci minha senha</h2>


    <form action="actions/processa_esqueci.php" method="POST">


        <input 
            type="email" 
            name="email" 
            placeholder="Digite seu email"
            required
        >


        <button type="submit">Enviar link</button>


    </form>


</div>


</body>
</html>
