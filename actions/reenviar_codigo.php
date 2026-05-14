<?php
include '../includes/conexao.php';


$email = $_POST['email'] ?? null;


/* VALIDAÇÃO BÁSICA */
if (empty($email)) {
    header("Location: ../verificar.php?erro=email");
    exit;
}


/* VERIFICAR SE USUÁRIO EXISTE */
$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$sql->execute([$email]);


$usuario = $sql->fetch(PDO::FETCH_ASSOC);


if (!$usuario) {
    header("Location: ../verificar.php?erro=email_invalido");
    exit;
}


/* GERAR CÓDIGO MAIS SEGURO */
$codigo = random_int(100000, 999999);


/* ATUALIZAR CÓDIGO NO BANCO */
$sql = $pdo->prepare("
    UPDATE usuarios
    SET codigo_verificacao = ?
    WHERE email = ?
");


$sql->execute([$codigo, $email]);


/* SENDGRID API */
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
                <h1 style='letter-spacing:4px;'>$codigo</h1>
                <p>Use este código para verificar sua conta.</p>
                <p style='font-size:12px;color:#777;'>Se não foi você, ignore este email.</p>
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


/* LOG DE ERRO */
if ($httpCode >= 400) {
    error_log("Erro SendGrid: " . $response);
}


/* REDIRECIONAMENTO */
header("Location: ../verificar.php?email=$email&msg=reenviado");
exit;
?>