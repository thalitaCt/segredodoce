<?php
include '../includes/conexao.php';


$email = $_POST['email'];
$codigo = rand(100000, 999999);


// atualiza código no banco
$sql = $pdo->prepare("
    UPDATE usuarios
    SET codigo_verificacao = ?
    WHERE email = ?
");


$sql->execute([$codigo, $email]);


// SENDGRID API
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
                <h1>$codigo</h1>
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


if ($httpCode >= 400) {
    error_log("Erro SendGrid: " . $response);
}


header("Location: ../verificar.php?email=$email&msg=reenviado");
exit;
?>

