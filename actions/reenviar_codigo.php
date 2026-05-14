<?php
include '../includes/conexao.php';


/* =========================
   PEGAR EMAIL
========================= */


$email = $_POST['email'] ?? null;


if (empty($email)) {
    header("Location: ../login.php?erro=email");
    exit;
}


/* =========================
   VERIFICAR USUÁRIO
========================= */


$sql = "SELECT id_usuario FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$usuario) {
    header("Location: ../verificar.php?erro=codigo");
    exit;
}


/* =========================
   GERAR CÓDIGO
========================= */


$codigo = random_int(100000, 999999);


/* =========================
   ATUALIZAR CÓDIGO NO BANCO
========================= */


$sql = $pdo->prepare("
    UPDATE usuarios
    SET codigo_verificacao = ?
    WHERE email = ?
");


$sql->execute([$codigo, $email]);


/* =========================
   ENVIO EMAIL (SENDGRID)
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
    "subject" => "Novo código de verificação",
    "content" => [
        [
            "type" => "text/html",
            "value" => "
                <h2>Seu novo código</h2>
                <h1 style='letter-spacing:5px;'>$codigo</h1>
                <p>Use este código para verificar sua conta.</p>
            "
        ]
    ]
];


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
   LOG DE ERRO (SE FALHAR EMAIL)
========================= */


if ($httpCode >= 400) {
    error_log("Erro SendGrid: " . $response);
}


/* =========================
   REDIRECIONAR
========================= */


header("Location: ../verificar.php?email=$email&msg=reenviado");
exit;
?>