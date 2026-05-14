<?php
include '../includes/conexao.php';


/* =========================
   PEGAR EMAIL
========================= */


$email = $_POST['email'] ?? null;


if (empty($email)) {
    header("Location: ../esqueci_senha.php?erro=email");
    exit;
}


/* =========================
   BUSCAR USUÁRIO
========================= */


$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


/* =========================
   SE NÃO EXISTIR USUÁRIO
========================= */


if (!$usuario) {
    header("Location: ../esqueci_senha.php?erro=email");
    exit;
}


/* =========================
   PEGAR NOME (seguro)
========================= */


$nome = 'Usuário';


if ($usuario['tipo'] === 'cliente') {
    $sqlNome = $pdo->prepare("SELECT nome FROM clientes WHERE usuario_id = ?");
} else {
    $sqlNome = $pdo->prepare("SELECT nome FROM funcionarios WHERE usuario_id = ?");
}


$sqlNome->execute([$usuario['id_usuario']]);
$user = $sqlNome->fetch(PDO::FETCH_ASSOC);


if (!empty($user['nome'])) {
    $nome = $user['nome'];
}


/* =========================
   GERAR TOKEN
========================= */


$token = bin2hex(random_bytes(16));
$expira = date("Y-m-d H:i:s", strtotime("+1 hour"));


/* =========================
   SALVAR TOKEN
========================= */


$sql = "UPDATE usuarios 
        SET token = :token, token_expira = :expira 
        WHERE email = :email";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    'token' => $token,
    'expira' => $expira,
    'email' => $email
]);


/* =========================
   LINK DE RECUPERAÇÃO
========================= */


$link = "http://segredodoce.onrender.com/nova_senha.php?token=$token";


/* =========================
   SENDGRID
========================= */


$apiKey = getenv('SENDGRID_API_KEY');


$data = [
    "personalizations" => [
        [
            "to" => [
                ["email" => $email]
            ]
        ]
    ],
    "from" => [
        "email" => "confeitariasegredoce@gmail.com",
        "name" => "Segredo Doce"
    ],
    "subject" => "Recuperação de Senha",
    "content" => [
        [
            "type" => "text/html",
            "value" => "
                <h2>Recuperação de Senha</h2>
                <p>Olá, $nome</p>
                <p>Clique no botão abaixo para redefinir sua senha:</p>


                <div style='margin:20px 0;'>
                    <a href='$link'
                       style='background:#ff877d;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;'>
                       Redefinir Senha
                    </a>
                </div>


                <p style='font-size:12px;color:#777;'>
                    Este link expira em 1 hora.
                </p>
            "
        ]
    ]
];


/* =========================
   ENVIO EMAIL
========================= */


$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


curl_close($ch);


/* =========================
   LOG DE ERRO (opcional)
========================= */


if ($httpCode >= 400) {
    error_log("Erro SendGrid: " . $response);
}


/* =========================
   REDIRECIONAR
========================= */


header("Location: ../login.php?msg=email_enviado");
exit;
?>
