<?php
$email = $_GET['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verificar conta</title>


<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


:root {
    --rosa: #ff877d;
    --rosa2: #ee5350;
    --bege: #fff4ee;
    --marrom3: #421d14;
    --branco: #fff;
}


*{
    margin:0;
    padding:0;
    font-family:Poppins;
    box-sizing:border-box;
}


body{
    background: var(--bege);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    text-align:center;
}


.container{
    background: var(--rosa);
    padding:30px;
    border-radius:20px;
    width:90%;
    max-width:420px;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}


h2{
    margin-bottom:20px;
    font-size:24px;
}


.codigo-container{
    display:flex;
    justify-content:center;
    gap:10px;
    margin:20px 0;
}


.codigo{
    width:50px;
    height:60px;
    text-align:center;
    font-size:22px;
    border-radius:10px;
    border:2px solid #eee;
    outline:none;
    font-weight:bold;
}


.codigo:focus{
    border-color: var(--rosa2);
    transform: scale(1.05);
}


button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background: var(--bege);
    color: var(--rosa2);
    font-weight:700;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}


button:hover{
    background: #ffe1d8;
}


.texto-reenvio{
    margin-top:15px;
    font-size:13px;
}


.texto-reenvio a{
    color:yellow;
    text-decoration:none;
    font-weight:600;
}


.alerta{
    position:fixed;
    top:20px;
    right:20px;
    background:#00a00d;
    color:white;
    padding:20px;
    border-radius:10px;
    font-weight:600;
    z-index:9999;
}


.fechar{
    margin-left:10px;
    cursor:pointer;
}


</style>
</head>


<body>


<?php if(isset($_GET['msg'])): ?>
<div class="alerta">
    <?php
        if($_GET['msg'] == 'reenviado') echo "Novo código enviado";
        if($_GET['msg'] == 'verificado') echo "Conta verificada com sucesso!";
    ?>
    <span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>


<div class="container">


    <h2>Verificar Conta</h2>


    <form action="actions/processa_verificacao.php" method="POST">


        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">


        <div class="codigo-container">
            <input maxlength="1" class="codigo" inputmode="numeric">
            <input maxlength="1" class="codigo" inputmode="numeric">
            <input maxlength="1" class="codigo" inputmode="numeric">
            <input maxlength="1" class="codigo" inputmode="numeric">
            <input maxlength="1" class="codigo" inputmode="numeric">
            <input maxlength="1" class="codigo" inputmode="numeric">


            <input type="hidden" name="codigo" id="codigoFinal">
        </div>


        <button type="submit">Verificar</button>


    </form>


    <p class="texto-reenvio">
        Não recebeu o código?
        <a href="#" onclick="document.getElementById('formReenviar').submit(); return false;">
            Reenviar código
        </a>
    </p>


    <form id="formReenviar" action="actions/reenviar_codigo.php" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
    </form>


</div>


<script>
const inputs = document.querySelectorAll(".codigo");
const hidden = document.getElementById("codigoFinal");


// foco inicial
inputs[0].focus();


inputs.forEach((input, index) => {


    input.addEventListener("input", (e) => {
        e.target.value = e.target.value.replace(/\D/g, "");


        if (e.target.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }


        atualizarCodigo();
    });


    input.addEventListener("keydown", (e) => {


        if (e.key === "Backspace" && !input.value && index > 0) {
            inputs[index - 1].focus();
        }


    });
});


function atualizarCodigo(){
    let codigo = "";


    inputs.forEach(i => {
        codigo += i.value;
    });


    hidden.value = codigo;
}
</script>


</body>
</html>
