<?php
$email = $_GET['email'] ?? null;


/* =========================
   VALIDA EMAIL
========================= */


if (!$email) {
    header("Location: login.php?erro=login");
    exit;
}
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
}


button:hover{
    background:#ffe1d8;
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

    top:25px;
    right:25px;

    padding:18px 22px;

    border-radius:16px;

    display:flex;
    align-items:center;
    gap:15px;

    z-index:9999;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.25);

    font-weight:600;

    animation:aparecer 0.3s ease;
}

.sucesso{
    background:#22c55e;
    color:white;
}

.erro{
    background:#ef4444;
    color:white;
}

.fechar{
    cursor:pointer;
    margin-left:10px;
}

@keyframes aparecer{

    from{
        opacity:0;
        transform:translateY(-10px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}
</style>
</head>


<body>


<!-- ALERTAS -->
<?php if(isset($_GET['msg'])): ?>
<div class="alerta sucesso">
<i class="fa-solid fa-circle-check"></i>
    <?php
        if($_GET['msg'] == 'reenviado') echo "Novo código enviado";
        if($_GET['msg'] == 'verificado') echo "Conta verificada com sucesso!";
    ?>
           <span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>


<?php if(isset($_GET['erro'])): ?>
<div class="alerta erro">
<i class="fa-solid fa-triangle-exclamation"></i>
    <?php
        if($_GET['erro'] == 'codigo') echo "Código inválido.";
        if($_GET['erro'] == 'nao_verificado') echo "Conta não verificada.";
    ?>
           <span class="fechar" onclick="this.parentElement.style.display='none'">X</span>
</div>
<?php endif; ?>




<div class="container">


    <h2>Verificar Conta</h2>


    <form action="actions/processa_verificacao.php" method="POST" id="formVerificacao">


        <!-- EMAIL -->
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">


        <!-- CÓDIGO -->
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
const form = document.getElementById("formVerificacao");


/* foco inicial */
inputs[0].focus();


/* digitação */
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


/* colar código */
inputs[0].addEventListener("paste", (e) => {
    let paste = (e.clipboardData || window.clipboardData).getData("text");
    paste = paste.replace(/\D/g, "").slice(0, 6);


    inputs.forEach((input, i) => {
        input.value = paste[i] || "";
    });


    atualizarCodigo();
});


/* atualizar hidden */
function atualizarCodigo(){
    let codigo = "";
    inputs.forEach(i => codigo += i.value);
    hidden.value = codigo;
}


/* validação antes de enviar */
form.addEventListener("submit", (e) => {
    if (hidden.value.length !== 6) {
        e.preventDefault();
        alert("Digite o código completo");
    }
});
</script>


</body>
</html>
